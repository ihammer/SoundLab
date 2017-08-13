<?php namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class Region extends Base {

	protected $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	//微信小小程序地域列表
	public function run()
	{
        $data = array(
            'data'  => array(
                'bj'=>'beijing',//北京
                'sh'=>'shanghai',//上海
                'gz'=>'guangzhou',//广州
                'hz'=>'hangzhou'//杭州
            ),
            'status'=> 200
        );
        return  Response::json($data);
	}
}