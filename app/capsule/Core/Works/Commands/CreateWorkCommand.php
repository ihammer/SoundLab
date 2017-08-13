<?php namespace Capsule\Core\Works\Commands;

class CreateWorkCommand {
	// 作者
	public $user;
	// 作品标题 | string
	public $title;
	// 作品标签 | string
	public $tags;
	// 作品播放时间 | integer
	public $duration;
	// 作品图片集合
	public $images;
	// 作品文字集合 | string
	public $texts;
	// 圈人
	public $persons;
	// 是否私有
	public $isPrivate;
	// audio id
	public $uploadId;
	// play url
	public $playUrl; //可以没有
	public $location; //可以没有
	public $locationX; //可以没有
	public $locationY; //可以没有
	public $price; //可以没有
	// 社交分享
	// public $providers;

	public function __construct($title, $waveform, $tags, $duration, $isPrivate, $uploadId, $playUrl, $images, $texts, $persons, $location, $locationX, $locationY, $price, $user)
	{
		$this->title     = $title;
		$this->waveform      = $waveform;
		$this->tags      = $tags;
		$this->duration  = $duration;
		$this->isPrivate = $isPrivate;
		$this->uploadId  = $uploadId;
		$this->playUrl   = $playUrl;
		$this->images    = $images;
		$this->texts     = $texts;
		$this->persons   = $persons;
		$this->user      = $user;
		$this->location  = $location;
		$this->locationX = $locationX;
		$this->locationY = $locationY;
		$this->price = $price;
	}
}