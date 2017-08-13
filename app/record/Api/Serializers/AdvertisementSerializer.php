<?php namespace Capsule\Api\Serializers;

use Capsule\Core\Tags\Tag;

class AdvertisementSerializer extends BaseSerializer {
	
	protected $type = "adv";
	
	protected function attributes($advertisement)
	{
		$attributes = [
			'title'   => $advertisement->title,
			'image'  => $advertisement->image,
			'url'  => $advertisement->url,
		];
		return $attributes;
	}
	// protected function includeAuthor(Tag $tag, $relations)
	// {		
	// 	return (new UserBasicSerializer($relations))->resource($tag->author);
	// }
}