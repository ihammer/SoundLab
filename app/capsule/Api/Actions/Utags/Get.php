<?php namespace Capsule\Api\Actions\Utags;

use Response, Sentry, Queue, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Utags\Utag;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Serializers\UtagSerializer;

class Get extends Base {

	protected $utag;

	public function __construct(Utag $utag)
	{
		$this->utag = $utag;
	}
	
	public function run()
	{
		$uid  = abs(intval($this->param('uid')));
		$utags=DB::table("users_tags")->join("utags","users_tags.tag_id","=","utags.id")->where("user_id","=",$uid)->select("utags.*")->get();
		if($utags){
			$serializer = new UtagSerializer();
	    $document = $this->document->setData($serializer->collection($utags));
	    return $this->respondWithDocument($document);
	  }else{
	    return Response::json(['data' => array()]);
	  }
	}
}