<?php namespace Capsule\Api\Actions\Works;

use DB, Sentry;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Unlovenew extends Base {

	protected $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		if ( empty( $user = Sentry::getUser() ) ) 
		{
			throw new UserUnauthorizedException();
		}
		$id = abs(intval($this->param('id')));
		$work = $this->work->findOrFail($id);
		$status = false;
		if ( $work->love_count < 0 ) 
		{
			$work->love_count = 0;
			$work->save();
		}
		if ( $user->unLike($work) ) 
		{
			if ( $work->decrement('love_count') ) 
			{
				$status = true;
			}
		}
		$loveCount = $work->love_count;
		//DB::update("UPDATE users_records SET dig = dig－1 WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$work->user_id);
		//DB::update("UPDATE users SET score = score－3 WHERE id = ".$work->user_id);
		return $this->printJSON(compact('status', 'loveCount'));
	}
}