<?php namespace Capsule\Core\Works\Commands;

class DeleteWorkCommand {

	public $id;
	public $user;
		
	public function __construct($id, $user)
	{
		$this->id   = $id;
		$this->user = $user;
	}
}