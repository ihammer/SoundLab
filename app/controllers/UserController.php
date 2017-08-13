<?php
//use DB;
use capsule\Core\Users\User;
use Capsule\Api\Actions\Auth\Register;
class UserController extends FormController{
	public function __construct()
     {
          $this->model = '\User';
          $this->fields_all = [
               'id' => [
                    'show' => '序号',
               ],
               'mobile' => [
                    'show' => '手机号',
               ],
               'username' => [
                    'show' => '用户名',
					'search' => "username like CONCAT('%', ?, '%')"
               ],
               'password' => [
                    'show' => '密码',
               ],
               'created_at' => [
                    'show' => '创建时间',
               ],
               'updated_at' => [
                    'show' => '更新时间',
               ],
          ];
 
          $this->fields_show = ['mobile', 'username', 'created_at'];
          $this->fields_edit = ['mobile', 'username'];
          $this->fields_create = ['mobile', 'username', 'password'];
          parent::__construct();
     }
	 
	 public function index()
     {
		 $upuser = 0;
		 $typesid = 0;
		 if(isset($_GET['upuser'])){
		  	$upuser = $_GET['upuser'];
		 }
		 if(isset($_GET['typesid'])){
		  	$typesid = $_GET['typesid'];
		 }

          $model = new $this->model;

          if($typesid>0){
		 	$getsearcha = array(
		 		'utype_id' =>  $typesid,
		 	);
			 // $buildert = $model->where('utype_id','=',$typesid)->orderBy('id', 'desc');
		 }else{
		 	
			 // $buildert = $model->where('utype_id','=','0')->orderBy('id', 'desc');
		 }

		 if($upuser==2){
		 	$getsearchb = array(
		 		'recommend' =>  1,
		 	);
			 // $builder = $model->where('recommend','=','1')->orderBy('id', 'desc');
		 }
		 // else{
			//  // $builder = $model->orderBy('id', 'desc');
		 // }

		 if (isset($getsearchb)) {
		 	if($typesid>0){
		 		$getsearch = array_merge($getsearcha,$getsearchb);
		 	}else{
		 		$getsearch = $getsearchb;
		 	}
		 	$builder = $model->where($getsearch)->orderBy('id', 'desc');
		 }else{
		 	if($typesid>0){
		 		$getsearch = $getsearcha;
		 		$builder = $model->where($getsearch)->orderBy('id', 'desc');
		 	}else{
		 		$builder = $model->orderBy('id', 'desc');
		 	}
		 }

		 

		 

          $input = User::all();
          foreach ($input as $field => $value) {
               if (empty($value)) {
                    continue;
               }
               if (!isset($this->fields_all[$field])) {
                    continue;
               }
               $search = $this->fields_all[$field];
               $builder->whereRaw($search['search'], [$value]);
          }
		 //		recommend

		  //$models = $builder->paginate(20);
		  $models = $builder->get();
		  $types = DB::table("utypes")->get();
          return View::make('form.index', [
               'models' => $models,
               'types'=>$types,
          ]);
     }
	 
	 public function create()
     {
	     $types = DB::table("utypes")->get();
          return View::make('form.create',['types'=>$types]);
     }

     public function checkmobile()
     {
     	// $_POST['mobile']="13488674274";
     	$mobile = DB::table('users')->where('mobile', $_POST["mobile"])->get();
	     echo count($mobile);
     }
	 
	 public function save()
	 {
		 $password = !empty($_GET["password"])?$_GET["password"]:'thizlinux';
		 $data=array(
			"username" => $_GET["username"],
			"mobile" => $_GET["mobile"],
			'password' => $_GET["password"],
			'avatar'   => $_GET["src"],
			'sex'      => $_GET["sex"],
			'location' => $_GET["city"]." ".$_GET["area"],
			'introduce'=>$_GET["introduce"],
			'utype_id'=>$_GET["utype_id"]
		 );
		$user=Sentry::register($data);
		$user->save();
		$user->attemptActivation($user->getActivationCode());
		$tags=explode(",",$_GET["tag"]);
		foreach($tags as $key=>$item)
		{
			if($item!="")
			{
				$tag=new Tag();
				if(!$tag->where("name",$item)->first()){
					$tag->user_id = $user->id;
					$tag->name = $item;
					$tag->save();
					DB::table("users_tags")->insert(array("user_id"=>$user->id,"tag_id"=>$tag->id));
				}else{
					$isset = $tag->where("name",$item)->first();
					DB::table("users_tags")->insert(array("user_id"=>$user->id,"tag_id"=>$isset->id));
				}
				 
			}
		}
		return Redirect::to(action($this->controller . '@index'));
	 }
	 
	 public function resetpassword($id)
	 {
		$user = Sentry::findUserById($id);
		$resetCode = $user->getResetPasswordCode();
		$user->attemptResetPassword($resetCode,$_GET["password"]);
		return Redirect::to(action($this->controller . '@index'));
	 }
	 
	 public function recommenduser()
	{
		DB::table('users')->where('id',"=", $_POST["id"])->update(array('recommend' => $_POST["recommend"],'recommendtime'=>date('Y-m-d H:i:s',time())));
	}
	 
	 public function upsave()
   {
   	if($_SESSION["admin_id"]==1){
   	$data=array(
   		"username"=>$_POST["username"],
   		"mobile"=>$_POST["mobile"],
   		"location"=>$_POST["city"]." ".$_POST["area"],
   		"sex"=>$_POST["sex"],
   		"avatar"=>$_POST["src"],
   		"introduce"=>$_POST["introduce"],
   		"utype_id"=>$_POST["utype_id"]
   	);
   }else{
   	$data=array(
   		"username"=>$_POST["username"],
   		"location"=>$_POST["city"]." ".$_POST["area"],
   		"sex"=>$_POST["sex"],
   		"avatar"=>$_POST["src"],
   		"introduce"=>$_POST["introduce"],
   		"utype_id"=>$_POST["utype_id"]
   	);
   }
   	// echo $_POST['upuser'];die;
   	DB::table('users')->where('id', $_POST["id"])->update($data);
    // return Redirect::to(action($this->controller . '@index'));
    return Redirect::action('UserController@index', array('upuser' => $_POST['upuser'],'typesid' => $_POST['typesid']));
   }
	 
	 public function edit($id)
     {
          $model = new $this->model;
          $model = $model->find($id);
          $types = DB::table("utypes")->get();
          if($model->location!="" && $model->location!="火星"){
          	$ca=explode(" ",$model->location);
          }elseif($model->location==""){
          	$ca=array("","");
          }elseif($model->location=="火星"){
			$ca=array("火星","");
		  }
          return View::make('form.edit', compact('model','ca','types'));
     }

     public function scoreedit($id)
     {
          $model = new $this->model;
          $model = $model->find($id);
          $types = DB::table("utypes")->get();
          
          return View::make('form.scoreedit', compact('model','types'));
     }
     public function upsavescore(){
     	
		 $data=array(
			"userid" => $_POST["userid"],
			"username"=>$_POST["username"],
			"num" => $_POST["num"],
			'reason' => $_POST["reason"],
			'status'   => $_POST["status"],
			'type'      => $_POST["type"],
			'created_at' => date("Y-m-d H:i:s",time()),
			'updated_at'=> date("Y-m-d H:i:s",time()),
		 );
		
		DB::table("scoreelse")->insert($data);
		
		return Redirect::to(action($this->controller . '@index'));
	   
     }
 
     public function update($id)
     {
          $model = new $this->model;
          $model = $model->find($id);
          $model->fill(Input::all());
          $model->save();
 
          return Redirect::to(action($this->controller . '@index'));
     }
	 
	 public function deluser($id)
	 {
		 $this->destroy($id);
		 return Redirect::to(action($this->controller . '@index'));
	 }
 
     public function destroy($id)
     {
         $model = new $this->model;
         $model->destroy($id);
         
     }
     
			public function addpush(){
				$users = DB::select("select id,devicetoken,LENGTH(devicetoken) as len from users where LENGTH(devicetoken) > 40");//echo count($users);exit;
				$content=$_POST["content"];
				$curtime=date("Y-m-d H:i:s",time());
				foreach($users as $item){
					if($item->len==64){
						//$item->devicetoken=$token="b67c0dd8a7d93c2dfcf33105be83ec160f806c0c5c78483caf93f7a02a522074";
						//$item->id=1062;
						$id = DB::table("system_messages")->insertGetId(
																															array(
																																'userid'=>$item->id,
																																'devicetoken'=>$item->devicetoken,
																																'message'=>$content,
																																'action'=>"system:index",
																																'created_at'=>$curtime,
																																'updated_at'=>$curtime
																															)
																														);
						Queue::push('Capsule\Core\Push@run', array('id' => $id));//exit;
					}
				}
				echo 1;exit; 
			}
}