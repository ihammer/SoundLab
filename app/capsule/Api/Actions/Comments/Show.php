<?php namespace Capsule\Api\Actions\Comments;
use DB;
use Capsule\Core\Comments\Comment;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\CommentSerializer;

class Show extends Base {

	protected $comment;
	
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}
	public function run()
	{
		$id   = abs(intval($this->param('id')));
		//$comments = DB::table('works_comments')->leftJoin("users","works_comments.user_id","=","users.id")->where("works_comments.work_id","=",$id)->where("works_comments.f_id","=",0)->orderBy('timeline', 'asc')->get();
		$comments = DB::table('works_comments')->leftJoin("users","works_comments.user_id","=","users.id")->where("works_comments.work_id","=",$id)->whereNull("works_comments.deleted_at")->orderBy('timeline', 'asc')->get();
		$serializer = new CommentSerializer();
		$counts = count($comments);
		$this->document->addMeta('count', $counts);
		$document = $this->document->setData($serializer->collection($comments));
		return $this->respondWithDocument($document);
	}
}