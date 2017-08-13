<?php namespace Capsule\Core\Works;

use Sentry;
use Capsule\Core\Entity;
use Capsule\Core\Works\Events\WorkWasDeleted;
use Capsule\Core\Works\Events\WorkWasStarted;
use Laracasts\Commander\Events\EventGenerator;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Work extends Entity {

	use EventGenerator, SoftDeletingTrait;

	protected $table   = "works";
	protected $appends = array('liked');
	protected $guarded = [];
	//用户喜欢歌曲的列表的缓存， 待放在redis中处理
	protected $likeAttributeCache = array();
	// 作者
	public function author()
	{
		 return $this->belongsTo('Capsule\Core\Users\User', 'user_id');
	}

	// 标签
	public function tags()
	{
		return $this->belongsToMany('Capsule\Core\Tags\Tag', 'works_tags', 'work_id', 'tag_id');
	}
	
	public function tag()
	{
		return $this->belongsTo('Capsule\Core\Tags\Tag', 'tag_id');
	}
	
	public function type()
	{
		return $this->belongsTo('Capsule\Core\Types\Type', 'type_id');
	}

	// 图片
	public function images()
	{
		return $this->hasMany('Capsule\Core\Works\Image', 'work_id')->orderBy("timeline","asc");
	}

	public function timeline()
	{
		return $this->hasMany('Capsule\Core\Works\Image', 'work_id');
	}

	// 波形
	public function getWaveformAttribute()
	{
		return sprintf("http://7xikb7.com1.z0.glb.clouddn.com/%s", $this->attributes['waveform']);
	}

	// 封面
	public function getCoverAttribute()
	{
		return sprintf("http://7xikb7.com1.z0.glb.clouddn.com/%s?imageView2/2/w/500", $this->attributes['cover']);
	}

	// 播放地址
	public function getPlayurlAttribute()
	{
		return sprintf("http://7xikb7.com1.z0.glb.clouddn.com/%s", $this->attributes['playurl']);
	}

	public function getPersonsAttribute()
	{
		return unserialize($this->attributes['persons']);
	}

//	public function getTextsAttribute()
//	{
//         //  pr($this->attributes);
//		return unserialize($this->attributes['texts']);
//	}

	public function getImagesAttribute()
	{
		return array_map(function($imageURL) {
			return sprintf("http://7xikb7.com1.z0.glb.clouddn.com/%s?imageView2/2/w/500", $imageURL);
		}, $this->images()->orderBy('orderby', "asc")->lists('url'));
	}
	
	public function getTimelineAttribute()
	{
		return array_map(function($timeline,$duration) {
			return sprintf("%f", $timeline/$duration);
		},$this->images()->orderBy('orderby', "asc")->lists('timeline'),$this->images()->leftJoin("works","works_images.work_id","=","works.id")->orderBy('orderby', "asc")->lists('works.duration'));
		//$this->images()->leftJoin("works","works_images.work_id","=","works.id")->orderBy('orderby', "asc")->lists('works_images.timeline/works.duration'));
		//$this->images()->orderBy('orderby', "asc")->lists('timeline'));
	}

	public function getLikedAttribute()
	{
		if ( $user = Sentry::getUser() ) 
		{
			if ( empty($this->likeAttributeCache) ) 
			{
				$this->likeAttributeCache = \DB::table('users_likes')->where('user_id', $user->getId())->lists('work_id');
			}
			if ( in_array($this->getKey(), $this->likeAttributeCache) ) 
			{
				return true;
			}
		}
		return false;
	}

	public function setPersonsAttribute($value)
	{
		$this->attributes['persons'] = serialize($value);
	}

	public function setTextsAttribute($value)
	{
		$this->attributes['texts'] = serialize($value);
	}
	
	public static function nstart($audio, $title, $cover, $duration ,$isPrivate, $texts, $persons, $user)
	{
		$work = new static;
		// user
		$work->user_id    = $user->getId();
		$work->username   = $user->username;
		// metadata
		$work->title      = $title;
		$work->cover      = $cover;
		$work->duration   = $duration;
		$work->is_private = (bool) $isPrivate;
		$work->texts      = $texts;
		$work->persons    = $persons;
		// audio
		$work->playurl    = trim($audio->url);
		$work->filesize   = abs(intval($audio->filesize));
		$work->etag       = $audio->etag;
		$work->mime       = $audio->mime;
		$work->filename   = $audio->filename;
		// event
		$work->raise(new WorkWasStarted($work));
		return $work;
	}
	
	public static function start($audio, $title, $waveform , $cover, $duration ,$isPrivate, $texts, $persons, $location, $locationX, $locationY, $price, $user)
	{
		$work = new static;
		// user
		$work->user_id    = $user->getId();
		$work->username   = $user->username;
		// metadata
		$work->title      = $title;
		$work->location      = $location;
		$work->locationX      = $locationX;
		$work->locationY      = $locationY;
		$work->price      = $price;
		if($price!=0){
			$work->compstatus = 1;
		}
		$work->waveform      = $waveform;
		$work->cover      = $cover;
		$work->duration   = $duration;
		$work->is_private = (bool) $isPrivate;
		$work->texts      = $texts;
		$work->persons    = $persons;
		// audio
		$work->playurl    = trim($audio->url);
		$work->filesize   = abs(intval($audio->filesize));
		$work->etag       = $audio->etag;
		$work->mime       = $audio->mime;
		$work->filename   = $audio->filename;
		$work->modified   = date("Y-m-d H:i:s",time());
		// event
		$work->raise(new WorkWasStarted($work));
		return $work;
	}
	
	public function hasCover()
	{
		return strlen($this->attributes['cover']) > 0;
	}
	// findByIds($ids)


}