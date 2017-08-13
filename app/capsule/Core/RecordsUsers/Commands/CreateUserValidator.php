<?php namespace Capsule\Core\RecordsUsers\Commands;

use Capsule\Core\Support\CommandValidator;

class CreateUserValidator extends CommandValidator {

	protected $rules = [
		'username' => 'required',
		'email'    => 'required|email',
		'password' => 'required|confirmed',
	];
}