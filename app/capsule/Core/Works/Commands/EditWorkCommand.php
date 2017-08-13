<?php namespace Capsule\Core\Works\Commands;

class EditWorkCommand {

	public $user;

	public $id;
	
	public function __construct($id, $user)
	{
		$this->id   = $id;
		$this->user = $user;
	}
}