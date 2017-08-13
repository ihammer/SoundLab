<?php namespace Capsule\Api\Actions\Messages;
use DB,Sentry,Queue,Response;
use Capsule\Core\Messages\Message;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\MessageSerializer;
use Illuminate\Redis\Database as Redis;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Thank extends Base {

	public function run()
	{
		if(empty($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException();
		}
		//$user = User::find(37);
		$id = $this->input('id');
		$messages = Message::find($id);
		$action = explode(":",$messages->action);
		$pushuser = User::find($action[4]);
		$work = Work::find($action[1]);
		if($action[2]=='pay'){
			$message=new message();
			$message->userid=$pushuser->id;
			$message->devicetoken=$pushuser->devicetoken;
			if($work){
				$message->message=$user->username.'感谢你打赏了他的声音作品「'.$work->title."」";
			}else{
				$message->message=$user->username.'感谢你打赏了他的声音作品';
			}
			$message->action='work:'.$action[1].':thank:people:'.$user->id;
			$message->save();
			if($pushuser->devicetoken!="")
			{				
				Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
			}
			$action[2]='payed';
		}elseif($action[2]=='love'){
			$message=new message();
			$message->userid=$pushuser->id;
			$message->devicetoken=$pushuser->devicetoken;
			if($work){
				$message->message=$user->username.'感谢你赞了他的声音作品「'.$work->title."」";
			}else{
				$message->message=$user->username.'感谢你赞了他的声音作品';
			}
			$message->action='work:'.$action[1].':thank:people:'.$user->id;
			$message->save();
			if($pushuser->devicetoken!="")
			{
				Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
			}
			$action[2]='loved';
		}
		$messages->action = implode(":",$action);
		$messages->save();
		return Response::json(['thank' => 'success']);	
	}
}