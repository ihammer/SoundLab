<?php namespace Capsule\Api\Actions\Users;
use Sentry, Response, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Capsule\Api\Serializers\UserSerializer;

class Show extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$uid  = abs(intval($this->param('uid')));
		$me   = Sentry::getUser();
		$isMe = $me && $me->getId() === $uid;
		$this->document->addMeta('following', false);
		$this->document->addMeta('followed', false);
		if ( $isMe ) 
		{
			$user = $me;
		} else 
		{
			$user = $this->user->findOrFail($uid);
			$user->increment('visit');
            //主页浏览逻辑更改  首先访问该用户主页时 访问用户如果不存在浏览表里则添加 如果存在就更新时间
            $user_bsinfo=DB::table('works_browses')->where(array("b_type"=>1,"b_uid"=>$user->id,"b_suid"=>$uid))->first();
            if($user_bsinfo){
                DB::table('works_browses')->where('id', $user_bsinfo->id)->update(array('updated_at' =>date("Y-m-d H:i:s")));
            }else{
                //添加到浏览表中
                $insert_wb['b_uid']=$user->id;//浏览用户
                $insert_wb['b_suid']=$uid;//被浏览用户
                $insert_wb['b_wid']=0;//作品id
                $insert_wb['b_type']=1;//主页浏览
                $insert_wb['updated_at']=date("Y-m-d H:i:s");//更新时间
                DB::table("works_browses")->insert($insert_wb);
            }

		}
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}
		$rank=1+(DB::table('users')->where("score",">",$user->score)->count());
		$this->document->addMeta('rank', $rank);
		$rs=DB::table("users_records")->whereRaw("user_id=".$user->id." and YEARWEEK(date_format(record_date,'%Y-%m-%d')) = YEARWEEK(now())")->select(DB::raw("sum(login) as login,sum(dig) as dig,sum(work) as work,sum(topic) as topic,sum(push) as push"))->get();
		$upscore=$rs[0]->login*1+$rs[0]->dig*3+$rs[0]->work*5+$rs[0]->topic*10+$rs[0]->push*50;
		$this->document->addMeta('upscore', $upscore);
		if ( $me ) 
		{
			if ( $me->isFollowing($user) ) 
			{
				$this->document->addMeta('following', true);
			}

			if ( $user->isFollowing($me) ) 
			{
				$this->document->addMeta('followed', true);
			}
		}
		$serializer = new UserSerializer();
        if($me){
			$smc=Message::where(array('userid'=>$me->id,'isread'=>0))->where('action','like','%people%')->count();
			$this->document->addMeta('systemmessages', $smc);
		}
        $document = $this->document->setData($serializer->resource($user));
        return $this->respondWithDocument($document);
	}
}