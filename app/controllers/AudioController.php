<?php
class AudioController extends FormController{
	public function __construct()
     {
          $this->model = '\Audio';
          $this->fields_show = [];
          $this->fields_edit = [];
          $this->fields_create = ['title','audio','type_id','cover'];
          parent::__construct();
     }
	 
	 public function index()
   {
        $model = new $this->model;
        $models = $model->join("audios_types","audios.type_id","=","audios_types.id")->select('audios.id','audios.title','audios_types.name','audios.created_at')->orderBy('id', 'desc')->get();//print_r($models);exit;
        return View::make('form.audiolist', [
             'models' => $models,
        ]);
   }
   
   public function create()
     {
     			$upload=new UploadController();
		 			$models = DB::table("audios_types")->get();
          return View::make('form.audiocreate', [
               'models' => $models,'token' => $upload->token,
          ]);
     }
	 
	public function edit($id)
     {
	     $host="http://7xikb7.com1.z0.glb.clouddn.com/";
          $model = new $this->model;
          $model = $model->find($id);
          $models = DB::table("audios_types")->get();
          return View::make('form.audioedit',[
             'models' => $models,
             'model' => $model,
             'host'=>$host,
             
        ]);
     }
 
     public function update($id)
     {
	     $input=Input::all();
	     $model = new $this->model;
	     $model = $model->find($id);
	     $model->title=$input["title"];
	     $model->cover=$input["cover"];
	     $model->audio=$input["audio"];
	     $model->type_id=$input["type_id"];
	     $model->save();
	     return Redirect::to(action($this->controller . '@index'));
     }
     
     public function store()
     {
     			$input=Input::all();//print_r($input);exit;
          DB::table("audios")->insert($input);
 
          return Redirect::to(action($this->controller . '@index'));
     }
	 
	 public function delaudio()
	 {
		 $this->destroy($_GET["id"]);
		 return Redirect::to(action($this->controller . '@index'));
	 }
 
     public function destroy($id)
     {
         $model = new $this->model;
         $model->destroy($id);
         
     }
}