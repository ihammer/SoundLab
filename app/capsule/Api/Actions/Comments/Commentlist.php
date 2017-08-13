<?php namespace Capsule\Api\Actions\Comments;
use DB, Sentry;
use Capsule\Core\Comments\Comment;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\CommentSerializer;

class Commentlist extends Base {

	protected $comment;
	
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}
	public function run()
	{
		$user = Sentry::getUser();
		$id   = abs(intval($this->param('id')));//echo $id;exit;
		$commentsTotal = DB::table('works_comments')->where('work_id','=',$id)->whereNull("works_comments.deleted_at")->count();
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 10);
		list($pages, $page) = $this->calculatePagination($commentsTotal, $page, $count);
		$start = ($page - 1) * $count;
		$comments = DB::table('works_comments')->leftJoin("users as userA","works_comments.user_id","=","userA.id")->leftJoin("users as userB","works_comments.f_id","=","userB.id")->where("works_comments.work_id","=",$id)->whereNull("works_comments.deleted_at")->orderBy('works_comments.created_at', 'desc')->select("works_comments.*","userA.username","userA.avatar","userB.username as tun")->skip($start)->take($count)->get();
		//$comments = DB::table('works_comments')->leftJoin("users","works_comments.user_id","=","users.id")->where("works_comments.work_id","=",$id)->orderBy('timeline', 'asc')->get();
		$serializer = new CommentSerializer();
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$this->document->addMeta('total', $commentsTotal);
                if($user){
		$this->document->addMeta('uid', $user->id);
		$this->document->addMeta('username', $user->username);
		$this->document->addMeta('avatar', $user->avatar);
                }
		$document = $this->document->setData($serializer->collection($comments));
		return $this->respondWithDocument($document);
	}
}
