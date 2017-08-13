<?php namespace Capsule\Api\Actions\Tags;

//use DB;
//use Capsule\Api\Actions\Base;

use Response, Sentry, Queue;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Illuminate\Redis\Database as Redis;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Discovernew extends Base {
	
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function run()
	{
		if ( !($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException('user authorize failed');
		}
		//$uid=$user->getId();
		echo 123;exit;
		$users=DB::table("users")->where("id","<",$uid)->select("id")->take(3)->orderBy("id","desc")->get();
		foreach($users as $item){
			$followedUser = $this->user->findOrFail($item->id);
			if ( $user->follow($followedUser) ) 
			{
				$user->increment('follow_count');
				$followedUser->increment('fans_count');
				if($followedUser->devicetoken!="")
				{
					$message->userid=$followedUser->id;
					$message->devicetoken=$followedUser->devicetoken;
					$message->message='你又有新的粉丝了！';
					$message->save();
					Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
				}
			}
		}
		/*****************************************************************************************************************************
		$tagTotal=DB::table("tags")->where("is_recommand2","=",1)->count();
		$pages=ceil($tagTotal/9);
		$page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
		$list=DB::table("tags")->where("is_recommand2","=",1)->select("id","name","is_recommand1","count")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();//return $list;exit;
		foreach($list as $keys=>$items)
		{
			$works["data"][$keys]["tag"]=$items->name;
			$works["data"][$keys]["usertag"]=$items->is_recommand1;
			$works["data"][$keys]["count"]=$items->count;//DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->select("works.id","works.title","works.cover","works.view_count","works.love_count")->orderBy("works.id","desc")->count();
			$works["data"][$keys]["works"]=DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->select("works.id","works.title","works.cover","works.view_count","works.love_count")->orderBy("works.id","desc")->take(12)->get();
			for($i=0;$i<count($works["data"][$keys]["works"]);$i++){
				$works["data"][$keys]["works"][$i]->cover="http://7xikb7.com1.z0.glb.clouddn.com/".$works["data"][$keys]["works"][$i]->cover."!cover";
			}
		}
		$works["meta"]["page"]=$page;
		$works["meta"]["pages"]=$pages;
		return $works;
		/*****************************************************************************************************************************/
	}
}