<?php namespace Capsule\Api\Actions\RecordsUsers;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\RecordsUsers\User;

class Test extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$uid  = abs(intval($this->param('uid')));
		$user = $this->user->findOrFail($uid);
		echo $user->username;
	}
}