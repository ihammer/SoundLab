<?php namespace Capsule\Api\Serializers;

use Capsule\Core\Messages\message;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;

class MessageSerializer extends BaseSerializer {
	
	protected $type = "system_messages";

	protected function attributes($message)
	{
		$action = explode(":",$message->action);
		$count  = count($action);

                if($action[0]=='system'){
                   $attributes = [
				'message'   => $message->message,
				'action'    => $action[0],
				'tags'      => $action[1], 
				'userid'	=> $message->userid,
				'isread'	=> $message->isread,
				'created_at'=> $message->created_at,
			];
                    return $attributes;
                 }

                if($action[0]=='topic'){
                        $attributes = [
				'message'   => $message->message,
				'action'    => $action[0],
				'tags'      => $action[1], 
				'userid'	=> $message->userid,
				'isread'	=> $message->isread,
				'created_at'=> $message->created_at,
			];

                 }  

		if($count==2){//关注people
			$me=User::find($message->userid);
			$user=User::find($action[1]);
			$follow=$me->isFollowing($user) ? 1 : 0;
			$attributes = [
				'message'   => $message->message,
				'action'    => $action[0],
				'userid'	=> $action[1],
				'avatar'	=> $user->avatar,
				'username'	=> $user->username,
				'isread'	=> $message->isread,
				'follow'	=> $follow,
				'created_at'=> $message->created_at,
			];
		}else if($count==5){//打赏pay payed or 点赞love loved or 感谢thank
			$user=User::find($action[4]);
			$work=Work::find($action[1]);
			if($action[2]=="pay" || $action[2]=="payed"){
				if($work){
					$mes="打赏了你的作品「".$work->title."」";
				}else{
					$mes="打赏了你的作品";
				}
			}elseif($action[2]=="love" || $action[2]=="loved"){
				if($work){
					$mes="赞了你的作品「".$work->title."」";
				}else{
					$mes="赞了你的作品";
				}
			}else{
				$mes=$user->username."感谢了你的支持";
			}
			$attributes = [
				'message'   => $mes,//$message->message,
				'action'    => $action[2],
				'userid'	=> $action[4],
				'workid'	=> $action[1],
				'avatar'	=> $user->avatar,
				'username'	=> $user->username,
				'isread'	=> $message->isread,
				'created_at'=> $message->created_at,
			];
		}else if($count==6){//评论comment or 回复reply
			$user=User::find($action[5]);
			$work=Work::find($action[1]);
			if($action[2]=="comment"){
				if($work){
					$mes="评论了你的作品「".$work->title."」";
				}else{
					$mes="评论了你的作品";
				}
			}elseif($action[2]=="reply"){
				if($work){
					$mes="回复了你的作品「".$work->title."」";
				}else{
					$mes="回复了你的作品";
				}
			}
			$attributes = [
				'message'   => $mes,//$message->message,
				'action'    => $action[2],
				'userid'	=> $action[5],
				'workid'	=> $action[1],
				'avatar'	=> $user->avatar,
				'username'	=> $user->username,
				'isread'	=> $message->isread,
				'created_at'=> $message->created_at,
			];
		}
		return $attributes;
	}
}
