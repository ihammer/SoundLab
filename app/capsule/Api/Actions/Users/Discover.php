<?php namespace Capsule\Api\Actions\Users;
use DB,Sentry,Response,Cache;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Api\Serializers\UserSerializer;

class Discover extends Base {
	
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function run()
	{
		$type=isset($_GET["type"]) ? $_GET["type"] : 0;
	        $hot = isset($_GET["hot"]) ? $_GET["hot"] : 0;
        
        /*	if($hot){

                	$data= $this->gethotdata();
                	$return['data'] = $data;
                	return  $return;exit;
                }*/
           	if($type==0){
			$where=array("recommend"=>1);
		}else{
			$where=array("recommend"=>1,"utype_id"=>$type);
		}
		$userTotal=DB::table("users")->where($where)->count();
		$pages=ceil($userTotal/10);
	//	$page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
                $page=isset($_GET["p"]) ? $_GET["p"] : 1;      
		$list=DB::table("users")->where($where)->select("id","username","avatar","introduce","sex","location")->orderBy("recommendtime","desc")->skip(($page-1)*10)->take(10)->get();
		$me = Sentry::getUser();
		if($list){
			foreach($list as $key=>$items)
			{       
                                $occupation = DB::table("user_authentication")->where('userid', $items->id)->get();  
				$works["data"][$key]["id"]=$items->id;
				$works["data"][$key]["username"]=$items->username;
				$works["data"][$key]["avatar"]="http://7xikb7.com1.z0.glb.clouddn.com/".$items->avatar."?imageView2/2/w/300";
				$works["data"][$key]["introduce"]=$items->introduce;
				$works["data"][$key]["sex"]=$items->sex;
				$works["data"][$key]["occupation"]=$occupation?$occupation[0]->occupation:'';
                                $works["data"][$key]["location"]=$items->location;
			        $works["data"][$key]["labx"]=$this->labx($items->id);
                                $works["data"][$key]["dm"]=$this->dm($items->id);  
                                $works["data"][$key]["occupation"]=$this->occupation($items->id);
                         	$user = $this->user->findOrFail($items->id);
				$works["data"][$key]["follow"]=0;
				if($me){
					if( $me->isFollowing($user) && !($user->isFollowing($me)) )
					{
						$works["data"][$key]["follow"]=1;
					}elseif( $me->isFollowing($user) && $user->isFollowing($me) )
					{
						$works["data"][$key]["follow"]=2;
					}
				}
				$works["data"][$key]["works"]=DB::table("works")->where(array("user_id"=>$items->id,"is_musician"=>1,"deleted_at"=>null))->select("works.id","works.title","works.cover","works.view_count","works.love_count")->orderBy("id","desc")->get();
				for($i=0;$i<count($works["data"][$key]["works"]);$i++){
					$works["data"][$key]["works"][$i]->cover="http://7xikb7.com1.z0.glb.clouddn.com/".$works["data"][$key]["works"][$i]->cover."?imageView2/2/w/150";
				}
			}
		}else{
			$works["data"]=array();
		}
                /*
		if(count($works["data"])!=0){
			for($i=0;$i<count($works["data"]);$i++){
				$shuff[]=$i;
			}
			shuffle($shuff);
		
			for($i=0;$i<count($works["data"]);$i++){
				$nworks["data"][]=$works["data"][$shuff[$i]];
			}
		}else{
			$nworks=$works;
		}
                */
		$works["meta"]["page"]=$page;
		$works["meta"]["pages"]=$pages;
		return $works;exit;
	}




       function gethotdata(){
       // Cache::forget('user_works_data');
    	if (Cache::has('user_works_data'))
		{
		    $data = Cache::get('user_works_data');
		    return  $data;
		}else{


    	$where=array("recommend"=>1);
    	$me = Sentry::getUser();
		$userid = DB::table("users")->where($where)->select("id")->get();
		$list=DB::table("users")->where($where)->select("id","username","avatar","introduce","sex","location")->orderBy("recommendtime","desc")->get();
        $sum_arr = array(); 
        $works = array();
         foreach ($userid as $key => $value) {
              	$num = DB::select('SELECT SUM( play_count )as num  FROM  `works` WHERE user_id ='.$value->id);
              	$sum_arr[$value->id]['userid'] = $value->id;
              	$sum_arr[$value->id]['num'] = $num[0]->num?$num[0]->num:'0';
         }
        // pr($sum_arr);
         foreach($list as $key=>$items)
			{
				
					
				if(array_key_exists($items->id,$sum_arr)){
					$key = $sum_arr[$items->id]['num'];
					$works["data"][$key]['works_play_count'] = $key;
				}
				$occupation = DB::table("user_authentication")->where('userid', $items->id)->get();  
                 
				$works["data"][$key]["id"]=$items->id;
				$works["data"][$key]["username"]=$items->username;
				$works["data"][$key]["avatar"]="http://7xikb7.com1.z0.glb.clouddn.com/".$items->avatar."?imageView2/2/w/300";
				$works["data"][$key]["introduce"]=$items->introduce;
				$works["data"][$key]["sex"]=$items->sex;
				$works["data"][$key]["occupation"]=$occupation?$occupation[0]->occupation:'';
                                $works["data"][$key]["location"]=$items->location;
                                $works["data"][$key]["labx"]=$this->labx($items->id);
                                $works["data"][$key]["dm"]=$this->dm($items->id);
                                $works["data"][$key]["occupation"]=$this->occupation($items->id); 
				$user = $this->user->findOrFail($items->id);
				$works["data"][$key]["follow"]=0;
				if($me){
					if( $me->isFollowing($user) && !($user->isFollowing($me)) )
					{
						$works["data"][$key]["follow"]=1;
					}elseif( $me->isFollowing($user) && $user->isFollowing($me) )
					{
						$works["data"][$key]["follow"]=2;
					}
				}
				$works["data"][$key]["works"]=DB::table("works")->where(array("user_id"=>$items->id,"is_musician"=>1,"deleted_at"=>null))->select("works.id","works.title","works.cover","works.view_count","works.love_count")->orderBy("id","desc")->get();
				for($i=0;$i<count($works["data"][$key]["works"]);$i++){
					$works["data"][$key]["works"][$i]->cover="http://7xikb7.com1.z0.glb.clouddn.com/".$works["data"][$key]["works"][$i]->cover."?imageView2/2/w/150";
				}
			 
			}
krsort($works['data']);
$data = array_values($works['data']);
Cache::put('user_works_data',$data, 10);
return  $data;
         }
    }

   function  labx($userid){
   	    $where = array('user_id'=>$userid,'is_compshow'=>1);
   		$data = DB::table("works")->where($where)->count(); 
   		return $data?'1':'0';
   }
   function  dm($userid){
   	    $where=array('is_private'=>0,'is_recommend'=>1,'user_id'=>$userid);
   		$data = DB::table("works")->where($where)->count(); 
   		return $data?'1':'0';
   }
   function  occupation($userid){
   	    $where=array('userid'=>$userid);
   		$data = DB::table("user_authentication")->where($where)->select('occupation')->get(); 
   		//pr($data);
   		return $data?$data[0]->occupation:'';
   } 
}
