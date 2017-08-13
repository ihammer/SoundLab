<?php namespace Capsule\Core\Tags\Commands;

class CreateTagCommand {

	public $user;
	public $name;
	public $recommand;

	public function __construct($name, $recommand, $user)
	{
		$this->name      = $name;
		$this->recommand = $recommand;
		$this->user      = $user;
	}
}