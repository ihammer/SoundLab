<?php namespace Capsule\Api\Actions\Tags;
use DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Tags\Tag;
use Capsule\Api\Serializers\TagSerializer;

class Reg extends Base {
	
	public function run()
	{
		$tags=DB::table("tags")->where("is_recommand3","=",1)->take(10)->get();//return $list;exit;
		$serializer = new TagSerializer();
    $document = $this->document->setData($serializer->collection($tags));
    return $this->respondWithDocument($document);
	}
}