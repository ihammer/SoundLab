<?php namespace Capsule\Core\Works\Commands;

use Capsule\Core\Support\CommandValidator;

class EditWorkValidator extends CommandValidator {
	protected $rules = [
		'id' => 'required',
	];
}