<?php

class AdminController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	function __construct(){
               
		$lifeTime = 24 * 3600; 
		session_set_cookie_params($lifeTime); 
		session_start();
	}

	public function login()
	{
		return View::make('admin/login');
	}
	
	public function index()
	{
            
		if(empty($_SESSION["admin"])){
			return Redirect::to('123xxxadmin/login');
		}else{
			return View::make('admin.index');
		}
	}
	
	public function dologin(){
//		if($_GET["admin"]=="admin" && $_GET["pass"]=="SoundLab118"){
//			$_SESSION["admin"]=$_GET["admin"];
//			echo 1;
//		}elseif($_GET["admin"]!="admin"){
//			echo 1001;
//		}elseif($_GET["pass"]!="SoundLab118"){
//			echo 1002;
//		}
//		if($_GET["admin"]=="admin" && $_GET["pass"]=="SoundLab118"){
//			$_SESSION["admin"]=$_GET["admin"];
//			echo 1;
//		}else{
			$username=$_GET["admin"];
			$password=crypt(md5($_GET["pass"]),'soundlab');
			$admin = DB::table('roleuser')->where('adminname',"=", $username)->get();
//			$currentUser=DB::table('roleuser')->find($admin[0]->id);
//			$currentUser->login_ip=$this->getIp();
//			$currentUser->login_time=date("Y-m-d H:i:s",time());
//			$currentUser->save();
//			if(count($admin)!=0){
//				$group=DB::table('role')find($admin[0]->group_id);
//			}
			if(count($admin)!=0 && $password==$admin[0]->adminpassword){
				$_SESSION["admin"]=$username;
				$_SESSION["passwd"]=$password;
//				$_SESSION["tname"]=$admin[0]->truename;
				$_SESSION["admin_id"]=$admin[0]->id;
				echo 1;
			}else{
				echo 1002;
			}
//		}
	}
	
	public function logout(){
		unset($_SESSION["admin"]);
		return Redirect::to('/123xxxadmin/login');
	}
	
	public function password(){
		return View::make('admin/password');
	}
	
	public function dopassword(){
		$pwd = $_POST['pwd'];
		$pwd1 = $_POST['pwd1'];
		$pwd2 = $_POST['pwd2'];

//		session_start();
		
	}

	public function checkpassword(){
		$password = crypt(md5($_POST['pwd']),'soundlab');;
		$passwordnew = crypt(md5($_POST['pwd1']),'soundlab');;
		$id = $_POST['id'];
		$admin = DB::table('roleuser')->where('id',"=", $id)->get();
		if(count($admin)!=0 && $password==$admin[0]->adminpassword){
//			$_SESSION["admin"]=$username;
//			$_SESSION["passwd"]=$password;
////				$_SESSION["tname"]=$admin[0]->truename;
//			$_SESSION["admin_id"]=$admin[0]->id;
			$data=array(
				"adminpassword"=> $passwordnew,
				'updated_at'=> date('Y-m-d H:i:s'),
			);
			DB::table('roleuser')->where('id', $id)->update($data);
			echo 1;
		}else{
			echo 0;
		}

	}

}
