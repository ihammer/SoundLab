<?php namespace Capsule\Api\Actions\Common;

use DB, Sentry, Input, Response;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Actions\Base;

class Islogin extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$user = Sentry::getUser();
		if ( !$user ) 
		{
			return 'errors';
		}else {
			DB::update("UPDATE users SET last_login = '".date("Y-m-d H:i:s",time())."' WHERE id = ".$user->getId());
			return 'success';
			//return Response::json(['success' => 'success','uid' => $user->id,'username' => $user->username,'avatar' => "http://7xikb7.com1.z0.glb.clouddn.com/".$user->avatar]);
		}
		exit;
	}
}