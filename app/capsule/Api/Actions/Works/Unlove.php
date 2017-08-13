<?php namespace Capsule\Api\Actions\Works;

use DB,Sentry;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Unlove extends Base {

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
		/*$where=array('user_id'=>$work->user_id,'record_date'=>date("Y-m-d",(time()-86400)));
		$res_record=DB::table("users_records")->where($where)->get();
		if($res_record){
			$dig = ($res_record[0]->dig-1)>0 ? $res_record[0]->dig-1 : 0;
			DB::update("UPDATE users_records SET dig = ".$dig." WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$work->user_id);
		}else{
			DB::table('users_records')->insert(array('user_id' => $work->user_id, 'record_date' => date("Y-m-d",time()),'login'=>0,'dig'=>0,'work'=>0,'topic'=>0,'push'=>0));		
		}*/
		$res_user=DB::table("users")->where("id","=",$work->user_id)->get();
		DB::update("UPDATE users SET score = ".($res_user[0]->score-3)." WHERE id = ".$work->user_id);
		$loveCount = $work->love_count;
		return $this->printJSON(compact('status', 'loveCount'));
	}
}