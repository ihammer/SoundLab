<?php namespace Capsule\Api\Actions\Auth;

use Response, DB;
use Capsule\Api\Actions\Base;

class Version extends Base {

	public function run()
	{
			$data=DB::table("versions")->orderBy("id","desc")->select("version_id","version_update","version_url","created_at")->take(1)->get();
			//var_dump($data);exit;
			return Response::json(array("version"=>$data));
	}
}