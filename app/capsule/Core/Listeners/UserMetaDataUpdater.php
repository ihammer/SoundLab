<?php namespace Capsule\Core\Listeners;

use Capsule\Core\Users\Events\UserWasRegistered;
use Laracasts\Commander\Events\EventListener;

class UserMetaDataUpdater extends EventListener {

	public function whenUserWasRegistered(UserWasRegistered $event)
	{
		// 
	}
}