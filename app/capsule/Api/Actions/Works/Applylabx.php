<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry,Response,Cache;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Applylabx extends Base {
	
	
	public function run()
	{


      
		$workIds = $this->input("work_id_list");
		$delete = $this->input("delete");
       
		if (!empty($workIds) && is_array($workIds)) {
             foreach ($workIds as $key => $value) {
             	if($delete==1){
             		DB::table('works')->where('id', $value)->update(array('is_compshow' => 0));
                }else{
                	DB::table('works')->where('id', $value)->update(array('is_compshow' => 2));
                        //缓存labx申请状态
                         Cache::forever('labx_auth','1');
                }

             }
			return Response::json(['status' => 'ok']);	
		}
	} 
}
