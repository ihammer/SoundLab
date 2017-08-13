<?php namespace Capsule\Api\Actions\Common;

use DB, Sentry, Input, Response;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Actions\Base;

class Isloginscore extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$user = Sentry::getUser();
		//$user = User::find(45);
		if ( !$user ) 
		{
			return Response::json(array('state'=>'errors'));
		}else {
			if($user->isRelogin==0){
				$user->isRelogin=1;
				$user->save();
				return Response::json(array('state'=>'errors'));
			}
			$smc=Message::where(array('userid'=>$user->id,'isread'=>0))->where('action','like','%people%')->count();
			if($user->id!=1){
				DB::update("UPDATE users SET last_login = '".date("Y-m-d H:i:s",time())."' WHERE id = ".$user->getId());
				$where=array('user_id'=>$user->getId(),'record_date'=>date("Y-m-d",(time()-86400)));
				$res=DB::table("users_records")->where($where)->get();
				if($res){
					$ret=array('state'=>'success','login'=>$res[0]->login,'dig'=>$res[0]->dig,'work'=>$res[0]->work,'topic'=>$res[0]->topic,'push'=>$res[0]->topic,'loginscore'=>1,'digscore'=>3,'workscore'=>5,'topicscore'=>10,'pushscore'=>50);
				}else{
					$ret=array('state'=>'success','login'=>0,'dig'=>0,'work'=>0,'topic'=>0,'push'=>0,'loginscore'=>1,'digscore'=>3,'workscore'=>5,'topicscore'=>10,'pushscore'=>50);
				}
				$where1=array('user_id'=>$user->getId(),'record_date'=>date("Y-m-d",time()));
				$res1=DB::table("users_records")->where($where1)->get();
				if($res1 && $res1[0]->login==1){
					$ret['sign']='errors';
				}elseif($res1 && $res1[0]->login==0){
					DB::update("UPDATE users_records SET login = 1 WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$user->getId());
					DB::update("UPDATE users SET score = score+1 WHERE id = ".$user->getId());
					$ret['sign']='success';
				}else{
					DB::update("UPDATE users SET score = score+1 WHERE id = ".$user->getId());
					DB::table('users_records')->insert(array('user_id' => $user->getId(), 'record_date' => date("Y-m-d",time()),'login'=>1,'dig'=>0,'work'=>0,'topic'=>0,'push'=>0));
					$ret['sign']='success';
				}
				$resUser=DB::table("users")->where("id","=",$user->getId())->get();
				$ret['score']=$resUser[0]->score;
				$ret['systemmessages']=$smc;
				return Response::json($ret);
			}else{
					$ret=array('state'=>'success','login'=>0,'dig'=>0,'work'=>0,'topic'=>0,'push'=>0,'loginscore'=>1,'digscore'=>3,'workscore'=>5,'topicscore'=>10,'pushscore'=>50,'sign'=>"success","score"=>$user->score);
				$ret['systemmessages']=$smc;
				return Response::json($ret);
			}
			//return Response::json(['success' => 'success','uid' => $user->id,'username' => $user->username,'avatar' => 'http://7xikb7.com1.z0.glb.clouddn.com/'.$user->avatar]);
		}
		exit;
	}
}