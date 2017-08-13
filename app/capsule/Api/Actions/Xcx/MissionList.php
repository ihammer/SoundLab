<?php
/**
 * Created by PhpStorm.
 * User: 武德安
 * Date: 2017/7/12
 * Time: 11:14
 * Name: 特定用户
 */
namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class MissionList extends Base {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function run()
    {
        $user_list=DB::table('users')->whereIn('id',array('2610', '2115', '204029','203983','4609','203840','67','7626','44073','14479','187373'))->orderByRaw('RAND()')->get();
        $list=array();
        foreach ($user_list as $ulk=>$ulv){
            $list[$ulk]['id']=$ulv->id;
            $list[$ulk]['avatar']=$ulv->avatar;
            $list[$ulk]['username']=$ulv->username;
            if(empty($ulv->introduce)){
                $list[$ulk]['introduce']='对,他很懒什么也没有留下！';
            }else{
                $list[$ulk]['introduce']=$ulv->introduce;
            }
            if($ulk<4){
                $list[$ulk]['status']=1;
            }else{
                $list[$ulk]['status']=0;
            }
        }
        $data = array(
            'data'  => $list,
            'status'=> 200
        );
        return  Response::json($data);
    }
}