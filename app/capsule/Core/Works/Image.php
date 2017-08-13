<?php namespace Capsule\Core\Works;

use Capsule\Core\Entity;

class Image extends Entity {
	protected $table = "works_images";
	protected $timestamp = false;
	protected static $unguarded = true;
	protected static $rules = [
		'url'  => 'required',
		'etag' => 'required',

	];
	public function work()
	{
		return $this->belongsTo('Capsule\Core\Works\Work');
	}

	public function height()
	{
		// 
	}

	public function width()
	{
		// 
	}
}