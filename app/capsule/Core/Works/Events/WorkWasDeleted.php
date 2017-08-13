<?php namespace Capsule\Core\Works\Events;

use Capsule\Core\Works\Work;

class WorkWasDeleted {

	public $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}
}