<?php namespace Record\Core\Users\Commands;

use Record\Core\Support\CommandValidator;

class RegisterUserValidator extends CommandValidator {

	protected $rules = [
		'username' => 'required_without:mobile|unique:users',
		'mobile'   => 'required_without:username|unique:users',
		'code'     => 'required_with:mobile',
		'password' => 'required_with:mobile',
	];
}