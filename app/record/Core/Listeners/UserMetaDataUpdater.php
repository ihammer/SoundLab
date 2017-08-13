<?php namespace Record\Core\Listeners;

use Record\Core\Users\Events\UserWasRegistered;
use Laracasts\Commander\Events\EventListener;

class UserMetaDataUpdater extends EventListener {

	public function whenUserWasRegistered(UserWasRegistered $event)
	{
		// 
	}
}