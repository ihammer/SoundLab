<?php
class TestController extends BaseController{
	public function __construct()
	{
	     parent::__construct();
	}
	public function index()
	{
		$likes=DB::table("works_tags")->where("tag_id","=",531)->get();
		foreach($likes as $item){
			$work=DB::table("works")->where(array("id"=>$item->work_id,"deleted_at"=>NULL))->get();
			if($work){
				DB::update("UPDATE users SET score = score+10 WHERE id = ".$work[0]->user_id);
				DB::update("UPDATE works SET score = score+10 WHERE id = ".$item->work_id);
			}
			unset($work);
		}
		echo "finish";
	}
}