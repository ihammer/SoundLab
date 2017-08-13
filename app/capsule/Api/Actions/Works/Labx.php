<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Labx extends Base {
	
	protected $work;
	
	public function __construct(Work $work,User $user)
	{
		$this->work = $work;
		$this->user = $user;
	}
	
	public function run()
	{
        //is_compshow 1通过审核的  2提交申请 并且审核中

        $userid = intval($this->input('userid', 0));
		$type = intval($this->input('type', 0));
		$page  = max(1, intval($this->input('p', 0)));
		$serializer = new WorkBasicSerializer();
		$me = Sentry::getUser();

		$isMe = $me && $me->getId() == $userid;
		$where=array("deleted_at"=>null);
		
        if($isMe){
            $where['user_id'] = $me->getId();
          //  $where['is_compshow'] = 1;
          //  $orwhere['is_compshow'] = 2;
        }else{

            $where['user_id'] = $userid;
            $where['is_compshow'] =1;  
            
        }

		
	    
		if(!$type==0){
         $where['type_id'] = $type;
		}
		if($isMe){
			$worksTotal = $this->work->where($where)->whereIn('is_compshow', array(1, 2))->count();
		}else{
			$worksTotal = $this->work->where($where)->count();
		}
		
		$count = $this->input('limit', 10);
		$start = ($page - 1) * $count;
		if($isMe){
			$works = $this->work->where($where)->whereIn('is_compshow', array(1, 2))->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		}else{
			$works = $this->work->where($where)->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		}
		

        $document = $this->document->setData($serializer->collection($works));
        return $this->respondWithDocument($document);
	}
}
