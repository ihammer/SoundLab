<?php namespace Capsule\Api\Actions\Comments;

use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Comments\Comment;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Del extends Base {

	protected $user;
	protected $comment;

	public function __construct(Comment $comment,User $user)
	{
		$this->user = $user;
		$this->comment = $comment;
	}
	
	public function run()
	{
		if ( empty($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException();
		}
		$id=$this->param('id');
		$comment=$this->comment->findOrFail($id);
		$workid=$comment->work_id;
		/*if($comment->f_id!=$user->id){
			return Response::json(['success' => 'failed']);
		}*/
		$comment->delete();

        //弹幕量-1
        DB::table('works')->where("id","=",$workid)->decrement('comments_count');

		$comments = DB::table('works_comments')->leftJoin("users","works_comments.user_id","=","users.id")->where("works_comments.work_id","=",$workid)->whereNull("works_comments.deleted_at")->orderBy('timeline', 'asc')->get();
		$counts = strval(count($comments));
		return Response::json(['success' => 'success','count'=>$counts]);
	}
}