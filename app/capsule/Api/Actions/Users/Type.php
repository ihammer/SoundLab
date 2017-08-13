<?php namespace Capsule\Api\Actions\Users;
use DB, Response;
use Capsule\Api\Actions\Base;

class Type extends Base {
	
	public function run()
	{
		$type=DB::table("utypes")->select("id","name")->get();
		return $type;
	}
}