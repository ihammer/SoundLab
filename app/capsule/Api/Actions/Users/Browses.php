<?php namespace Capsule\Api\Actions\Users;

use DB,Sentry,Response;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class Browses extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
        if ( empty($user = Sentry::getUser()) )
        {
            throw new UserUnauthorizedException();
        }
        $page  = max(1, intval($this->input('p', 0)));
        $start = ($page-1)*10;
		$browses_us=DB::table("works_browses")->where(array("b_suid"=>$user->id))->skip($start)->take(30)->orderBy('updated_at', 'desc')->get();
        $data_re=array();
        foreach ($browses_us as $bkey=>$bval){
            $data_re[$bkey]=$bval;
            //用户信息
            $user_bsinfo=DB::table('users')->where(array("id"=>$bval->b_uid))->first();
            unset($user_bsinfo->id);
            $data_re[$bkey]->user_info=$user_bsinfo;
            if($bval->b_type==1){
                $data_re[$bkey]->msg_info="'{$user_bsinfo->username}''"."访问了您的主页！";
            }else{
                $work_bsinfo=DB::table('works')->where(array("id"=>$bval->b_wid))->first();
                $data_re[$bkey]->msg_info="{$user_bsinfo->username}"."查看了您的'{$work_bsinfo->title}'的作品！";
            }
        }
        return Response::json(['success' => 'success','data'=>$data_re]);
	}
}