<?php namespace Capsule\Core\Orders;

use Capsule\Core\Entity;

class Order extends Entity {
	protected $table   = "orders";
	public static function start($work_id, $user_id, $content, $timeline, $f_id=0)
	{
		$comment = new static;
		$comment->user_id    = $user_id;
		$comment->work_id   = $work_id;
		$comment->content      = $content;
		$comment->timeline      = $timeline;
		$comment->f_id      = $f_id;
		return $comment;
	}
}