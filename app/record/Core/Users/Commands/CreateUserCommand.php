<?php namespace Record\Core\Users\Commands;

class CreateUserCommand {

	public $user;
	public $username;
	public $email;
	public $password;
	public $password_confirmation;
	public $activated;
	
	public function __construct($username, $email, $password, $password_confirmation, $activated, $user)
	{
		$this->username              = $username;
		$this->email                 = $email;
		$this->password              = $password;
		$this->password_confirmation = $password_confirmation;
		$this->activated             = $activated;
		$this->user                  = $user;
	}
}