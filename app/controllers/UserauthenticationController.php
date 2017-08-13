<?php
use Illuminate\Support\Facades\Cache;
class UserauthenticationController extends FormController{
public $host="http://7xikb7.com1.z0.glb.clouddn.com/";
public function __construct()
     {
        $tables="orders";
    //      $this->model = '\Tag';
          $this->fields_show = [];
          $this->fields_edit = [];
          $this->fields_create = [];
          parent::__construct();
     }
    
    
    public function  index(){
        Cache::forever('user_auth','0');//标记为已查看         
        $model = DB::table("user_authentication")->orderBy('id','desc')->paginate(30);
        
        foreach ($model as $key => $value) {
          $users = DB::table("users")->select('username')->where('id',$value->userid)->get();
          if(empty($users[0]->username)){
              unset($model[$key]);
              continue;
          }else{
              $model[$key]->username = $users[0]->username;
          }
          
        } 
        return View::make('form.user_authentication_list',['data'=>$model,'url'=>$this->get_url()]);
    }
    
    
    public function renz()
	{
                $utype_arr = DB::table("user_authentication")->where('userid', $_POST["id"])->get();
                $utype_id = $utype_arr[0]->genreid;
                $utype_id = $_POST["renz"]?$utype_id:$_POST["renz"];
                $recommendtime = date('Y-m-d H:i:s',time());
		DB::table('users')->where('id', $_POST["id"])->update(array('authentication' => $_POST["renz"],'utype_id'=>$utype_id,'recommend'=>$_POST["renz"],'recommendtime'=>$recommendtime));


		DB::table('user_authentication')->where('userid', $_POST["id"])->update(array('status' => $_POST["renz"]));
                if($_POST["renz"]){
                $this->push_message($_POST["id"],'您提交的音乐人认证，审核已通过！');
       
                }


	}

  function push_message($userid,$content){
   $users =  DB::table("users")->where('id',$userid)->select('devicetoken')->get();
   $devicetoken = $users[0]->devicetoken;
   $curtime=date("Y-m-d H:i:s",time());
   
                                                $id = DB::table("system_messages")->insertGetId(

                                                                   array(

                                                                           'userid'=>$userid,

                                                                           'devicetoken'=>$devicetoken,

                                                                           'message'=>$content,

                                                                           'action'=>"system:index",

                                                                           'created_at'=>$curtime,

                                                                           'updated_at'=>$curtime

                                                                   )

                                                           );
                                                Queue::push('Capsule\Core\Push@run', array('id' => $id));//exit;



 }



   public function  renzlabx(){
        
        Cache::forever('labx_auth','0');//已查看
        $models = DB::table("works")->leftJoin('users','works.user_id','=','users.id')->where(array("is_compshow"=>2))->select("users.username as uname","works.*")->orderBy("updated_at","desc")->get();

        return View::make('form.labxauthlist', [
		   'models' => $models,
		   "host"=>$this->host,
		   'labtype'=>array(1=>"唱片",2=>"周边",3=>"线下活动",4=>"生活方式"),
		   'url'=>$this->get_url(),
                   'labx'=>0,
                   'applylabx'=>1
		]);

   }

  public  function ajax_check(){
    $labx_auth =  Cache::get('labx_auth');
    $user_auth =  Cache::get('user_auth');

    $data['labx_auth'] = $labx_auth ? $labx_auth :'0';
    $data['user_auth'] = $user_auth ? $user_auth : '0';
    echo  json_encode($data); 
 
 } 

 

}
