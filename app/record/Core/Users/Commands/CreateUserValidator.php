<?php namespace Record\Core\Users\Commands;

use Record\Core\Support\CommandValidator;

class CreateUserValidator extends CommandValidator {

	protected $rules = [
		'username' => 'required',
		'email'    => 'required|email',
		'password' => 'required|confirmed',
	];
}