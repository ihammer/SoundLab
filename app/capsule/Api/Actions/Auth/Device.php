<?php namespace Capsule\Api\Actions\Auth;

use Response, DB;
use Capsule\Api\Actions\Base;

class Device extends Base {

	public function run()
	{
			DB::insert('insert into device (devicetoken,created_at) values(?,?)',array($_POST["deviceToken"],date("Y-m-d H:i:s",time())));
			if(isset($_POST["uid"])){
				DB::update("UPDATE users SET devicetoken = '".$_POST["deviceToken"]."' WHERE id = ".$_POST["uid"]);
			}
			return Response::json(['status' => true]);
	}
}