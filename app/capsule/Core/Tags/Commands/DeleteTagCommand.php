<?php namespace Capsule\Core\Tags\Commands;

class DeleteTagCommand {
	
	public $id;
	public $user;
	
	public function __construct($id, $user)
	{
		$this->id   = $id;
		$this->user = $user;
	}
}