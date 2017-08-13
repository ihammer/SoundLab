<?php namespace Capsule\Core\RecordsUsers;

use Carbon\Carbon;
use Capsule\Core\RecordsUsers\Events\UserUsernameWasChanged;
use Capsule\Core\RecordsUsers\Events\UserMobileWasChanged;
use Capsule\Core\RecordsUsers\Events\UserPasswordWasChanged;
use Capsule\Core\RecordsUsers\Events\UserAvatarWasChanged;
use Capsule\Core\Support\Contracts\SendableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as UserModel;
use Laracasts\Commander\Events\EventGenerator;

class User extends UserModel {

	use EventGenerator;
	protected $connection = 'mysql_records';
	// 用户的作品列表
	public function audios()
	{
		return $this->hasMany('Capsule\Core\RecordsAudios\Audio', 'user_id');
	}
	public function videos()
	{
		return $this->hasMany('Capsule\Core\RecordsVideos\Video', 'user_id');
	}
	// 用户喜欢过的歌曲
	public function likes()
	{
		return $this->belongsToMany('Capsule\Core\RecordsVideos\Video', 'users_likes', 'user_id', 'video_id')->withTimestamps();
	}
	// feeds
	public function feeds()
	{
		return $this->hasMany('Capsule\Core\RecordsFeed', 'user_id');
	}
	//用户创建的标签 
	public function tags()
	{
		return $this->hasMany('Capsule\Core\RecordsTags\Tag');
	}
	// 用户关注的标签
	public function followingTags()
	{
		return $this->belongsToMany('Capsule\Core\RecordsTags\Tag', 'users_tags', 'tag_id', 'user_id');
	}
	// 我关注的用户
	public function following()
	{
		return $this->belongsToMany('Capsule\Core\RecordsUsers\User', 'users_following', 'fromuid', 'touid');
	}
	// 我的粉丝
	public function follower()
	{
		return $this->belongsToMany('Capsule\Core\RecordsUsers\User', 'users_follower', 'fromuid', 'touid');
	}
	// 第三方账号token
	public function tokens()
	{
		return $this->hasMany('Capsule\Core\RecordsUsers\Token');
	}

	public static function register(array $attribute)
	{		
		$user = new static;
		$user->mobile   = $attribute['mobile'];
		$user->password = $attribute['password'];
		$user->username = $attribute['username'];
		$user->avatar   = $attribute['avatar'];
		$user->sex      = $attribute['sex'];
		$user->location = $attribute['location'];
		return $user;
	}

	public function getUsernameAttribute()
	{
		if ( empty($this->attributes['username']) )
		{
			//return $this->mobile;
			return $this->attributes['username'];
		}
		return $this->attributes['username'];
	}
	
	public function getSexAttribute()
	{
		return $this->attributes['sex'];
	}
	
	public function getAvatarAttribute()
	{
		if ( empty($this->attributes['avatar']) ) 
		{
			return "";
		}
		return sprintf("http://7xikb7.com1.z0.glb.clouddn.com/%s?imageView2/2/w/300", $this->attributes['avatar']);
	}

	public function getAvatarPath($uid = null, $size = 'small')
	{
		$uid = $uid ?: $this->getId();
		$uid = sprintf("%09d",abs(intval($uid)));
		$dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        return $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."{$size}_avatar.jpg";
	}

	public function like($work)
	{
		if ( $this->isLikeThisWork($work) ) 
		{
			return false;
		}
		$this->likes()->attach($work);
		return true;
	}
	public function unLike($work)
	{
		return $this->likes()->detach($work) > 0;
	}
	public function isLikeThisWork($work)
	{
		if ( is_object($work) ) 
		{
			$id = $work->getId();
		} else
		{
			$id = $work;
		}
		return (NULL !== $this->likes()->where('work_id', $id)->first());
	}
	// 数据完整性???
	public function follow($user)
	{
		if ( $this->isFollowing($user) ) 
		{
			return false;
		}
		$this->following()->attach($user, ['addtime' => new Carbon]);
		$user->follower()->attach($this, ['addtime' => new Carbon]);
		return true;
	}

	public function unFollow($user)
	{
		if ( !$this->isFollowing($user) ) 
		{
			return false;
		}
		return $this->following()->detach($user) && $user->follower()->detach($this);
	}

	public function isFollowing($user)
	{
		if ( $user instanceof self)  
		{
			$id = $user->getId();
		} else
		{
			$id = $user;
		}
		return NULL !== $this->following()->where('users_following.touid', $id)->first();
	}
	// @overwrite
	public function validate()
	{
		// $username = $this->getAttribute('username');
		// $query = $this->newQuery();
		// $i = 0;
		// while ( !is_null( $persistedUser = $query->where('username', '=', $username)->first() ) && $persistedUser->getId() != $this->getId()) 
		// {
		// 	$i++;
		// 	$username = $username. "-" . $i;
		// 	$this->setAttribute('username', $username);
		// }

	}

	public function changeUsername($username)
	{
		$this->username = $username;
		$this->raise(new UserUsernameWasChanged($this));
		return $this;
	}
	
	public function changeMobile($mobile)
	{
		if ( $this->mobile !== $mobile ) 
		{
			$this->mobile = $mobile;
			$this->raise(new UserMobileWasChanged($this));
		}
		return $this;
	}

	public function changePassword($password)
    {
        $this->password = $password;
        $this->raise(new UserPasswordWasChanged($this));
        return $this;
    }

    public function changeAvatar($path)
    {
        $this->avatar = $path;
        $this->raise(new UserAvatarWasChanged($this));
        return $this;
    }
}