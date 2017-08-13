<?php namespace Capsule\Api\Serializers;
use DB;
use Capsule\Core\Comments\Comment;

class CommentSerializer extends BaseSerializer {
	
	protected $type = "works_comments";

	protected function attributes($comment)
	{
		//$user=DB::table('users')->find($comment->user_id);
		$attributes = [
			'work_id'   => $comment->work_id,
			'user_id'  => $comment->user_id,
			'content'   => $comment->content,
			'timeline'  => $comment->timeline,
			'username'  => $comment->username,
			'avatar'  => "http://7xikb7.com1.z0.glb.clouddn.com/".$comment->avatar,
			'fid'     => $comment->f_id,
			'tousername'  => isset($comment->tun) ? $comment->tun :"",
			'reviewtime'  => $comment->created_at,
		];
		return $attributes;
	}
}