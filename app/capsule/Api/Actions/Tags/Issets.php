<?php namespace Capsule\Api\Actions\Tags;
use DB,Response;
use Capsule\Api\Actions\Base;


class Issets extends Base {
	
	public function run()
	{
		$name=$this->input('topicName');
		$count=DB::table("tags")->where("name","=",$name)->count();
		if($count==0){
			return Response::json(['status' => 1]);
		}else{
			return Response::json(['status' => 0]);
		}
	}
}