<?php namespace Capsule\Api\Actions\Tags;
use DB;
use Capsule\Api\Actions\Base;


class Topic extends Base {
	
	public function run()
	{
		$count=DB::table("tags")->where("is_recommand1","=",1)->count();
		$list["meta"]["pages"]=intval(ceil($count/5));
		if(isset($_GET["p"])){
			$list["meta"]["page"]=intval($_GET["p"]);
		}else{
			$list["meta"]["page"]=1;
		}
		$start=($list["meta"]["page"]-1)*5;
		$list["data"]=DB::table("tags")->where("is_recommand1","=",1)->select("name")->skip($start)->take(5)->orderBy("date1","desc")->get();//return $list;exit;
		$list["meta"]["liubing"]= array("一饼","二饼","三饼");
		return $list;exit;
	}
}