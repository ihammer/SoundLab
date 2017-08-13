<?php namespace Capsule\Core\RecordsUsers\Events;

use Capsule\Core\RecordsUsers\User;

class UserAvatarWasChanged {

	protected $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}
}