<?php namespace Capsule\Core\Works\Events;

use Capsule\Core\Works\Work;

class WorkWasStarted {

	public $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}
}