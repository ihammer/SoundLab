<?php namespace Capsule\Api\Actions\Users;
use DB,Sentry,Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Api\Serializers\UserSerializer;

class Ranking extends Base {
	
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function run()
	{
		// $userTotal=DB::table("users")->where("works_count",">",0)->count();
		// $pages=ceil($userTotal/12);
		// $page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
		// $list=DB::table("users")->where("works_count",">",0)->where("persist_code","<>","null")->select("id","username","avatar","introduce","sex","location")->orderBy("last_login","desc")->skip(($page-1)*12)->take(12)->get();//return $list;exit;
		// $me = Sentry::getUser();//if($me){return $me->getId();exit;}
		// foreach($list as $key=>$items)
		// {
		// 	$works["data"][$key]["id"]=$items->id;
		// 	$works["data"][$key]["username"]=$items->username;
		// 	$works["data"][$key]["avatar"]="http://7xikb7.com1.z0.glb.clouddn.com/".$items->avatar."!cover";
		// 	$works["data"][$key]["introduce"]=$items->introduce;
		// 	$works["data"][$key]["sex"]=$items->sex;
		// 	$works["data"][$key]["location"]=$items->location;
		// 	$user = $this->user->findOrFail($items->id);
		// 	$works["data"][$key]["follow"]=0;
		// 	if($me){
		// 		if( $me->isFollowing($user) && !($user->isFollowing($me)) )
		// 		{
		// 			$works["data"][$key]["follow"]=1;
		// 		}elseif( $me->isFollowing($user) && $user->isFollowing($me) )
		// 		{
		// 			$works["data"][$key]["follow"]=2;
		// 		}
		// 	}
		// 	$works["data"][$key]["works"]=DB::table("works")->where(array("user_id"=>$items->id,"is_musician"=>1,"deleted_at"=>null))->select("works.id","works.title","works.cover","works.view_count","works.love_count")->orderBy("id","desc")->get();
		// 	for($i=0;$i<count($works["data"][$key]["works"]);$i++){
		// 		$works["data"][$key]["works"][$i]->cover="http://7xikb7.com1.z0.glb.clouddn.com/".$works["data"][$key]["works"][$i]->cover."!cover";
		// 	}
		// }
		// $works["meta"]["page"]=$page;
		// $works["meta"]["pages"]=$pages;
		// return $works;exit;
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 10);
		$start = ($page - 1) * $count;

	    $userRanks=DB::table("users")->select("id","username","avatar","introduce","score")->orderBy('score', 'desc')->skip($start)->take($count)->get();

	  	if (!empty($userRanks)) {
	  		foreach ($userRanks as &$v) {
	  			$v->avatar  =  "http://7xikb7.com1.z0.glb.clouddn.com/".$v->avatar."!cover";
	  			$v->type    =  '民谣';
	  		}
	  	}

		//$user = Sentry::getUser();
		$where= array('user_id'=>5094,'record_date'=>date("Y-m-d",time()));
		$records = DB::table("users_records")->where($where)->get();

		$list   = $this->user->findOrFail(5094);

		$result['status'] = 0;
		$result['msg']    = 'success';
		$result['reward_text'] ='第一名：100元，第二名：200元';
		$result['rank_data']  = $userRanks;
		$today_point = $records[0]->dig + $records[0]->login + $records[0]->work + $records[0]->topic+ $records[0]->push;
		$result['my_point_data'] = array(
			'love'    => array('count'=>$records[0]->dig, 'limit'=> 0, 'point'=>3), 
			'login'   => array('count'=>$records[0]->login, 'limit'=> 1, 'point'=>1), 
			'publish' => array('count'=>$records[0]->work, 'limit'=> 1, 'point'=>5), 
			'activity' => array('count'=>$records[0]->topic, 'limit'=> 1, 'point'=>10), 
			'contribution' => array('count'=>$records[0]->push, 'limit'=> 1, 'point'=>50),
			'today_point' => $today_point >0 ? $today_point : 0,
			'total_point' => $list->score,
			'reward_exchange'=> 0.12
		);
		return Response::json($result);
		exit;
	}
}
