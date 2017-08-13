<?php namespace Capsule\Api\Actions\Utags;

use Response, Sentry, Queue, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Utags\Utag;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Submittest extends Base {

	protected $utag;

	public function __construct(Utag $utag)
	{
		$this->utag = $utag;
	}
	
	public function run()
	{
		if ( !($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException('user authorize failed');
		}
		$uid=$user->getId();
		$futag=DB::table("users_tags")->where("user_id","=",$uid)->select("tag_id")->get();
		if(count($futag)!=0){
			foreach($futag as $item){
				$utag=$this->utag->where("id","=",$item->tag_id)->decrement('count');
			}
			DB::table("users_tags")->where("user_id","=",$uid)->delete();
		}
		$tags  = isset($_POST["tags"]) ? json_decode($_POST["tags"]) : "";
		if($tags!=""){
			foreach($tags as $item){
				DB::table("users_tags")->insert(array('tag_id' => $item, 'user_id' => $uid));
				$utag=$this->utag->where("id","=",$item)->increment('count');
			}
		}
		return Response::json(['status' => true]);
	}
}