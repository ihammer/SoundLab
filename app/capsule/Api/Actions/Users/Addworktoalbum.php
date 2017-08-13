<?php namespace Capsule\Api\Actions\Users;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Core\Albums\Album;

class Addworktoalbum extends Base {

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
        if(is_string($workIds)){
            $workIds=json_decode($workIds);
        }
		if (!empty($workIds) && is_array($workIds)) {
			foreach ($workIds as $k => $v) {
				$work = $this->work->findOrFail($v);
				//if($user->getId()==$album->user_id && $user->getId()==$work->user_id){ //安卓没有获取用户信息，临时调整为下面
				if($album->user_id ==$work->user_id){ //临时修改  2017/0724 wudean
					$works = DB::table('albums_works')->where(array('work_id' => $v, 'album_id' => $this->input("album_id")))->get();
					if (!$works) {
						DB::table('albums_works')->insert(array('work_id' => $v, 'album_id' => $this->input("album_id")));
					}
				}
			}
			return Response::json(['status' => 'ok']);
		}else{
			return Response::json(['status' => 'faild']);
		}
	}
}