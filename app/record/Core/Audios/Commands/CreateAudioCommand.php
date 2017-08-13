<?php namespace Capsule\Core\RecordsAudios\Commands;

class CreateAudioCommand {
	// 作者
	public $user;
	// 作品标题 | string
	public $title;
	// 作品标签 | string
	public $tags;
	// 作品播放时间 | integer
	public $duration;
	// 作品歌词 | string
	public $lyrics;
	// audio id
	public $uploadId;
	// play url
	public $playUrl; //可以没有
	// 社交分享
	// public $providers;

	public function __construct($title, $tags, $duration, $uploadId, $playUrl, $lyrics, $user)
	{
		$this->title     = $title;
		$this->tags      = $tags;
		$this->duration  = $duration;
		$this->uploadId  = $uploadId;
		$this->playUrl   = $playUrl;
		$this->lyrics     = $lyrics;
		$this->user      = $user;
	}
}