<?php namespace Capsule\Api\Actions;
/*use DB;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;


class Test extends Base {
	
	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$work=$this->work->findOrFail(898);
		$a=DB::table("tags")->leftJoin("works_tags", "tag_id","=","id")->where("work_id","=",$work->id)->orderBy("works_tags.id","asc")->select("tags.name","works_tags.id")->get();
		var_dump($a);
	}
}*/
use DB,Queue;
//use Capsule\Api\Actions\Base;
use Symfony\Component\Process\Process;

class Testtest extends Base{
	
	/*protected $message;
	
	public function __construct(Message $message )
	{
		$this->message  = $message;
	}*/
	public function run(){
		return DB::table('test')->get();
	}
	/*public function run()
	{
		$list=DB::table("tags")->where("is_recommand2","=",1)->select("id","name")->skip(($_GET["p"]-1)*9)->take(9)->orderBy("date2","desc")->get();var_dump( $list );var_dump( DB::getQueryLog());exit;
		Queue::push('Capsule\Core\Push@run', array('id' => 275));
		echo 123;exit;
		//$job->delete();
		//echo 123;exit;
		$message = $this->message->find($this->input("id"));
		$messages=$message->message;
		$body = array("aps" => array("alert" => $messages ,"badge" => 1,"sound"=>'default'),"action"=>"work","detail"=>"495");  //推送方式，包含内容和声音
		$ctx = stream_context_create();
		stream_context_set_option($ctx,"ssl","local_cert","/var/www/capsule2/public/ck.pem");
		$pass = "love&peace118";
		stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
		$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
		$payload = json_encode($body);
		$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
		if (!$fp) {
			echo "Failed to connect $err $errstrn";
			return;
		}
		print "Connection OK\n";
		$msg = chr(0) . pack("n",32) . pack("H*", str_replace(' ', '', $message->devicetoken)) . pack("n",strlen($payload)) . $payload;
		fwrite($fp, $msg);
		$message->ispush=1;
		$message->save();
		fclose($fp);
	}*/
}