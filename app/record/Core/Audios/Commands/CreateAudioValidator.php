<?php namespace Capsule\Core\RecordsAudios\Commands;

use Capsule\Core\Support\CommandValidator;

class CreateAudioValidator extends CommandValidator {
	protected $rules = [
		'title'    => 'required|max:120',
		'uploadId' => 'required',
	];
}