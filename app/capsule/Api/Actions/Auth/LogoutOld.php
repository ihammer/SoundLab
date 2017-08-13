<?php namespace Capsule\Api\Actions\Auth;

use Sentry,DB;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class LogoutOld extends Base {

	public function run()
	{
		if ( !empty( $user = Sentry::getUser() )) 
		{
			$user->devicetoken=NULL;
			var_dump($user->save());exit;
		}
		var_dump('123');
		Sentry::logout();
		return $this->respondWithoutContent();
	}
}