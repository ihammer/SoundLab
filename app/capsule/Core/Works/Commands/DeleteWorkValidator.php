<?php namespace Capsule\Core\Works\Commands;

use Capsule\Core\Support\CommandValidator;

class CreateWorkValidator extends CommandValidator {
	protected $rules = [
		'id' => 'required',
	];
}