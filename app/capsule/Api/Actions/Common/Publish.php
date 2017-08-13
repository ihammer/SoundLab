<?php namespace Capsule\Api\Actions\Common;
require("/var/www/capsule2/vendor/pili-sdk-php-master/lib/Pili.php");
use Capsule\Api\Actions\Base;

class Publish extends Base {
	public function run()
	{
		//$QINIU_ACCESS_KEY = "uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ";
        //$QINIU_SECRET_KEY = "P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B";
		define('ACCESS_KEY', 'uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ');
		define('SECRET_KEY', 'P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B');
		define('HUB', 'soundlab');
		$credentials = new \Qiniu\Credentials(ACCESS_KEY, SECRET_KEY);
		$hub = new \Pili\Hub($credentials, HUB);
		try {
		    $title           = NULL;     // optional, auto-generated as default
		    $publishKey      = NULL;     // optional, auto-generated as default
		    $publishSecurity = NULL;     // optional, can be "dynamic" or "static", "dynamic" as default
		
		    $stream = $hub->createStream($title, $publishKey, $publishSecurity); # => Stream Object
		
		    //echo "createStream() =>\n";
		    //var_export($stream);
		    //echo "\n\n";
		
		} catch (Exception $e) {
		    echo 'createStream() failed. Caught exception: ',  $e->getMessage(), "\n";
		}
		try {
		    $streamId = $stream->id;
		
		    $stream = $hub->getStream($streamId); # => Stream Object
		
		    //echo "getStream() =>\n";
		    //var_export($stream);
		    //echo "\n\n";
		
		} catch (Exception $e) {
		    echo "getStream() failed. Caught exception: ",  $e->getMessage(), "\n";
		}
		try {
		    $marker       = NULL;      // optional
		    $limit        = NULL;      // optional
		    $title_prefix = NULL;      // optional
		    $status       = NULL;      // optional, "connected" only
		
		    $result = $hub->listStreams($marker, $limit, $title_prefix, $status); # => Array
		
		    //echo "listStreams() =>\n";
		    //var_export($result);
		    //echo "\n\n";
		
		} catch (Exception $e) {
		    echo "listStreams() failed. Caught exception: ",  $e->getMessage(), "\n";
		}
		$result = $stream->toJSONString(); # => string
		//echo "Stream toJSONString() =>\n";
		return $result;
		//echo "\n\n";
		//return '1111';
	}
}