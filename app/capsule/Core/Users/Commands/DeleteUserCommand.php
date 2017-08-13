<?php namespace Capsule\Core\Users\Commands;

class DeleteUserCommand {

	public $id;
	public $user;

	public function __construct($id, $user)
	{
		$this->id   = $id;
		$this->user = $user;
	}
}