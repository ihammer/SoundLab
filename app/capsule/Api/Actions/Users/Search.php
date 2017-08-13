<?php namespace Capsule\Api\Actions\Users;

use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\UserBasicSerializer;

class Search extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	public function run()
	{
		$q = $this->input('q');
		$query = $this->user->newQuery();
		if ( $q )  
		{
			$query = $query->where('username', 'like', '%'.$q.'%');
		}
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 15);
		$start = ($page - 1) * $count;

		$users = $query->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		$serializer = new UserBasicSerializer();
        $document = $this->document->setData($serializer->collection($users));
        return $this->respondWithDocument($document);
	}
}