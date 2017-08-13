<?php namespace Capsule\Api\Actions\Users;

use Sentry, Input, Response;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Change extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$user = Sentry::getUser();
		//$user = $this->user->findOrFail($this->param('uid'));
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}
		$password = $this->input('password');
		$repassword = $this->input('repassword');
		if($password==$repassword){
			$user->changePassword($password)->save();
			return Response::json(['status' => true]);
		}
	}
}