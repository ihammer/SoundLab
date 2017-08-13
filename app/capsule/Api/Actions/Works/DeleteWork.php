<?php namespace Capsule\Api\Actions\Users;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Core\Albums\Album;

class DeleteWork extends Base {

	protected $user;
	protected $work;
	protected $album;

	public function __construct(User $user,Work $work,Album $album)
	{
		$this->user = $user;
		$this->work = $work;
		$this->album = $album;
	}

	public function run()
	{
		$user = Sentry::getUser();
		$album = $this->album->findOrFail($this->input("album_id"));
		$workIds = $this->input("work_id_list");
		if (!empty($workIds) && is_array($workIds)) {
			foreach ($workIds as $k => $v) {
				$work = $this->work->findOrFail($v);
				DB::table('albums_works')->where(array('work_id' => $work->id, 'album_id' => $this->input("album_id")))->delete();
			}
			return Response::json(['status' => 'ok']);
		}else{
			return Response::json(['status' => 'faild']);
		}
	}
}