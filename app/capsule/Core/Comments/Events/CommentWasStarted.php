<?php namespace Capsule\Core\Comments\Events;

use Capsule\Core\Comments\Comment;

class CommentWasStarted {

	public $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}
}