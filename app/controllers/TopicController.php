<?php
class TopicController extends FormController{
	public function __construct()
     {
          $this->model = '\Banner';
          $this->fields_show = [];
          $this->fields_edit = [];
          $this->fields_create = [];
          parent::__construct();
     }
	 
	 public function index()
   {
        $model = new $this->model;
        $builder = $model->orderBy('id', 'desc');
        return View::make('form.topiclist', [
             'models' => $models,
        ]);
   }
   
   public function create()
     {
          return View::make('form.create');
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