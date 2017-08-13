<?php namespace Capsule\Api\Actions\Tags;
use Sentry,DB,Response;
use Capsule\Api\Actions\Base;


class Hptaglist1test extends Base {
	
	public function run()
	{
		
	    $where=array("is_compshow"=>1,"deleted_at"=>null);
	    $labx_count = DB::table("works")->where($where)->count();
		$list=DB::table("tags")->where(array("is_homepage"=>1))->select("id","name")->orderBy("homepage_at","desc")->get();
		$labx = DB::table("works")->leftJoin('users','works.user_id','=','users.id')->where(array("is_compshow"=>1,"deleted_at"=>null))->select("users.username as uname","works.*")->orderBy("id","desc")->first();
        $dm = DB::table("works")->leftJoin('users','works.user_id','=','users.id')->where(array("is_recommend"=>1,"deleted_at"=>null))->select("users.username as uname","works.*")->orderBy("id","desc")->first();
        
        $musicPeople = DB::table("users")->where(array("recommend"=>1,"utype_id"=>6))->orderBy("recommendtime","desc")->first();
        $music_count = DB::table("users")->where(array("recommend"=>1,"utype_id"=>6))->count();
        
//         print_r($musicPeople);die;
        $labxData=$this->HandleData($labx,1);
        $DmData=$this->HandleData($dm,2);
        $musicData=$this->HandleData($musicPeople,3);
        
        $DmData["fixed"]    ="今日推荐";
        $labxData["fixed"]  ="项目合作";
        $musicData["fixed"]    ="Lab音乐人";
        
        $labxData["count"]  =$labx_count;
        $musicData["count"] =$music_count;
        
        
        $newData["tags"]=$list;
        $newData["dm"]  =$DmData;
        $newData["labx"]=$labxData;
        $newData["character"]=$musicData;
			
		return Response::json($newData);exit;
	}
	
	
	function HandleData($obj,$type){
// 	    $data["updated_at"]=!empty($obj->updated_at)?$obj->updated_at:"";
	    $data["updated_at"]=date("Y-m-d H:i:s",time());
	    
	    if($type==1||$type==2){
	        $data["title"]=$obj->title;
	        $data["cover"]     ="http://7xikb7.com1.z0.glb.clouddn.com/".(!empty($obj->cover)?$obj->cover:"");
	    }else{
	        $data["title"]=$obj->username;
	        $data["cover"]="http://7xikb7.com1.z0.glb.clouddn.com/".(!empty($obj->avatar)?$obj->avatar:"");
	    }
	    
	    $data['count']     =0;
// 	    $data["updated_at"]=$obj->updated_at;
	    return $data;
	}
}
