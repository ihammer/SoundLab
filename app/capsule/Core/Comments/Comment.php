<?php namespace Capsule\Core\Comments;

use Sentry;
use Capsule\Core\Entity;
use Capsule\Core\Comments\Events\CommentWasDeleted;
use Capsule\Core\Comments\Events\CommentWasStarted;
use Laracasts\Commander\Events\EventGenerator;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comment extends Entity {

	use EventGenerator, SoftDeletingTrait;

	protected $table   = "works_comments";
	
	public function author()
	{
		return $this->belongsTo('Capsule\Core\Users\User', 'user_id');
	}
	
	public static function start($work_id, $user_id, $content, $timeline, $f_id=0)
	{
		$comment = new static;
		$comment->user_id    = $user_id;
		$comment->work_id   = $work_id;
		$comment->content      = $content;
		$comment->timeline      = $timeline;
		$comment->f_id      = $f_id;
		$comment->raise(new CommentWasStarted($comment));
		return $comment;
	}
}