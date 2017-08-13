<?php namespace Capsule\Api\Actions\Comments;

use Sentry, Response, Queue, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Comments\Comment;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Capsule\Core\Works\Work;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Core\Jpush;
class Add extends Base {
	
	protected $work;
	protected $user;

	public function __construct(Work $work,User $user)
	{
		$this->work = $work;
		$this->user = $user;
	}
	
	public function run()
	{
		if ( empty($user = Sentry::getUser()) ) 
		{
			$comment = Comment::start(
				$this->param('id'),
				'202940',
				$this->input('content'),
				$this->input('timeline')
			);
			$comment->save();
			return Response::json(['success' => 'success']);
		}
		$work=$this->work->findOrFail($this->param('id'));
		if(isset($_POST['f_id'])){
			$comment = Comment::start(
				$this->param('id'),
				$this->input('user_id'),
				$this->input('content'),
				$this->input('timeline'),
				$this->input('f_id')
			);
			$fuser=$this->user->findOrFail($this->input('f_id'));
			if($fuser->id!=$user->id){
				if($fuser->devicetoken!="")
				{
					$fmessage=new message();
					$fmessage->userid=$fuser->id;
					$fmessage->devicetoken=$fuser->devicetoken;
					$fmessage->message='有人回复了你在「'.$work->title.'」中的评论';
					$fmessage->action='work:'.$this->param('id').':reply:'.$this->input('content').':people:'.$user->id;
					$fmessage->save();
					Queue::push('Capsule\Core\Push@run', array('id' => $fmessage->id));
				}
			}
		}else{
			$comment = Comment::start(
				$this->param('id'),
				$this->input('user_id'),
				$this->input('content'),
				$this->input('timeline')
			);
		}
		$id=$comment->save();
		$pushuser=$this->user->findOrFail($work->user_id);
		if($pushuser->id!=$user->id){
			if($pushuser->devicetoken!="")
			{
				$message=new message();
				$message->userid=$pushuser->id;
				$message->devicetoken=$pushuser->devicetoken;
				$message->message='你的声音作品「'.$work->title.'」又有新的评论了';
				$message->action='work:'.$this->param('id').':comment:'.$this->input('content').':people:'.$user->id;
				$message->save();
 
                            //    if(strlen($message->devicetoken)==64){

					Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
			//	}else{
			//		$push = new Jpush();
		       //     $devicetoken = $message->devicetoken;
		       //     $messages=$message->message;
		       //     $re = $push->push('android',array($devicetoken),'only',$messages,0,0);
		       //     $array = json_decode($re,1);
		       //     if($array['msg_id']){
		            	
			//			$message->ispush=1;
			//			$message->save();
						
		        //    }else{
		            	
			//			$message->ispush=0;
			//			$message->save();
						
		        //    }
			//	}

 






			}
		}
		$comments = DB::table('works_comments')->leftJoin("users","works_comments.user_id","=","users.id")->where("works_comments.work_id","=",$this->param('id'))->whereNull("works_comments.deleted_at")->orderBy('timeline', 'asc')->get();
		$counts = strval(count($comments));
		$work->modified = date("Y-m-d H:i:s",time());

        //弹幕量加1
        $work->increment('comments_count');

		$work->save();
		return Response::json(['success' => 'success','commentid' => $comment->id,'count'=>$counts]);
	}
}
