<?php namespace Capsule\Api\Actions\Users;

use Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\UserBasicSerializer;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

// 关注的用户
class Following extends Base {

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
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 15);
		$start = ($page - 1) * $count;
		// 关系表中取id列表
		// $ids = DB::table('users_relations')->select('follow_id')->where('user_id', $user->getId())->orderBy('created_at', 'desc')->skip()->take()->get('follow_id');
		// $users = $this->user->whereIn('id', $ids)->get();
		$users = $user->following()->orderBy('users_following.addtime', 'desc')->skip($start)->take($count)->get();		
		$serializer = new UserBasicSerializer();
        $document = $this->document->setData($serializer->collection($users));
        return $this->respondWithDocument($document);
	}
}