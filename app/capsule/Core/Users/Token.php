<?php namespace Capsule\Core\Users;

use Capsule\Core\Entity;

class Token extends Entity {

	protected $table = "users_token";

	public function user()
	{
		return $this->belongsTo('Capsule\Core\Users\User');
	}
}