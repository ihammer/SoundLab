<?php namespace Capsule\Api\Actions\Users;

use Sentry, Response, DB, Input;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\UsersMessages\UserMessage;
use Capsule\Api\Serializers\UserSerializer;

class Talk extends Base {

	protected $user;

	public function __construct(User $user, UserMessage $usermessage)
	{
		$this->user = $user;
		$this->usermessage = $usermessage;
	}

	public function run()
	{
		/**/if ( !($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException('user authorize failed');
		}/**///$user=User::find(65);
		$uid=$this->param('uid');
		$count=DB::table("users_messages")->where(array("user_id"=>$user->getId(),"touser"=>$uid))->orwhere(array("touser"=>$user->getId(),"user_id"=>$uid))->count();
		if($count==0){
			if($user->score>2){
				if($this->input("confirm",0)==1){
					$user->score=$user->score-3;
					$user->save();
					$um=new UserMessage();
					$um->user_id=$user->id;
					$um->touser=$uid;
					$um->save();
					return Response::json(['status' => true]);
					exit;
				}
				return Response::json(['status' => true]);
			}else{
				return Response::json(['status' => false]);
			}
		}else{
			return Response::json(['status' => 2]);
		}
	}
}