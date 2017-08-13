<?php namespace Capsule\Core\Works\Commands;

use Capsule\Core\Support\CommandValidator;

class CreateWorkValidator extends CommandValidator {
	protected $rules = [
		'title'    => 'required|max:120',
		'images'   => 'required|array',
		'uploadId' => 'required',
		'persons'  => 'array',
		'texts'    => 'array',
		'isPrivate'=> 'boolean',
	];
}