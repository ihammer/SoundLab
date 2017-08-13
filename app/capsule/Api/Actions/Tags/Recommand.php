<?php namespace Capsule\Api\Actions\Tags;

use Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Tags\Tag;
use Capsule\Api\Serializers\TagSerializer;

// 推荐的标签
class Recommand extends Base {

	protected $tag;

	protected static $count = 10;

	public function __construct(Tag $tag)
	{
		$this->tag = $tag;
	}
	
	public function run()
	{
		$count = $this->input('limit', self::$count);
		$tags = $this->tag->Recommand()->orderBy('count', 'desc')->take($count)->get();
		$serializer = new TagSerializer();
        $document = $this->document->setData($serializer->collection($tags));
        return $this->respondWithDocument($document);
	}
}