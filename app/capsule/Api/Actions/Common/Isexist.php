<?php namespace Capsule\Api\Actions\Common;

use DB, Response;
use Capsule\Api\Actions\Base;

class Isexist extends Base {
	
	public function run()
	{
		$mobile=$this->input("mobile");
	        
		$results = DB::select('select * from users where mobile = ? and persist_code<>?', array($mobile,'null'));
        //	$results = DB::select('select * from users where mobile = ?', array($mobile));
		if(isset($results[0]))
		{
			return Response::json(['mobile' => '0']);
		}else{
			return Response::json(['mobile' => '1']);
		}
	}
}
