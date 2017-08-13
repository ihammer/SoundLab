<?php namespace Capsule\Api\Actions\Users;

use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Api\Serializers\UserBasicSerializer;

class Recommand extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$count = $this->input('limit', 15);
		$recommandIds = $this->user->where('recommand', '=', '1')->lists('id');
		$ids = [];
		if ( $recommandIds ) 
		{
			shuffle($recommandIds);
			$ids = array_slice($recommandIds, 0, $count);
		}
		$users = $this->user->whereIn('id', $ids)->get();
		$serializer = new UserBasicSerializer();
        $document = $this->document->setData($serializer->collection($users));
        return $this->respondWithDocument($document);
	}
}