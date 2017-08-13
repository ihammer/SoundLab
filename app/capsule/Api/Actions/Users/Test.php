<?php namespace Capsule\Api\Actions\Users;
use DB,Queue;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Test extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	public function run()
	{
		
	   $start_time =  date('Y-m-d',time()-3600*24*7*3);
       $end_time = date('Y-m-d', time());
       $aid = $this->input('aid'); //标签筛选
       $type = $this->input("type"); //type =1 最热   2  最新
       $serializer = new WorkBasicSerializer();
       if(!empty($aid)){
           $workIds = DB::table('works_tags')->where(array('tag_id'=>$aid))->lists('work_id');
       } 


         $where = array('is_verify' => 1, 'deleted_at' => null, 'is_private' => 0);
        if(!empty($aid)){ 
            $worksTotal = $this->work->where($where)->whereIn('id',$workIds)->where('created_at','<',$end_time)->where('created_at','>',$start_time)->count();  //加标签筛选
        }elseif($type==1){
            $worksTotal = $this->work->where($where)->where('created_at','<',$end_time)->where('created_at','>',$start_time)->count();    
        }else{
            $worksTotal = $this->work->where($where)->count();
        }
        $page =  intval($this->input('p', 1));
        $count = $this->input('limit', 50);
        

        $banner = DB::table("banners")->where("status", "=", 1)->select("image",
                        "type", "detail")->get();
        
        if ($banner) {
            $this->document->addMeta('banner', $banner);
        }
      //  $this->document->addMeta('topic', $list);

     /*   
        $this->document->addMeta('topicnum', rand(4, 10));
        $this->document->addMeta('page', $page);
        $this->document->addMeta('pages', $pages);
        $this->document->addMeta('newsCount', $worksTotal);
    */   
     $start = ($page-1)*10;

            if(!empty($aid)){
               
                $works = $this->work->with('author')->whereIn('id',$workIds)->where('top_sort','<>',0)->orderBy('play_count','desc')->get();

            }elseif($type==1){
             //最热筛选  本周最热
                $works = $this->work->with('author')->where($where)->where('created_at','<',$end_time)->where('created_at','>',$start_time)->skip($start)->take(10)->orderBy('play_count','desc')->get();    
            }elseif($type==2){
                //最新
				$works = $this->work->with('author')->where($where)->skip($start)->take(10)->orderBy('modified','desc')->get();    
            }
           
          
       if(!empty($aid) ){
        
         //$data = $this->respondToArray($document);
       
		//当没有查询分类下 没数据的时候  就加载‘最新’里面的数据
		//当没有查询分类下 没数据的时候  就加载‘按照时间正序排的’里面的数据
		$topdocument = '';
		
		if($works->count()){
			foreach($works as $v){
				$topIds[]  = $v->id;
			}
			$topDiffIds  = array_diff($workIds, $topIds);

		}else{
			$topDiffIds  = $workIds;
		}
	    	    
		$weekWorks = $this->work->with('author')->where($where)->whereIn('id',$topDiffIds)->where('created_at','<',$end_time)->where('created_at','>',$start_time)->orderBy('play_count','desc')->get(); 
		
		
		if( $weekWorks->count()){
			foreach($weekWorks as $v){
				$weekIds[]  = $v->id;
			}

			if($works->count()){
				$mergeIds = array_unique(array_merge($weekIds, $topIds));
				$commIds  = array_diff($workIds, $mergeIds);
			}else{
				$commIds  = array_diff($workIds, $weekIds);
			}	
		}else{
			$commIds = $workIds;
		}
		
		// $start = ($page-$page)*10;
		$where1 = array('deleted_at' => null, 'is_private' => 0);
		
		$orderWorks = $this->work->with('author')->where($where1)->whereIn('id', $commIds)->skip($start)->take(10)->orderBy('created_at','desc')->get();
		

		$weekDoc = $serializer->collection($weekWorks);
		$topDoc  = $serializer->collection($works);
		$orderDoc = $serializer->collection($orderWorks);
	
		$topList  = $topDoc->toArray();
		$weekList = $weekDoc->toArray();
		$orderList= $orderDoc->toArray();	
		if($page ==1 ){
			$return = array('data' => array_merge($topList, $weekList, $orderList));
		}else{
			$return = array('data' => $orderList);
		}
		
		return  $this->respondWithArray($return, 200, []);
 
       }else{
	   	  $document = $this->document->setData($serializer->collection($works));         
	   	  return $this->respondWithDocument($document);       
       }  
	}
}