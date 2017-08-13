<?php namespace Capsule\Core\RecordsAudios\Events;

use Capsule\Core\RecordsAudios\Audio;

class AudioWasStarted {

	public $audio;

	public function __construct(Audio $audio)
	{
		$this->audio = $audio;
	}
}