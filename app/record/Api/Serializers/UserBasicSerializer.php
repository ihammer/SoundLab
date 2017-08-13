<?php namespace Record\Api\Serializers;

use Record\Core\Users\User;

class UserBasicSerializer extends BaseSerializer {

	protected $type = 'users';
    
    protected function attributes($user)
    {
        $attributes = [
            'username'  => $user->username,
            'avatar'    => $user->avatar,
            'location'  => $user->location,
            'sex'       => strval($user->sex),
            'introduce' => $user->introduce,
            'score' => $user->score,
            'account' => $user->account,
        ];
        return $attributes;
    }
}