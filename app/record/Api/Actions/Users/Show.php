<?php namespace Record\Api\Actions\Users;

use Sentry, Response, DB;
use Record\Api\Actions\Base;
use Record\Core\Users\User;
use Record\Api\Serializers\UserSerializer;


class Show extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$uid  = abs(intval($this->param('uid')));
		//$user = $this->user->findOrFail($uid);
		//echo  $user->username;
		$user=$this->user->find($uid);
                echo '<pre>';
		print_r($user);
                echo '</pre>';
                exit;
		$serializer = new UserSerializer();
		$document = $this->document->setData($serializer->resource($user));
                return $this->respondWithDocument($document);
	}
}