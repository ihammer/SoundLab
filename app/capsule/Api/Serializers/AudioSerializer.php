<?php namespace Capsule\Api\Serializers;

use Capsule\Core\Audios\Audio;

class AudioSerializer extends BaseSerializer {
	
	protected $type = "audios";

	protected function attributes($audio)
	{
		$attributes = [
			'title'   => $audio->title,
			'cover'   => "http://7xikb7.com1.z0.glb.clouddn.com/".$audio->cover,
			'audio'   => "http://7xikb7.com1.z0.glb.clouddn.com/".$audio->audio,
		];
		return $attributes;
	}
}