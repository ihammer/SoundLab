<?php namespace Capsule\Api\Actions\Works;

use DB,Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Commands\DeleteWorkCommand;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Delete extends Base {
	
	public function run()
	{
		if ( empty( $user = Sentry::getUser() )) 
		{
			throw new UserUnauthorizedException();
		}

		if ( !$id = intval($this->param('id')) ) 
		{
			throw new \InvalidArgumentException();
		}
		$list=DB::table("works_tags")->where("work_id","=",$id)->get();
		foreach($list as $keys=>$items)
		{
			DB::update("update tags set count=count-1 where id=?",array($items->tag_id));
		}
		$work = $this->execute(DeleteWorkCommand::class, compact('id', 'user'));
		return $this->respondWithoutContent();
	}
}