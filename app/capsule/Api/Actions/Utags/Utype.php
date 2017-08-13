<?php namespace Capsule\Api\Actions\Utags;

use Response, Sentry, Queue, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Utags\Utag;

class Utype extends Base {
	
	public function run()
	{
		
		$utypes=DB::table("utypes")->select('id','name')->get();
		
	    return Response::json($utypes);
	  
	}
}