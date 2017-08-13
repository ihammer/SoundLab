<?php namespace Capsule\Core\Albums;

use Capsule\Core\Entity;

class Album extends Entity {
	protected $table   = "albums";
	
	// ר������
	public function author()
	{
		return $this->belongsTo('Capsule\Core\Users\User', 'user_id');
	}
	
	// ר����Ʒ
	public function works()
	{
		return $this->belongsToMany('Capsule\Core\Works\Work', 'albums_works', 'album_id', 'work_id');
	}
	
}