<?php namespace Capsule\Api\Actions\Users;
use DB,Response,Sentry;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\UserBasicSerializer;

class UserAuthenticationInfo extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	public function run()
	{
		
        $userid = abs(intval($this->param('uid')));

		$data = DB::table('user_authentication')->where('userid','=',$userid)->get();
        
		return Response::json($data);
		
	}
}