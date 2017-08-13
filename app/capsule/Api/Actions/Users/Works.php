<?php namespace Capsule\Api\Actions\Users;

use Sentry, DB;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Works extends Base {

	protected $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	public function run()
	{
		if ( empty( $user = Sentry::getUser() )) 
		{
			throw new UserUnauthorizedException();
		}
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 16);	
		$start = ($page - 1) * $count;
		$ids = DB::table('users_following')->where('fromuid', '=', $user->getId())->lists('touid');
		// var_dump($ids);
		// $workIds = [];
		// if ( !empty($ids)) 
		// {
		// 	$workIds = DB::table('feeds')->whereIn('user_id', $ids)->orderBy('timeline', 'desc')->skip($start)->take($count)->lists('work_id');
		// }

		// var_dump($workIds);
		$worksTotal = $this->work->whereIn('user_id', $ids)->count();
		list($pages, $page) = $this->calculatePagination($worksTotal, $page, $count);
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$banner=DB::table("banners")->where("status","=",1)->select("image","type","detail")->get();;
		if($banner){
			$this->document->addMeta('banner', $banner);
		}
		$works = $this->work->with('author', 'tags')->whereIn('user_id', $ids)->where('is_private', '=', '0')->skip($start)->take($count)->orderBy('id', 'desc')->get();		
		$serializer = new WorkBasicSerializer();
        $document = $this->document->setData($serializer->collection($works));
        return $this->respondWithDocument($document);
	}
}