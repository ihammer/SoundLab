<?php namespace Capsule\Api\Actions\Albums;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Albums\Album;

class Check extends Base {

	protected $album;

	public function __construct(Album $album)
	{
		$this->album = $album;
	}

	public function run()
	{
		$user = Sentry::getUser();
		$count=DB::table("albums")->where(array("user_id"=>$user->getId()))->count();
        if($count >=5){
        	return Response::json(['status' => '超过限制 每个用户只能创建5个作品集合']);
        }else{
            return Response::json(['status' => 'ok']);	
        }  
		
		
	}
}
