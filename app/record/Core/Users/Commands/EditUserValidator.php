<?php namespace Record\Core\Users\Commands;
use Record\Core\Support\CommandValidator;
class EditUserValidator extends CommandValidator {
	
	protected $rules = [
		'id' => 'required',
		// 'username' => 'required|unique',
		'sex' => 'in:0,1,2',
	];
}