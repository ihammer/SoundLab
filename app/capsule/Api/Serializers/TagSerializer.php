<?php namespace Capsule\Api\Serializers;

use Capsule\Core\Tags\Tag;

class TagSerializer extends BaseSerializer {
	
	protected $type = "tags";
	
	protected function attributes($tag)
	{
		$attributes = [
			'name'   => $tag->name,
			'count'  => $tag->count,
		];
		return $attributes;
	}
	// protected function includeAuthor(Tag $tag, $relations)
	// {		
	// 	return (new UserBasicSerializer($relations))->resource($tag->author);
	// }
}