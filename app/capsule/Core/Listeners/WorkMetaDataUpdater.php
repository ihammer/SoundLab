<?php namespace Capsule\Core\Listeners;

use Capsule\Core\Works\Events\WorkWasStarted;
use Capsule\Core\Works\Events\WorkWasDeleted;

use Laracasts\Commander\Events\EventListener;

class WorkMetaDataUpdater extends EventListener {

	public function whenWorkWasStarted(WorkWasStarted $event)
	{
		// 用户作品数 ＋ 1
		$event->work->author->increment('works_count');
	}
	
	public function whenWorkWasDeleted(WorkWasDeleted $event)
	{
		// 用户作品数 － 1
		$event->work->author->decrement('works_count');
	}
}