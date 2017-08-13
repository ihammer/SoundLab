<?php
class ScoreelseController extends FormController{
	public function __construct()
     {
          $this->model = '\Scoreelse';
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
		 if(isset($_GET['upuser'])){
		  	$upuser = $_GET['upuser'];
		 }

          $model = new $this->model;
		 if($upuser==2){
			 $builder = $model->where('recommend','=','1')->orderBy('id', 'desc');
		 }else{
			 $builder = $model->orderBy('id', 'desc');
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
          return View::make('form.scoreelse', [
               'models' => $models,
          ]);
     }
	 
	 public function create()
     {
          return View::make('form.roleusercreate');
     }
	 
	 public function save()
	 {

		 $data=array(
			"adminname" => $_POST["adminname"],
			"adminpassword" => crypt(md5($_POST["adminpassword"]),'soundlab'),
			'roleid' => '2',
			 'created_at'=> date('Y-m-d H:i:s'),
			 'updated_at'=> date('Y-m-d H:i:s'),
		 );
		 DB::table("roleuser")->insert($data);
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
//		DB::table('users')->where('id',"=", $_POST["id"])->update(array('recommend' => $_POST["recommend"],'recommendtime'=>date('Y-m-d H:i:s',time())));
	}
	 
	 public function upsave()
   {
	   
	$data=array(
		"num"=>$_POST["num"],
		"reason"=>$_POST["reason"],
		"status"=>$_POST["status"],
		"type"=>$_POST["type"],
		'updated_at'=> date('Y-m-d H:i:s'),
	);
	
   	DB::table('scoreelse')->where('id', $_POST["id"])->update($data);
   	if($_POST["status"]==1){
   		$score = DB::table('users')->where('id', $_POST["userid"])->get();
   		if($_POST["type"]==1){
   			$score = $score[0]->score+$_POST["num"];
   		}
   		if($_POST["type"]==2){
   			$score = $score[0]->score-$_POST["num"];
   		}
   		$scoredata=array(
			"score"=>$score,
			'updated_at'=> date('Y-m-d H:i:s'),
		);
   		DB::table('users')->where('id', $_POST["userid"])->update($scoredata);
   	}
    return Redirect::to(action($this->controller . '@index'));
   }
	 
	 public function edit($id)
     {
          $model = new $this->model;
          $model = $model->find($id);
          
          return View::make('form.scoreelseedit', compact('model','ca'));
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