<?php namespace Capsule\Core\Tags\Commands;

use Capsule\Core\Support\CommandValidator;

class DeleteTagValidator extends CommandValidator {
	protected $rules = [
		'id' => 'required',
	];
}