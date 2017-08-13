<?php
class FormController extends BaseController {
 
     // 对应的模型
     protected $model;
 
     // 所有的字段
     protected $fields_all;
 
     // 列表页显示的字段
     protected $fields_show;
 
     // 编辑页面显示的字段
     protected $fields_edit;
 
     // 创建页面显示的字段
     protected $fields_create;
	 
	 public function __construct()
     {
 
          // TODO:做一些基础的判断，如果没有的话就抛出异常
          $lifeTime = 24 * 3600; 
          session_set_cookie_params($lifeTime); 
         session_start();//var_dump($_SESSION);exit;

         if(isset($_SESSION["admin"]) && $_SESSION["admin"]!=""){
//             echo $_SESSION["admin"];
             $admin=DB::table('roleuser')->where("adminname","=",$_SESSION["admin"])->get();
             if(count($admin)==0 || $_SESSION["passwd"]!=$admin[0]->adminpassword){
                 header("location:/123xxxadmin/login");exit;
             }
         }else{
             header("location:/123xxxadmin/login");exit;
         }

          $route = Route::currentRouteAction();
          list($this->controller, $action) = explode('@', $route);
          View::share('controller', $this->controller);
 
          $fields_show = array();
          foreach ($this->fields_show as $field) {
               $fields_show[$field] = $this->fields_all[$field];
          }
          View::share('fields_show', $fields_show);
 
          $fields_edit = array();
          foreach ($this->fields_edit as $field) {
               $fields_edit[$field] = $this->fields_all[$field];
          }
          View::share('fields_edit', $fields_edit);
 
          $fields_create = array();
          foreach ($this->fields_create as $field) {
               $fields_create[$field] = $this->fields_all[$field];
          }
          View::share('fields_create', $fields_create);
 
          View::share('input', Input::all());
		  if(empty($_SESSION["admin"])){
			 header("location:http://pillele.cn/123xxxadmin/login");exit;
		 }
     }
}