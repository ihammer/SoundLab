<?php namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class Index extends Base {

	protected $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	public function run()
	{
		$categorys = array(
			
			 '202306', '202115', '151924', '161942', '202004', '201998', '201969', '202647', '20628'
		);
        return  Response::json($categorys);
	}
}