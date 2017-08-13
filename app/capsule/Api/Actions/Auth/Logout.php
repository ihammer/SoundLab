<?php namespace Capsule\Api\Actions\Auth;

use Sentry,DB;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class Logout extends Base {

	public function run()
	{
		if ( !empty( $user = Sentry::getUser() )) 
		{
			$user->devicetoken=NULL;
			$user->save();
		}
		Sentry::logout();
		return $this->respondWithoutContent();
	}
}