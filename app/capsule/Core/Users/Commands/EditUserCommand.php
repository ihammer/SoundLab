<?php namespace Capsule\Core\Users\Commands;

class EditUserCommand {
	
	public $user;
	public $id;
	public $username;
	public $mobile;
	public $sex;
	public $avatar;
	public $password;
	public $location;
	public $tags;
	public $persons;
	public $introduce;

	public function __construct($id, $username=null, $sex=null, $avatar=null, $password=null, $mobile=null, $location=null, $tags=null, $persons=null, $introduce=null, $user)
	{
		$this->id       = $id;
		$this->username = $username;
		$this->sex      = $sex;
		$this->avatar   = $avatar;
		$this->password = $password;
		$this->mobile   = $mobile;
		$this->location = $location;
		$this->tags     = $tags;
		$this->persons  = $persons;
		$this->introduce  = $introduce;
		$this->user     = $user;
	}
}