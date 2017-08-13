<?php namespace Capsule\Api\Actions\Users;

use Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\UserBasicSerializer;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Follower extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	public function run()
	{
		$uid  = abs(intval($this->param('uid')));
		$me   = Sentry::getUser();
		$isMe = $me && $me->getId() === $uid;
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 15);
		$start = ($page - 1) * $count;
		if ( $isMe ) 
		{
			$user = $me;
		} else
		{
			$user = $this->user->findOrFail($uid);
		}
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}
		$users = $user->follower()->orderBy('users_follower.addtime', 'desc')->skip($start)->take($count)->get();		
		$serializer = new UserBasicSerializer();
        $document = $this->document->setData($serializer->collection($users));

        return $this->respondWithDocument($document);
	}
}