<?php namespace Capsule\Api\Actions\Works;

use DB, Sentry, Queue;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Lovenew extends Base {

	protected $work;
	protected $user;

	public function __construct(Work $work,User $user)
	{
		$this->work = $work;
		$this->user = $user;
	}
	public function run()
	{
		if ( empty( $user = Sentry::getUser() ) ) 
		{
			throw new UserUnauthorizedException();
		}

		$id = abs(intval($this->param('id')));
		$work = $this->work->findOrFail($id);
		if ( $work->love_count < 0) 
		{
			$work->love_count = 0;
			$work->save();
		}

		$status = false;
		if ( $user->like($work) ) 
		{
			if ( $work->increment('love_count') ) 
			{
				$status = true;
			}
		}
		$loveCount = strval($work->love_count);
		$pushuser=$this->user->findOrFail($work->user_id);
		//$work->user_id
		DB::update("UPDATE users_records SET dig = dig＋1 WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$work->user_id);
		DB::update("UPDATE users SET score = score+3 WHERE id = ".$work->user_id);
		if($pushuser->devicetoken!="")
		{
			$message=new message();
			$message->userid=$pushuser->id;
			$message->devicetoken=$pushuser->devicetoken;
			$message->message='你的声音作品「'.$work->title."」又有人点赞了";
			$message->action='work:'.$id;
			$message->save();
			Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
		}
		return $this->printJSON(compact('status', 'loveCount'));
	}
}