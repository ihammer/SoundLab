<?php namespace Record\Api\Serializers;

use Record\Core\Users\User;

class UserSerializer extends UserBasicSerializer {

	protected function attributes($user)
	{
		$attributes = parent::attributes( $user );
		$attributes += [
			'fans_count'   => strval($user->fans_count),
			'follow_count' => strval($user->follow_count),
			'audios_count'  => strval($user->audios_count),
			'videos_count'  => strval($user->videos_count),
		];
		return $attributes;
	}
}