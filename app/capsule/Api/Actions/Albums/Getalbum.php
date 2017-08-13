<?php namespace Capsule\Api\Actions\Albums;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Albums\Album;
use Capsule\Core\Works\Work;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Getalbum extends Base {

	protected $user;
	protected $album;

	public function __construct(User $user,Album $album, Work $work)
	{
		$this->user = $user;
		$this->album = $album;
		$this->work  = $work;
	}

	public function run()
	{
		$uid  = abs(intval($this->param('uid')));
		$aid  = intval($this->param('aid'));
		$me   = Sentry::getUser();
		$isMe = $me && $me->getId() === $uid;
		if ( $isMe ) 
		{
			$user = $me;
		} else 
		{
			$user = $this->user->findOrFail($uid);
		}
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}
		$workIds = DB::table('albums_works')->where(array('album_id'=>$aid))->lists('work_id');
                $redata = DB::table('albums')->where(array('id'=>$aid))->get();
                $num = $redata[0]->num; 
		$workNums = $this->work->whereIn('id',$workIds)->orderBy('created_at', 'asc')->count();
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 10);
		$start = ($page - 1) * $count;
		list($pages, $page) = $this->calculatePagination($workNums, $page, $count);
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
	        $this->document->addMeta('num', $num);
		$works  = $this->work->whereIn('id',$workIds)->skip($start)->take($count)->orderBy('created_at', 'desc')->get();

		$serializer = new WorkBasicSerializer();
        $document = $this->document->setData($serializer->collection($works));

        return $this->respondWithDocument($document);
	}
}
