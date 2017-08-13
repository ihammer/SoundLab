<?php namespace Capsule\Api\Actions\Callbacks;

use Response, Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Core\Temporaryfile;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Upload extends Base {

	protected $files;
	protected $tmpfile;
	
	public function __construct(Temporaryfile $tmpfile, Filesystem $files)
	{       
                   ob_end_clean();
		$this->tmpfile = $tmpfile;
		$this->files   = $files;
	}

	public function run()
	{
	
		if ( !$this->isQiniu() ) 
		{
			throw new AccessDeniedHttpException();
		}
		
		if ( $this->request->json() ) 
		{
			$type = $this->input('type');//png 2 json、MP3 1 jpg 3
			$ext = $this->input('ext');//后缀
			if ( !$ext ) 
			{
				$guesser = ExtensionGuesser::getInstance();
				$ext = ".".$guesser->guess($this->input('mime'));
			}
			$key  = "Group".str_pad($type, 2, '0', STR_PAD_LEFT)."/".$this->path($this->input('etag')).$ext;
			$input = [
				'user_id'  => abs(intval($this->input('uid'))), //用户id
				'type'     => intval($type),//png 2 json、MP3 1 jpg 3
				'bucket'   => $this->input('bucket'),//传 test
				'mime'     => strval($this->input('mime')),//后缀
				'url'      => $key,
				'ext'      => trim($ext, '.'),
				'filename' => basename($this->input('fname')),//本地原始文件名
				'filesize' => intval($this->input('fsize')),//大小
				'etag'     => $this->input('etag'),//文件hash码
				'payload'  => strval($this->input('info')),//文件预处理信息
			];
			$tmpfile = $this->tmpfile->create($input);
			$payload = [
				'uploadId' => $tmpfile->getKey(),
				'url'      => $key,
			];


			return Response::json(compact('key', 'payload'));
		}
	}

	public function path($hash)
    {
        $dates = array(date("Y"), date("md"));
        $parts = array_slice(str_split($hash, 2), 0, 2);
        return join('/', $dates) ."/".join('/', $parts)."/".uniqid();
    }
    
	protected function isQiniu()
	{
		$authstr = $this->request->headers->get('Authorization');
		$accessKey = 'uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ';
		$sk        = 'P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B';

		if(strpos($authstr,"QBox ") !=0 )
	    {
	        return false;
	    }
	    $auth = explode(":",substr($authstr,5));
	    if ( count($auth) != 2 OR trim($auth[0]) != $accessKey )
	    {
	    	return false;
	    }
	    // $data = "/index.php/api/upload\n".file_get_contents('php://input');
	    // return $this->url_safe_baseencode(hash_hmac('sha1',$data, $sk, true));
	    return true;
	}

	protected function url_safe_baseencode($str) // URLSafeBase64Encode
	{
	    $find = array('+', '/');
	    $replace = array('-', '_');
	    return str_replace($find, $replace, base64_encode($str));
	}
}
