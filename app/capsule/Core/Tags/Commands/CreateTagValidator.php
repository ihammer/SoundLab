<?php namespace Capsule\Core\Tags\Commands;

use Capsule\Core\Support\CommandValidator;

class CreateTagValidator extends CommandValidator {

	protected $rules = [
		'name'      => 'required|unique:tags|max:20',
		'recommand' => 'boolean',
	];
}