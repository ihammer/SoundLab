<?php namespace Capsule\Api\Actions\Albums;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Albums\Album;

class Edit extends Base {

	protected $album;

	public function __construct(Album $album)
	{
		$this->album = $album;
	}

	public function run()
	{
		$user = Sentry::getUser();
		$album = $this->album->findOrFail($this->input("album_id"));
		if($user->getId()==$album->user_id){
			if($this->input("isDeleteAlbum")==0){
				$album->albumtitle	= $this->input("albumName");
				$album->desc	=	$this->input("albumDescription");
				$album->save();
			}else{
				$album->delete();
			}
			return Response::json(['status' => 'ok']);
		}else{
			return Response::json(['status' => 'faild']);
		}
	}
}