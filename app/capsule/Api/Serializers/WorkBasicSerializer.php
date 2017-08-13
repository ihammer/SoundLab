<?php namespace Capsule\Api\Serializers;

use Sentry,DB;
use Capsule\Core\Works\Work;

class WorkBasicSerializer extends BaseSerializer {

	protected $type = "works";
    
	protected function attributes($work)
    {
        $user = Sentry::getUser();
        if($work->pricetype==0){
        	$work->price = $work->price;//isset($work->price) && $work->price!="0" ? number_format($work->price, 2, '.', '') : "0";
        }else{
	        $work->price = isset($work->price) && $work->price!="0" ? $work->price : "0";
        }
        if(count($work->images)>1){
	        $blue=1;
        }else{
	        $blue=0;
        }
        if(count($work->texts)>0){
	        $black=1;
        }else{
	        $black=0;
        }
        if($work->goods==null){
        	$work->goods="";
        }
        $comm_count=DB::table('works_comments')->where("work_id","=",$work->getId())->count();
        if(!empty($user)){
         	$order_count = DB::table('orders')
         					->where('user_id', $user->getId())
	        				->where('work_id', $work->getId())
	        				->where('orderStatus', 1)
	                       	->count();
		}else{
        	$order_count = 0;
        }

        $attributes = [
            'id'         => $work->getId(),
            'uid'        => strval($work->user_id),
            // 'username'   => $work->username,
            // 'user'       => ['uid' => strval($work->author->id), 'username' => $work->author->username, 'avatar' => $work->author->avatar],
            'title'      => $work->title,
            'cover'      => $work->cover,
            'descr'      => $work->descr,
            'duration'   => strval($work->duration),
            'play_count' => (string)$work->play_count,
            'love_count' => (string)$work->love_count,
            'comm_count' => (string)$comm_count,
            'is_order'   => $order_count > 0 ? 1: 0,
            'liked'      => $work->liked,
            'reason'     => $work->reason,
            'price'      => $work->price,
            'payfunc'    => $work->pricetype,
            'goods'			 => $work->goods,
            'comptime'   => $work->comptime,
            'can_edit'   => $user && $user->getId() === $work->getId(),
            'is_private' => intval($work->is_private),
            'tags'       => $work->tags->lists('name'),
            'created_at' => strval($work->created_at),
            'location'   =>$work->location,
            'locationX'  =>$work->locationX,
            'locationY'  =>$work->locationY,
            'is_compshow'=>$work->is_compshow,
            'type_name'   =>isset($work->type->name) ? $work->type->name : "",//->find($work->type_id),
            'blue'=>$blue,
            'black'=>$black,
        ];
        //if(count($work->texts)>0){
	    //    $attributes['dmshow'] = $work->texts[0]["content"];
        //}else{
	        $attributes['dmshow'] = $work->reason;
        //}
        $attributes['user'] = null;
        if ( $author = $work->author) 
        {
	        if($author->utype_id==0){
			    $utype="暂无分类";
			}else{
		    	$usertype=DB::table("utypes")->find($author->utype_id);
		    	$utype=$usertype->name;
		    }
        	if($user){
        		if($user->id!=$author->id){
							if( $user->isFollowing($author) && !($author->isFollowing($user)) )
							{
								$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>1,'utype'=>$utype,'authentication'=>(string)$author->authentication];
							}elseif( $user->isFollowing($author) && $author->isFollowing($user) )
							{
								$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>2,'utype'=>$utype,'authentication'=>(string)$author->authentication];
							}else{
								$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>0,'utype'=>$utype,'authentication'=>(string)$author->authentication];
							}
						}else{
							$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>-1,'utype'=>$utype,'authentication'=>(string)$author->authentication];
						}
					}else{
						$attributes['user'] = ['uid' => strval($author->id), 'username' => $author->username, 'avatar' => $author->avatar, 'sex' => $author->sex, 'follow' =>0,'utype'=>$utype,'authentication'=>(string)$author->authentication];
					}
            
        }
	    
        return $attributes;
    }
}
