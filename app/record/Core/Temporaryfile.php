<?php namespace Capsule\Core;

class Temporaryfile extends Entity {

	const TYPE_AUDIO    = 1;
	const TYPE_IMAGE    = 2;
	const TYPE_AVATAR   = 3;

	protected $table   = "files";
	protected $guarded = [];

	public function findByUrl($url)
	{
		return $this->newQuery()->where('url', '=', $url)->first();
	}

	public function getPayloadAttribute()
	{
		return json_decode($this->attributes('payload'), true);
	}

	public function checkType($type)
	{
		$checked = false;
		switch ($type) 
		{
			case self::TYPE_AUDIO:
			case self::TYPE_IMAGE:
			case self::TYPE_AVATAR:
				$checked = true;
				break;
		}
		return $checked;
	}
	
	public function getWidth()
	{
		return array_get($this->payload, 'width', 0);
	}

	public function getHeight()
	{
		return array_get($payload, 'height', 0);
	}

	public function isImage()
	{
		if ( $this->getWidth() < 0 ) 
		{
			return false;
		}
		return true;
	}
}