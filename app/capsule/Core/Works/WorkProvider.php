<?php namespace Capsule\Core\Works;

class WorkProvider {
	protected $model = "Capsule\Core\Works\Work";
	public function getById($id){}
	public function findById($id){}
	public function getByTitle($title){}
	public function findByTitle($title){}
	public function findAllByTag($tag){}
	public function createModel()
	{
		$class = '\\'.ltrim($this->model, '\\');
		return new $class;
	}
	public function setModel($model)
	{
		$this->model = $model;
	}
	public function getModel()
	{
		return $this->model;
	}
}