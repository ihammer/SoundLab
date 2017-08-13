<?php namespace Capsule\Core;

use Capsule\Core\Messages\Message;
use Symfony\Component\Process\Process;

class Push {
	
	protected $message;
	
	public function __construct(Message $message )
	{
		$this->message  = $message;
	}

	public function run($job, $data)
	{
		$job->delete();
		$message = $this->message->find($data['id']);
		$messages=$message->message;
		$action=explode(":",$message->action);
		$body = array("aps" => array("alert" => $messages ,"sound"=>'default'),"action"=>$action[0],"detail"=>intval($action[1]));  //推送方式，包含内容和声音 "badge" => 1,
		$ctx = stream_context_create();
		stream_context_set_option($ctx,"ssl","local_cert","/var/www/capsule2/public/ck.pem");
		$pass = "love&peace118";
		stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
		$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
		$payload = json_encode($body);
		$msg = chr(0) . pack("n",32) . pack("H*", str_replace(' ', '', $message->devicetoken)) . pack("n",strlen($payload)) . $payload;
		fwrite($fp, $msg);
		$message->ispush=1;
		$message->save();
		fclose($fp);
	}
}