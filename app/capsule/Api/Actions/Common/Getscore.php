<?php namespace Capsule\Api\Actions\Common;

use DB, Sentry, Input, Response;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Actions\Base;

class Getscore extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$user = Sentry::getUser();
		$where=array('user_id'=>$user->getId(),'record_date'=>date("Y-m-d",time()));
		$res=DB::table("users_records")->where($where)->get();
		//$login=DB::table("users_records")->where("user_id","=",$user->getId())->sum("login");
		//$dig=DB::table("users_records")->where("user_id","=",$user->getId())->sum("dig");
		//$work=DB::table("users_records")->where("user_id","=",$user->getId())->sum("work");
		//$push=DB::table("users_records")->where("user_id","=",$user->getId())->sum("push");
		//$topic=DB::table("users_records")->where("user_id","=",$user->getId())->sum("topic");
		$resUser=DB::table("users")->where("id","=",$user->getId())->get();
		if($res && $res[0]->login==1){
			$ret['sign']='errors';
		}else{
			$ret['sign']='success';
		}
		$ret['score']=$resUser[0]->score;
		//$ret['login']=(int)$login;
		$ret['login']=(int)$res[0]->login;
		$ret['loginscore']=1;
		//$ret['dig']=(int)$dig;
		$ret['dig']=(int)$res[0]->dig;
		$ret['digscore']=3;
		//$ret['work']=(int)$work;
		$ret['work']=(int)$res[0]->work;
		$ret['workscore']=5;
		//$ret['push']=(int)$push;
		$ret['push']=(int)$res[0]->push;
		$ret['pushscore']=50;
		//$ret['topic']=(int)$topic;
		$ret['topic']=(int)$res[0]->topic;
		$ret['topicscore']=10;
		return Response::json($ret);
		exit;
	}
}