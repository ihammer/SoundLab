<?php namespace Capsule\Core\RecordsAudios;

use Sentry;
use Capsule\Core\Entity;
use Capsule\Core\RecordsAudios\Events\AudioWasStarted;
use Laracasts\Commander\Events\EventGenerator;

class Audio extends Entity {
	use EventGenerator;
	protected $connection = 'mysql_records';
	protected $table   = "audios";
	protected $appends = array('liked');
	protected $guarded = [];
	//用户喜欢歌曲的列表的缓存， 待放在redis中处理
	protected $likeAttributeCache = array();
	// 作者
	public function author()
	{
		 return $this->belongsTo('Capsule\Core\RecordsUsers\User', 'user_id');
	}
	// 标签
	public function tags()
	{
		return $this->belongsToMany('Capsule\Core\RecordsTags\Tag', 'audios_tags', 'audio_id', 'tag_id');
	}
	
	public function tag()
	{
		return $this->belongsTo('Capsule\Core\RecordsTags\Tag', 'tag_id');
	}
	// 播放地址
	public function getPlayurlAttribute()
	{
		return sprintf("http://7xikb7.com1.z0.glb.clouddn.com/%s", $this->attributes['playurl']);
	}
	public static function start($aud, $title, $duration, $lyrics, $user)
	{
		$audio = new static;
		// user
		$audio->user_id    = $user->getId();
		$audio->username   = $user->username;
		// metadata
		$audio->title      = $title;
		$audio->duration   = $duration;
		$audio->lyrics      = $lyrics;
		$audio->playurl    = trim($aud->url);
		$audio->filesize   = abs(intval($aud->filesize));
		$audio->etag       = $aud->etag;
		$audio->mime       = $aud->mime;
		$audio->filename   = $aud->filename;
		$audio->modified   = date("Y-m-d H:i:s",time());
		// event
		$work->raise(new AudioWasStarted($work));
		return $work;
	}
}