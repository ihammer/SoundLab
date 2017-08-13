<?php namespace Capsule\Api\Actions\Works;

use DB, Sentry, Queue;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Core\Jpush;
class Love extends Base {

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
				$work->modified = date("Y-m-d H:i:s",time());
				$work->save();
				$status = true;
			}
		}
		DB::table('users_likes_records')->insert(array('user_id' => $user->id, 'work_id' => $work->id,'created_at'=>date("Y-m-d",time()),'updated_at'=>date("Y-m-d",time())));
		$ulr=DB::table("users_likes_records")->where(array('user_id'=>$user->id,'work_id'=>$work->id))->count();
		$loveCount = strval($work->love_count);
		$pushuser=$this->user->findOrFail($work->user_id);
		$where=array('user_id'=>$work->user_id,'record_date'=>date("Y-m-d",time()));
		$res_record=DB::table("users_records")->where($where)->get();
		if($res_record){
			DB::update("UPDATE users_records SET dig = ".($res_record[0]->dig+1)." WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$work->user_id);
		}else{
			DB::table('users_records')->insert(array('user_id' => $work->user_id, 'record_date' => date("Y-m-d",time()),'login'=>0,'dig'=>1,'work'=>0,'topic'=>0,'push'=>0));		}
		DB::update("UPDATE users SET score = score+3 WHERE id = ".$work->user_id);
		if($pushuser->devicetoken!="" && $ulr <2)
		{
			$message=new message();
			$message->userid=$pushuser->id;
			$message->devicetoken=$pushuser->devicetoken;
			$message->message='你的声音作品「'.$work->title."」又有人点赞了";
			$message->action='work:'.$id.':love:people:'.$user->id;
			$message->save();
                  if(strlen($message->devicetoken)==64){

			Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
		}else{
			$push = new Jpush();
            $devicetoken = $message->devicetoken;
            $messages=$message->message;
            $re = $push->push('android',array($devicetoken),'only',$messages,0,0);
            $array = json_decode($re,1);
            if($array['msg_id']){
            	
				$message->ispush=1;
				$message->save();
				
            }else{
            	
				$message->ispush=0;
				$message->save();
				
            }
		}






		}
		return $this->printJSON(compact('status', 'loveCount'));
	}
}
