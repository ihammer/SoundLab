<?php namespace Capsule\Core\Users\Events;

use Capsule\Core\Users\User;

class UserPasswordWasChanged {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
}
