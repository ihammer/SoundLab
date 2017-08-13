<?php namespace Capsule\Api\Actions\Works;
use DB,Response,Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
class Labxtype extends Base {


protected $work;
	
public function __construct(Work $work,User $user)
{
	$this->work = $work;
	$this->user = $user;
}



public function run(){
 $me = Sentry::getUser();
$userid = intval($this->input('userid', 0));
$isMe = $me && $me->getId() == $userid;
$where=array("deleted_at"=>null);

if($isMe){
    $where['user_id'] = $me->getId();
//    $where['is_compshow'] = 1;
//    $orwhere['is_compshow'] = 2;
}else{

    $where['user_id'] = $userid;
    $where['is_compshow'] =1;  
    
}

if($isMe){
	$worksTotal = $this->work->where($where)->whereIn('is_compshow', array(1, 2))->count();
}else{
	$worksTotal = $this->work->where($where)->count();
}

 $data['worksTotal'] = (string)$worksTotal;
 $data['data'] =  DB::table("types")->select('id','name')->get();
 return Response::json($data);

}	

}
