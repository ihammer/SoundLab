<?php namespace Capsule\Core\Utags;

use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class Utag extends Entity {

	use EventGenerator;

	protected $guarded = [];
	protected $table   = "utags";

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