<?php namespace Capsule\Api\Actions\Users;
use DB,Sentry,Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Api\Serializers\UserSerializer;

class Recruit extends Base {
	
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function run()
	{
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 10);
		$start = ($page - 1) * $count;

	    $userRanks=DB::table("users")->select("id","username","avatar","introduce","score")->where("works_count",">",0)->orderBy("last_login","desc")->skip($start)->take($count)->get();

	  	if (!empty($userRanks)) {
	  		foreach ($userRanks as &$v) {
	  			$v->avatar  =  "http://7xikb7.com1.z0.glb.clouddn.com/".$v->avatar."!cover";
	  			$v->type    = '民谣';
	  		}
	  	}

		return Response::json($userRanks);
		exit;
	}
}
