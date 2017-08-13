<?php namespace Record\Core\Users\Events;

use Record\Core\Users\User;

class UserMobileWasChanged {

	protected $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}
}