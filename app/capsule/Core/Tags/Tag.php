<?php namespace Capsule\Core\Tags;

use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class Tag extends Entity {

	use EventGenerator;

	protected $guarded = [];
	protected $table   = "tags";

	// 标签作者
	public function author()
	{
		return $this->belongsTo('Capsule\Core\Users\User', 'user_id');
	}
	// 作品
	public function works()
	{
		return $this->belongsToMany('Capsule\Core\Works\Work', 'works_tags', 'tag_id', 'work_id');
	}
	// 关注标签的用户
	public function followedUsers()
	{
		return $this->belongsToMany('Capsule\Core\Users\User', 'users_tags', 'tag_id', 'user_id');
	}
	public function scopeRecommand($query)
	{
		return $query->where('is_recommand', '=', 1);
	}
	public function isVisible() {}
	public function hasSubtags() {}
	public function getPath() {}
	public function getStringPath() {}
	public function getParentId() {}
}