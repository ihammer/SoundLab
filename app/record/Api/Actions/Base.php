<?php namespace Record\Api\Actions;

use App, Config, Response, Sentry;
use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;
use Capsule\Core\Support\Json\Document;
use Capsule\Core\Support\Exceptions\ArgumentNotEnoughException;
use Capsule\Core\Support\Exceptions\ValidationFailureException;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class Base extends Controller {

    use CommanderTrait;

    protected $request;
    protected $document;
    /*
     * is logged's flag
     *
     */
    protected static $isLogged = null;
    
    abstract protected function run();
    
    public function isLogged()
    {
        if ( is_null(static::$isLogged) ) 
        {
            static::$isLogged = Sentry::check();
        }
        return static::$isLogged;
    }
    public function printJSON($data, $status = 200, $headers = array() ) 
    {
        return Response::json($data, $status, $headers);
    }
    // @TODO Operator
    public function calculatePagination($count, $page = 1, $limit = 15)
    {
        $count = max(0, intval($count));
        $limit = max(0, intval($limit));
        if (0 == $limit && $count) 
        {
            $pages = 1;
        } else 
        {
            $pages = 0 == $count ? 0 : ceil($count / $limit);
        }
        $page = min($pages, max(1, intval($page)));
        return [$pages, $page];
    }
    
    public function getVersion()
    {
        if (!$version = $this->input('app_version') ) 
        {
            $version = 'last version';
        }
        // 
    }

    public function isAjax() {}
    public function isHTTPS() {}
    public function isSecure() {}
    public function needSecure() {}
    // public function sock_post($url,$query){
    //     $data = "";
    //     $info=parse_url($url);
    //     $fp=fsockopen($info["host"],80,$errno,$errstr,30);
    //     if(!$fp){
    //         return $data;
    //     }
    //     $head="POST ".$info['path']." HTTP/1.0\r\n";
    //     $head.="Host: ".$info['host']."\r\n";
    //     $head.="Referer: http://".$info['host'].$info['path']."\r\n";
    //     $head.="Content-type: application/x-www-form-urlencoded\r\n";
    //     $head.="Content-Length: ".strlen(trim($query))."\r\n";
    //     $head.="\r\n";
    //     $head.=trim($query);
    //     $write=fputs($fp,$head);
    //     $header = "";
    //     while ($str = trim(fgets($fp,4096))) {
    //         $header.=$str;
    //     }
    //     while (!feof($fp)) {
    //         $data .= fgets($fp,4096);
    //     }
    //     return $data;
    // }
    public function handle($request, $parameters)
    {
        $this->registerErrorHandlers();
        // $this->filter();
        $this->request = $request;
        $this->parameters = $parameters;
        $this->document = new Document;
        return $this->run();
    }
    
    public function param($key, $default = null)
    {
        return array_get($this->parameters, $key, $default);
    }
    
    public function input($key, $default = null)
    {
        return $this->request->input($key, $default);
    }

    protected function respondWithoutContent($statusCode = 204, $headers = [])
    {
        return Response::make('', $statusCode, $headers);
    }

    protected function respondWithArray($array, $statusCode = 200, $headers = [])
    {
        return Response::json($array, $statusCode, $headers);
    }

    protected function respondWithDocument($document, $statusCode = 200, $headers = [])
    {
        // $headers['Content-Type'] = 'application/vnd.api+json';
        return $this->respondWithArray($document->toArray(), $statusCode, $headers);
    }

    protected function respondWithErrors($errors, $httpCode = 500)
    {
        return Response::json(['errors' => $errors], $httpCode);
    }

    protected function respondWithError($error, $httpCode = 500, $detail = null)
    {
        $error = ['code' => $error];
        if ( $detail ) {
            $error['detail'] = $detail;
        }
        return $this->respondWithErrors([$error], $httpCode);
    }

    protected function registerErrorHandlers()
    {
        if ( Config::get('app.debug')) {
            App::error(function(\Exception $exception, $code) {
                $messages = $exception->getFile() . ":" .$exception->getLine();
                return $this->respondWithError($exception->getMessage() .":". $messages, $code);
            });
        }
        // 参数缺失
        App::error(function(ArgumentNotEnoughException $exception) {
            return $this->respondWithError('ArgumentNotEnough', 400);
        });
        // 参数异常
        App::error(function(\InvalidArgumentException $exception){
            return $this->respondWithError('InvalidArgument', 400);
        });
        // 用户认证失败
        App::error(function(UserUnauthorizedException $exception){
            return $this->respondWithError('UserauthorizeFailed', 401);
        });
        // 资源不存在
        App::error(function (ModelNotFoundException $exception) {
            return $this->respondWithError('ResourceNotFound', 404);
        });
        // 验证失败
        App::error(function (ValidationFailureException $exception) {
            $errors = [];            
            foreach ($exception->getErrors()->getMessages() as $field => $messages) {
                $errors[] = [
                    'code' => 'ValidationFailure',
                    'detail' => implode("\n", $messages),
                    // 'path' => $field
                ];
            }
            return $this->respondWithErrors($errors, 422);
        });
    }
}