<?php namespace Capsule\Api\Actions\Common;

use Str, Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Temporaryfile;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Core\Support\Exceptions\ArgumentNotEnoughException;
use Qiniu\Auth;

class Uptoken extends Base {

    protected static $callbackURL = "http://123.57.1.143/api/upload";

    public function run()
    {
        if ( !$this->isLogged() ) 
        {
        //    throw new UserUnauthorizedException();
        }
       
        $type = intval($this->input('type'));
        if ( !isset($type) ) 
        {
            throw new ArgumentNotEnoughException();
        }
        if ( !in_array($type, [Temporaryfile::TYPE_AUDIO, Temporaryfile::TYPE_IMAGE, Temporaryfile::TYPE_AVATAR]) ) 
        {
            throw new \InvalidArgumentException();
        }
        
        $bucket = $this->getBucket($type);
        $opts = array(
            'insertOnly' => 0,
            'callbackFetchKey' => 1,
            'callbackUrl' => static::$callbackURL,
            'callbackBody' => 'bucket=$(bucket)&key=$(key)&etag=$(etag)&fname=$(fname)&fsize=$(fsize)&mime=$(mimeType)&ext=$(ext)&type=$(x:type)&uid=$(x:uid)',
        );

        if ( $type === Temporaryfile::TYPE_IMAGE OR $type === Temporaryfile::TYPE_AVATAR ) 
        {
            $opts['mimeLimit'] = 'image/jpeg;image/png;image/jpg';
            $opts['callbackBody'] = $opts['callbackBody'].'&info=$(imageInfo)';
        } else
        {
            $opts['callbackBody'] = $opts['callbackBody'].'&info=$(avinfo)';
        }
        $QINIU_ACCESS_KEY = "uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ";
        $QINIU_SECRET_KEY = "P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B";
        $auth = new Auth($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
        $token = $auth->uploadToken($bucket, null, 3600, $opts);
        if ( !$token ) 
        {
            return $this->respondWithError('tokenGeneratorFaild');
        }
     //   return Response::json(compact('token'));
       $output =   Response::json(compact('token'));
         $return_json = trim($output,chr(239).chr(187).chr(191));
        return $output ;
    }
       
   function log_r($logthis)
{
$logFile = date('Y-m-d').'.txt';
 $msg = date('Y-m-d H:i:s').' >>> '.$msg."\r\n";
 file_put_contents($logFile,$msg,FILE_APPEND ); 
} 

 
    protected function getBucket($type)
    {
        return 'test';
    }
}
