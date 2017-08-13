<?php namespace Capsule\Api\Actions\Tags;
use Sentry,DB,Response;
use Capsule\Api\Actions\Base;


class Hptaglist extends Base {
	
	public function run()
	{
		

			$list=DB::table("tags")->where(array("is_homepage"=>1))->select("id","name")->orderBy("homepage_at","desc")->get();

			
			
		return Response::json($list);exit;
	}
}
