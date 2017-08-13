<?php namespace Capsule\Core\Comments\Events;

use Capsule\Core\Comments\Comment;

class CommentWasDeleted {

	public $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}
}