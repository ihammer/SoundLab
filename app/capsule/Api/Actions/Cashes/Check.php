<?php namespace Capsule\Api\Actions\Cashes;

use DB, Sentry, Input, Response;
use Capsule\Core\Cashes\Cash;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Actions\Base;

class Check extends Base {

	protected $cash;

	public function __construct(Cash $cash)
	{
		$this->cash = $cash;
	}

	public function run()
	{
		$user = Sentry::getUser();
		if ( !$user ) 
		{
			return Response::json(['status' => 'errors']);
		}elseif($user->getId()==37){
			return Response::json(['status' => 'success']);
		}else {
			$num=$this->cash->where("user_id","=",$user->getId())->where("created_at",">",date("Y-m-d h:i:s",(time()-(86400*7))))->count();
			if($num==1){
				$cash=$this->cash->where("user_id","=",$user->getId())->where("created_at",">",date("Y-m-d h:i:s",(time()-(86400*7))))->get();
				$datetime=date("Y-m-d",strtotime($cash[0]->created_at));
				return Response::json(['status' => 'errors' , 'datetime' => $datetime]);
			}elseif($num==0){
				return Response::json(['status' => 'success']);
			}
			
		}
		exit;
	}
}