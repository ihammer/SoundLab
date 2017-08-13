<?php
class UtagController extends FormController{
	public function __construct()
     {
          $this->model = '\Utag';
          $this->fields_show = [];
          $this->fields_edit = [];
          $this->fields_create = [];
          parent::__construct();
     }
   
   public function index()
   {
   			$model = new $this->model;
        $builder = $model->orderBy('id', 'desc');
			  $models = $builder->get();
        return View::make('form.utaglist', [
             'models' => $models,
        ]);
   }
   
	public function tagop($id){
		$tag=DB::table('tags')->find($id);
		$models = DB::table("works")->leftJoin('works_tags','works.id','=','works_tags.work_id')->leftJoin('users','works.user_id','=','users.id')->where(array("tag_id"=>$id,"deleted_at"=>NULL))->select("users.username","works.*")->get();
		  return View::make('form.tagoplist', [
               'models' => $models,
               'tag' => $tag,
          ]);
	}
     
  public function recommandReg()
	{
		DB::table('tags')->where('id', $_POST["id"])->update(array('is_recommand' => $_POST["is_recommand"],"date0"=>date("Y-m-d H:i:s",time())));
	}
	
	public function ajaxTag()
	{
		DB::table('utags')->where('id', $_POST["id"])->update(array('name' => $_POST["tagname"]));
	}
	public function ajaxUtagadd()
	{
		//DB::table('utags')->where('id', $_POST["id"])->update(array('name' => $_POST["tagname"]));
		DB::table('utags')->insert(
		array(
			array(
			'name' => $_POST["name"],
			'isadmin' => $_POST["isadmin"],
			'count'=> 0
			)
		));
		echo 1;
	}
	
	public function recommandRel()
	{
		DB::table('tags')->where('id', $_POST["id"])->update(array('is_recommand1' => $_POST["is_recommand1"],"date1"=>date("Y-m-d H:i:s",time())));
	}
	
	public function recommandCnt()
	{
		DB::table('tags')->where('id', $_POST["id"])->update(array('is_recommand2' => $_POST["is_recommand2"],"date2"=>date("Y-m-d H:i:s",time())));
	}
	 
	 public function create()
     {
          return View::make('form.create');
     }
	 
	 public function store()
     {
          $model = new $this->model;
          $model->fill(Input::all());
          $model->save();
          return Redirect::to(action($this->controller . '@index'));
     }
	 
	 public function edit($id)
     {
          $model = new $this->model;
          $model = $model->find($id);
          return View::make('form.edit', compact('model'));
     }
 
     public function update($id)
     {
          $model = new $this->model;
          $model = $model->find($id);
          $model->fill(Input::all());
          $model->save();
 
          return Redirect::to(action($this->controller . '@index'));
     }
	 
	 public function deluser()
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