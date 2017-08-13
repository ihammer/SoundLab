<?php namespace Capsule\Api\Serializers;

use Capsule\Core\Utags\Utag;

class UtagSerializer extends BaseSerializer {
	
	protected $type = "utags";
	
	protected function attributes($utag)
	{
		$attributes = [
			'name'   => $utag->name,
			'count'  => $utag->count,
		];
		return $attributes;
	}
	// protected function includeAuthor(Tag $tag, $relations)
	// {		
	// 	return (new UserBasicSerializer($relations))->resource($tag->author);
	// }
}