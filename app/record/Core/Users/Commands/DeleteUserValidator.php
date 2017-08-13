<?php namespace Record\Core\Users\Commands;

use Record\Core\Support\CommandValidator;

class DeleteUserValidator extends CommandValidator {

	protected $rules = [
		'id' => 'required',
	];
}