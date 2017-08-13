<?php namespace Capsule\Core\Users\Commands;

use Capsule\Core\Support\CommandValidator;

class DeleteUserValidator extends CommandValidator {

	protected $rules = [
		'id' => 'required',
	];
}