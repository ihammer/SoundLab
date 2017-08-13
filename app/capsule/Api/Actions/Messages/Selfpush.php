<?php namespace Capsule\Api\Actions\Messages;

use Response, Sentry, Queue;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Selfpush extends Base {

	protected $user;
	protected $message;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function run()
	{
		if ( !($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException('user authorize failed');
		}
		//$user = $this->user->find(69);
		if($user->devicetoken!=""){
			$body = array("aps" => array("alert" => "您有一条新消息" ,"badge" => 1,"sound"=>'default'));  //推送方式，包含内容和声音
			$ctx = stream_context_create();
			stream_context_set_option($ctx,"ssl","local_cert","/var/www/capsule2/public/ck.pem");
			$pass = "love&peace118";
			stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
			$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
			$payload = json_encode($body);
			$msg = chr(0) . pack("n",32) . pack("H*", str_replace(' ', '', $user->devicetoken)) . pack("n",strlen($payload)) . $payload;
			fwrite($fp, $msg);
			fclose($fp);
			return Response::json(['status' => true]);
		}
		return Response::json(['status' => false]);
	}
}