<?php namespace Capsule\Api\Actions\Tags;
use Sentry,DB;
use Capsule\Api\Actions\Base;


class Discover extends Base {
	
	public function run()
	{
	        $qiniuhost ="http://7xikb7.com1.z0.glb.clouddn.com/";
        	$user = Sentry::getUser();
		//$userid=$this->input("id");
		$type=intval($this->input('type', 0));
		if($type==1){
                 //音乐活动
			$where=array("is_recommand2"=>1);
			$tagTotal=DB::table("tags")->where($where)->count();
			$pages=ceil($tagTotal/9);
			$page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
			$list=DB::table("tags")->where($where)->select("id","img","name","is_recommand1","count","topicDetail")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
			/*if($user==NULL){
				$list=DB::table("tags")->where($where)->select("id","name","is_recommand1","count")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
			}else{
				$userid=$user->getId();
				$list=DB::table("tags")->where($where)->orwhere(array('user_id'=>$userid,"is_recommand1"=>1))->select("id","name","is_recommand1","count")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
			}*/
		}elseif($type==2){
                        //乐迷活动
			$where=array("is_recommand4"=>1);
			$tagTotal=DB::table("tags")->where($where)->count();
			$pages=ceil($tagTotal/9);
			$page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
			$list=DB::table("tags")->where($where)->select("id","img","name","is_recommand1","count","topicDetail")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
		}else{
                      //全部
                        $where=array("is_recommand1"=>1);
			$tagTotal=DB::table("tags")->where($where)->count();
			$pages=ceil($tagTotal/9);
			$page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
		        $list=DB::table("tags")->where($where)->select("id","img","name","is_recommand1","count","topicDetail")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
                      /*
                 	if($user==NULL){
				$list=DB::table("tags")->where("is_recommand2","=",1)->select("id","img","name","is_recommand1","count","topicDetail")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
			}else{
				$userid=$user->getId();
				$list=DB::table("tags")->where("is_recommand2","=",1)->orwhere(array('user_id'=>$userid,"is_recommand1"=>1))->select("id","img","name","is_recommand1","count","topicDetail")->skip(($page-1)*9)->take(9)->orderBy("date2","desc")->get();
			}
                   */
		}
		foreach($list as $keys=>$items)
		{
			$keys=intval($keys);
			$works["data"][$keys]["tag"]=$items->name;
			$works["data"][$keys]["usertag"]=$items->is_recommand1;
			$works["data"][$keys]["topicDetail"]=$items->topicDetail;
			$works["data"][$keys]["count"]=$items->count;//DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->count();
                        $works["data"][$keys]["img"]=$items->img?$qiniuhost.$items->img:"";
                	$works["data"][$keys]["works"]=DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->select("works.id","works.title","works.cover","works.play_count as view_count","works.love_count")->orderBy("works.love_count","desc")->orderBy("works.play_count","desc")->take(12)->get();
			for($i=0;$i<count($works["data"][$keys]["works"]);$i++){
				$works["data"][$keys]["works"][$i]->cover="http://7xikb7.com1.z0.glb.clouddn.com/".$works["data"][$keys]["works"][$i]->cover."?imageView2/2/w/200";
			}
			if(DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->count()==0){
				 unset($works["data"][$keys]);
			}
                        $works['data'] = array_values($works['data']);
		}
		$works["meta"]["page"]=$page;
		$works["meta"]["pages"]=$pages;
		//return json_encode($works);exit;
		return $works;exit;
	}
}
