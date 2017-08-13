<?php namespace Capsule\Api\Actions\Users;

use Response, Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;

class Wollof extends Base {

	protected $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		if ( empty( $user = Sentry::getUser() ) ) 
		{
			throw new UserUnauthorizedException('user authorize failed');
		}
		$uid  = $this->param('uid');
		if ( !$uid ) 
		{
			return $this->responseWithError('ArgumentNotEnough', 200, "Missing field \"uid\"");
		}
		$followedUser = $this->user->findOrFail($uid);
		if ( $user->unFollow($followedUser) ) 
		{
			$user->decrement('follow_count');
			$followedUser->decrement('fans_count');
			return Response::json(['status' => true]);
		}
		return Response::json(['status' => false]);
	}
}