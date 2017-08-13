<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;


class Newest extends Base {
	
	protected $work;
	
	public function __construct(Work $work,User $user)
	{
		$this->work = $work;
		$this->user = $user;
	}
	
	public function run()
	{
		
		$where=array('is_verify'=>1,'deleted_at'=>null,'is_private'=>0);
		
		//$worksTotal = $this->work->where('is_private', '=', 0)->count();
		$worksTotal = $this->work->where($where)->count();
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 50);
		list($pages, $page) = $this->calculatePagination($worksTotal, $page, $count);
		$list=DB::table("tags")->where("is_recommand1","=",1)->select("name","count")->skip(0)->take(5)->orderBy("date1","desc")->get();//echo json_encode($list["data"]);exit;
		$banner=DB::table("banners")->where("status","=",1)->select("image","type","detail")->get();;
		if($banner){
			$this->document->addMeta('banner', $banner);
		}
		$this->document->addMeta('topic', $list);
		/*$listpeople=DB::table("users")->where("works_count",">",0)->select("id","username","avatar","introduce","sex","location")->orderBy("last_login","desc")->skip(0)->take(3)->get();//return $list;exit;
		$me = Sentry::getUser();//if($me){return $me->getId();exit;}
		foreach($listpeople as $key=>$items)
		{
			$people["data"][$key]["id"]=$items->id;
			$people["data"][$key]["username"]=$items->username;
			$people["data"][$key]["avatar"]="http://7xikb7.com1.z0.glb.clouddn.com/".$items->avatar."!cover";
			$people["data"][$key]["introduce"]=$items->introduce;
			$people["data"][$key]["sex"]=$items->sex;
			$people["data"][$key]["location"]=$items->location;
			$user = $this->user->findOrFail($items->id);
			$people["data"][$key]["follow"]=0;
			if($me){
				if( $me->isFollowing($user) && !($user->isFollowing($me)) )
				{
					$people["data"][$key]["follow"]=1;
				}elseif( $me->isFollowing($user) && $user->isFollowing($me) )
				{
					$people["data"][$key]["follow"]=2;
				}
			}
		}
		$this->document->addMeta('people', $people["data"]);
		$this->document->addMeta('peoplenum', 9);*/
		$this->document->addMeta('topicnum', rand(4,10));
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$this->document->addMeta('newsCount', $worksTotal);
		$start = ($page - 1) * $count;
		//$works = $this->work->with('author')->where('is_private', '=', 0)->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		if ( empty($user = Sentry::getUser()) ) 
		{
			$works = $this->work->with('author')->where($where)->skip($start)->take($count)->orderBy('modified', 'desc')->get();
		}else{
			$orwhere=array('is_verify'=>2,'deleted_at'=>null,'is_private'=>0,'user_id'=>$user->id);
			$works = $this->work->with('author')->where($where)->orWhere($orwhere)->skip($start)->take($count)->orderBy('modified', 'desc')->get();
			//$works = $this->work->with('author')->where($where)->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		}
		//$shuff = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19);
		//shuffle($shuff);
		
		/****for($i=0;$i<count($works);$i++){
			//echo $key."<br><br>";
			$nworks[]=$works[$shuff[$i]];
		}/****/
		//shuffle(array_merge($works));
		//print_r($nworks);
		$serializer = new WorkBasicSerializer();
        $document = $this->document->setData($serializer->collection($works));
        return $this->respondWithDocument($document);
	}
}