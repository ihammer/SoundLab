<?php namespace Capsule\Api\Actions\Users;

use Sentry;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Feeds extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		// redis -> [idlist, timeline]
		$type=isset($_GET["type"]) ? $_GET["type"] : 0;
		if($type==0){
			$order = 'created_at';
		}else{
			$order = 'play_count';
		}
		$isme=0;
		$me = Sentry::getUser();
		$uid  = abs(intval($this->param('uid')));
		if ( $uid ) 
		{
			$user = $this->user->findOrFail($uid);
		}
		if($me && $me->getId() == $uid) 
		{
			$isme=1;
		}
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}
		$page = max(1, abs(intval($this->input('p', 1))));
		$take = 10;
		$maxPage = ceil($user->works_count / $take);
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $maxPage);
		$skip = ($page - 1) * $take;
		if($isme==1){
			$works = $user->works()->skip($skip)->take($take)->orderBy($order, 'desc')->get();
		}else{
			$works = $user->works()->where("is_private","=",0)->skip($skip)->take($take)->orderBy($order, 'desc')->get();
		}
		$serializer = new WorkBasicSerializer();
        $document = $this->document->setData($serializer->collection($works));
        $obj=$document->toArray();
        foreach ($obj['data'] as $kdata=>$vdata) {
            if (empty($vdata['album'])) {
                $obj['data'][$kdata]['album'] = array();
            }
        }
        return $this->respondWithArray($obj);
	}
}