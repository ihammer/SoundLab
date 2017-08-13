<?php
class TagController extends FormController{
	public function __construct()
     {
          $this->model = '\Tag';
          $this->fields_show = [];
          $this->fields_edit = [];
          $this->fields_create = [];
          parent::__construct();
     }
	 
	 public function index()
   {
        $model = new $this->model;
        $builder = $model->orderBy('id', 'desc');

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

        $recommand=isset($_GET["recommand"]) ? $_GET["recommand"] : 0;
        
        if($recommand==1){
          $where = array(
            "is_recommand1" => 1,
            "is_recommand2" => 0,
          );
        }else if($recommand==2){
          $where = array(
            "is_recommand1" => 0,
            "is_recommand2" => 1,
          );
        }else if($recommand==3){
          $where = array(
            "is_recommand1" => 1,
            "is_recommand2" => 1,
          );
        }
	  //$models = $builder->paginate(20);
        if($recommand==0){
          $models = $builder->get();
        }else{
    	   $models = $builder->where($where)->get();
        }
        return View::make('form.taglist', [
             'models' => $models,
             'recommand' => $recommand,
        ]);
   }
   
   public function utag()
   {
        $builder = DB::table("utags")->orderBy('id', 'desc');

        /*$input = User::all();
        foreach ($input as $field => $value) {
             if (empty($value)) {
                  continue;
             }
             if (!isset($this->fields_all[$field])) {
                  continue;
             }
             $search = $this->fields_all[$field];
             $builder->whereRaw($search['search'], [$value]);
        }*/
	  //$models = $builder->paginate(20);
	  //echo 123;die;
	  $models = $builder->get();//print_r($models);die;
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

  public function recommandFb()
  {
    DB::table('tags')->where('id', $_POST["id"])->update(array('is_recommand' => $_POST["is_recommand"],"date0"=>date("Y-m-d H:i:s",time())));
  }
     
  public function recommandReg()
	{
		DB::table('tags')->where('id', $_POST["id"])->update(array('is_recommand3' => $_POST["is_recommand"],"date0"=>date("Y-m-d H:i:s",time())));
	}
	
	public function ajaxTag()
	{
		DB::table('tags')->where('id', $_POST["id"])->update(array('name' => $_POST["tagname"]));
	}
	
	public function recommandRel()
	{
		DB::table('tags')->where('id', $_POST["id"])->update(array('is_recommand1' => $_POST["is_recommand1"],"date1"=>date("Y-m-d H:i:s",time())));
		//DB::table('tags')->where('id', $_GET["id"])->update(array("topicDetail"=>$_GET["reason"],'is_recommand1' => $_GET["is_recommand1"],"date1"=>date("Y-m-d H:i:s",time())));
	
	}

  public function recommandRelr()
  {
    DB::table('tags')->where('id', $_POST["id"])->update(array("topicDetail"=>$_POST["reason"],"date1"=>date("Y-m-d H:i:s",time())));
    //DB::table('tags')->where('id', $_GET["id"])->update(array("topicDetail"=>$_GET["reason"],'is_recommand1' => $_GET["is_recommand1"],"date1"=>date("Y-m-d H:i:s",time())));
  
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

     public function ajaxUtagadd()
  {
    //DB::table('utags')->where('id', $_POST["id"])->update(array('name' => $_POST["tagname"]));
    DB::table('tags')->insert(
    array(
      array(
      'name' => $_POST["name"],
      'user_id' => 1,
      'count'=> 0
      )
    ));
    echo 1;
  }
}