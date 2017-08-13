<?php namespace Capsule\Api\Serializers;

use Sentry;
use Capsule\Core\Works\Work;

class WorkBasicBasicSerializer extends BaseSerializer {

	protected $type = "works";
    
	protected function attributes($work)
    {
        $user = Sentry::getUser();
        if($work->pricetype==0){
        	$work->price = $work->price;//isset($work->price) && $work->price!="0" ? number_format($work->price, 2, '.', '') : "0";
        }else{
	        $work->price = isset($work->price) && $work->price!="0" ? $work->price."P" : "0";
        }
        $attributes = [
            'id'         => $work->getId(),
            'uid'        => strval($work->user_id),
            'username'   => $work->username,
            // 'user'       => ['uid' => strval($work->author->id), 'username' => $work->author->username, 'avatar' => $work->author->avatar],
            'title'      => $work->title,
            'cover'      => $work->cover,
            'price'      => $work->price,
            'payfunc'    => $work->pricetype,
            'comptime'   => $work->comptime,
        ];
        //if(count($work->texts)>0){
	    //    $attributes['dmshow'] = $work->texts[0]["content"];
        //}else{
	        $attributes['dmshow'] = $work->reason;
        //}
        $attributes['user'] = null;
        if ( $author = $work->author) 
        {
        	if($user){
        		if($user->id!=$author->id){
							if( $user->isFollowing($author) && !($author->isFollowing($user)) )
							{
								$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>1];
							}elseif( $user->isFollowing($author) && $author->isFollowing($user) )
							{
								$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>2];
							}else{
								$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>0];
							}
						}else{
							$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>-1];
						}
					}else{
						$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>0];
					}
            
        }
	    
        return $attributes;
    }
}
