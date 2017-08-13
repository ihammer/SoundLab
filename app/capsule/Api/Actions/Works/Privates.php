<?php namespace Capsule\Api\Actions\Works;

use DB,Sentry,Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Privates extends Base {
	
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
		//$list=DB::table("works_tags")->where("work_id","=",$id)->get();
		//foreach($list as $keys=>$items)
		//{
		//	DB::update("update tags set count=count-1 where id=?",array($items->tag_id));
		//}
		//$work = $this->execute(DeleteWorkCommand::class, compact('id', 'user'));
		$private = $this->input('private');
		if($private==1){
			DB::update('update works set is_private = 1 where id = ?', array($id));
		}else{
			DB::update('update works set is_private = 0 where id = ?', array($id));
		}
		//return $this->respondWithoutContent();
		return Response::json(['status' => true]);
	}
}