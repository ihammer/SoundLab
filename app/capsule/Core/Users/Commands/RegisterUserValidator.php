<?php namespace Capsule\Core\Users\Commands;

use Capsule\Core\Support\CommandValidator;

class RegisterUserValidator extends CommandValidator {

	protected $rules = [
		'username' => 'required_without:mobile|unique:users',
		'mobile'   => 'required_without:username|unique:users',
		'code'     => 'required_with:mobile',
		'password' => 'required_with:mobile',
	];
}