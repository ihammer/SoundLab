<?php namespace Capsule\Api\Actions\Albums;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Albums\Album;

class Test extends Base {

	protected $user;

	public function __construct(Album $album)
	{
		$this->album = $album;
	}

	public function run()
	{
		$aid  = abs(intval($this->param('aid')));
		$album = $this->album->findOrFail($aid);
		var_dump($album->author);
		var_dump($album->works[0]->title);
	}
}