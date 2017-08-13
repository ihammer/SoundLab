<?php namespace Capsule\Api\Actions\Audios;
use DB,Sentry,Response;
use Capsule\Core\Audios\Audio;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\AudioSerializer;

class Index extends Base {

	protected $audio;
	
	public function __construct(Audio $audio)
	{
		$this->audio = $audio;
	}
	public function run()
	{
		$tid   = abs(intval($this->param('tid')));
		$audio = DB::table("audios")->where("type_id","=",$tid)->get();
		$serializer = new AudioSerializer();
		$document = $this->document->setData($serializer->collection($audio));
		return $this->respondWithDocument($document);exit;
	}
}