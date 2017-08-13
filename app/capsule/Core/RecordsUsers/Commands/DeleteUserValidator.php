<?php namespace Capsule\Core\RecordsUsers\Commands;

use Capsule\Core\Support\CommandValidator;

class DeleteUserValidator extends CommandValidator {

	protected $rules = [
		'id' => 'required',
	];
}