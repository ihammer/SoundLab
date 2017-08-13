<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry,Response;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkSerializer;

class Show_ce extends Base {

	protected $work;
	
	public function __construct(Work $work,User $user)
	{
                ob_end_clean();
		$this->work = $work;
		$this->user = $user;
	}
	public function run()
	{
		$id   = abs(intval($this->param('id')));
		$work = $this->work->findOrFail($id);
		//$work->increment('play_count');
		//$work = DB::table("works")->where("id","=",$id)->get();
        //浏览逻辑更改 @wda
        if (!empty($user = 222))
        {
            // event 自动增长
            $work->increment('view_count');
            //添加到浏览表中
            $insert_wb['b_uid']=1;//浏览用户
            $insert_wb['b_suid']=$work->user_id;//被浏览用户
            $insert_wb['b_wid']=$work->id;//作品id
            $insert_wb['updated_at']=date("Y-m-d H:i:s");//更新时间
            DB::table("works_browses")->insert($insert_wb);
        }
		$serializer = new WorkSerializer();
		//$tl=$work->timeline;
		//return $tl;exit;
		$comments = DB::table('works_comments')->leftJoin("users","works_comments.user_id","=","users.id")->where("works_comments.work_id","=",$id)->whereNull("works_comments.deleted_at")->orderBy('timeline', 'asc')->get();
		$counts = count($comments);
		$this->document->addMeta('count', $counts);
		$document = $this->document->setData($serializer->resource($work));
		$document->addLink('waveform', $work->waveform);
		$playlists=DB::table("works")->where(array("user_id"=>$work->user_id,"is_private"=>0,"deleted_at"=>NULL))->where("id","<>",$work->id)->where("id","<",$work->id)->select("id")->orderBy("id","desc")->get();
		if(count($playlists)!=0){
			foreach($playlists as $val){
				$playlist[]=(int)$val->id;
			}
		}
		$rs=$this->work->where(array('is_private'=>0,'is_recommend'=>1,"user_id"=>$work->user_id,"deleted_at"=>NULL))->orderBy('created_at', 'desc')->get();//return $rs;exit;
		if(count($rs)==0){
			$rslist=$this->work->where(array('is_private'=>0,'is_recommend'=>1,"deleted_at"=>NULL))->take(1)->orderBy('created_at', 'desc')->get();
		}else{
			$rslist=$this->work->where(array('is_private'=>0,'is_recommend'=>1,"deleted_at"=>NULL))->where("created_at","<",$rs[0]->created_at)->take(1)->orderBy('created_at', 'desc')->get();
			if(count($rslist)==0){
				$rslist=$this->work->where(array('is_private'=>0,'is_recommend'=>1,"deleted_at"=>NULL))->where("created_at",">",$rs[0]->created_at)->take(1)->orderBy('created_at', 'desc')->get();
			}
		}
		$playlist[]=(int)$rslist[0]->id;
		if ( !empty( $user = Sentry::getUser() ) ) 
		{
			$playuser = $this->user->findOrFail($work->user_id);
			if ( $user->isFollowing($playuser) ) 
			{
				if ( $playuser->isFollowing($user) ){
					$this->document->addMeta('follow', 2);
				}else{
					$this->document->addMeta('follow', 1);
				}
			}else{
				$this->document->addMeta('follow', 0);
			}
			$this->document->addMeta('userAvatar', $user->avatar);
			$this->document->addMeta('userName', $user->username);
		}else{
			$this->document->addMeta('follow', 0);
		}
		$this->document->addMeta('playlist', $playlist);
		return $this->respondWithDocument($document);exit;
	}
}
