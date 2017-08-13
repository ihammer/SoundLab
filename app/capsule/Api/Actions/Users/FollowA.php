<?php namespace Capsule\Api\Actions\Users;

use Response, Sentry, Queue, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Illuminate\Redis\Database as Redis;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class FollowA extends Base {

	protected $user;

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
		$persons  = isset($_POST["persons"]) ? $this->input('persons') : "";
		//return $this->input('persons');exit;
		$message=new message();
		if ( $persons!="" ) 
		{
			foreach($persons as $key => $item){
				$followedUser = $this->user->findOrFail($item);
				if ( $user->follow($followedUser) ) 
				{
					$user->increment('follow_count');
					$followedUser->increment('fans_count');
					/*if($followedUser->devicetoken!="")
					{
						$message->userid=$followedUser->id;
						$message->devicetoken=$followedUser->devicetoken;
						$message->message=$user->username.' 成为了你的新粉丝';
						$message->action='people:'.$user->getId();
						$message->save();
						Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
					}*/
				}
			}
		}
		$users=DB::table("users")->where("id","<",$user->id)->select("id")->take(3)->orderBy("id","desc")->get();
		foreach($users as $item){
			$followedUser = $this->user->findOrFail($item->id);
			if ( $user->follow($followedUser) ) 
			{
				$user->increment('follow_count');
				$followedUser->increment('fans_count');
				/*if($followedUser->devicetoken!="")
				{
					$message->userid=$followedUser->id;
					$message->devicetoken=$followedUser->devicetoken;
					$message->message=$user->username.' 成为了你的新粉丝';
					$message->action='people:'.$user->getId();
					$message->save();
					Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
				}*/
			}
		}
		return Response::json(['status' => true]);
	}
	
	protected function tagKey($user)
	{
		return "users:".$user->getId().":following";
	}
}