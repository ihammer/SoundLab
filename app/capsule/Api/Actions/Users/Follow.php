<?php namespace Capsule\Api\Actions\Users;

use Response, Sentry, Queue,Cache;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Illuminate\Redis\Database as Redis;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Follow extends Base {

	protected $user;
	protected $message;

	public function __construct(User $user,Message $message)
	{
		$this->user = $user;
		$this->message = $message;
	}
	
	public function run()
	{
		if ( !($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException('user authorize failed');
		}
		$followID  = $this->param('uid');
		if ( !$followID ) 
		{
			return $this->responseWithError('ArgumentNotEnough', 200, "Missing field \"uid\"");
		}
		$followedUser = $this->user->findOrFail($followID);
		if ( $user->follow($followedUser) ) 
		{
			$user->increment('follow_count');
			$followedUser->increment('fans_count');
			if($followedUser->devicetoken!="")
			{
				$message=new message();
				$message->userid=$followedUser->id;
				$message->devicetoken=$followedUser->devicetoken;
				$message->message=$user->username.' 成为了你的新粉丝';
				$message->action='people:'.$user->getId();
				$message->save();
				Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
			}
                        Cache::forget('user_works_data');
			return Response::json(['status' => true]);
		}
		return Response::json(['status' => false]);
	}
	
	protected function tagKey($user)
	{
		return "users:".$user->getId().":following";
	}
}
