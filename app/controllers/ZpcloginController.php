<?php
use Response, Sentry, DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
session_start();
class ZpcloginController extends BaseController{
	 
	public function index()
	{
			if (isset($_SESSION['mobile']) && !empty($_SESSION['mobile'])) {
				return Redirect::to('/home');
			}else{
				return View::make('web/login');
			}
	}

	public function regist()
	{
			
			return View::make('web/regist');
	}

	public function findmm()
	{
			
			return View::make('web/findmm');
	}

	public function sublogin()
	{
		$where = array(
			'mobile' => $_POST['m'],
			'password' => $_POST['n'],
		);
		// $types = DB::table("users")->where($where)->get();

		try {
			
			$user = Sentry::authenticate([
				'mobile' => $_POST['m'],
				'password' => $_POST['n'],
			]);
			echo $_SESSION['mobile'] = $_POST['m'];
		} catch(\Exception $e)
		{
			echo 0;
		}
	}

	public function ploginout()
	{
		session_destroy();
		return Redirect::to('/plogin');
	}
	
	
}