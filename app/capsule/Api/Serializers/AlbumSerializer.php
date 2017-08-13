<?php namespace Capsule\Api\Serializers;

use Sentry,DB;
use Capsule\Core\Albums\Album;
class AlbumSerializer extends BaseSerializer {
	
	protected $type="albums";
	
	protected function attributes($album)
    {
	    $attributes = [
		    'id'	=>	$album->id,
		    'uid'	=>	$album->user_id,
		    'title'	=>	$album->albumtitle,
		    'desc'	=>	$album->desc,
		    'works'	=>	$album->works,
		];
		return $attributes;
	}
	
}