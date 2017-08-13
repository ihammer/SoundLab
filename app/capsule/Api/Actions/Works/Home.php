<?php

namespace Capsule\Api\Actions\Works;

use DB,
    Sentry;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Newhomepage extends Base {

    protected $work;

    public function __construct(Work $work, User $user) {
        $this->work = $work;
        $this->user = $user;
    }

    public function run() {

       $start_time =  date('Y-m-d',time()-3600*24*30);
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
               $works = $this->work->with('author')->where($where)->whereIn('id',$workIds)->where('created_at','<',$end_time)->where('created_at','>',$start_time)->skip($start)->take(10)->orderBy('play_count','desc')->get(); 
            }elseif($type==1){
             //最热筛选  本周最热
               $works = $this->work->with('author')->where($where)->where('created_at','<',$end_time)->where('created_at','>',$start_time)->skip($start)->take(10)->orderBy('play_count','desc')->get();    
            }elseif($type==2){
                //最新
            $works = $this->work->with('author')->where($where)->skip($start)->take(10)->orderBy('modified','desc')->get();    
            }
            
      
       
      
     $document = $this->document->setData($serializer->collection($works));
       if(!empty($aid) ){
        
        $data = $this->respondToArray($document);
        if(empty($data['data']) ){
          //当没有查询分类下 没数据的时候  就加载‘最新’里面的数据
           //当没有查询分类下 没数据的时候  就加载‘按照时间正序排的’里面的数据
          $topdocument = '';
         // $start = ($page-$page)*10;
          $where1 = array('deleted_at' => null, 'is_private' => 0);
          $works = $this->work->with('author')->where($where1)->whereIn('id',$workIds)->skip($start)->take(10)->orderBy('created_at','asc')->get();
          $document = $this->document->setData($serializer->collection($works));
          return $this->respondWithDocument($document);
        }else{
              $topwork = $this->work->with('author')->whereIn('id',$workIds)->where('top_sort','<>',0)->orderBy('play_count')->get();
              if($topwork){

                  $topdocument = $serializer->collection($topwork);

              }

          $document = $this->document->setData($serializer->collection($works));
          return $this->respondWithDocumentTop($document,$topdocument,$workIds,$page);  
        }
       }else{

          return $this->respondWithDocument($document);
       }   
        
        
       
        









    }

  public function  gettags(){
        $where=array("is_recommand1"=>1);
			$tagTotal=DB::table("tags")->where($where)->count();
			$pages=ceil($tagTotal/9);
			$page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
			$list=DB::table("tags")->where($where)->select("id","name","is_recommand1","count","topicDetail")->skip(0)->take(5)->orderBy("date1", "desc")->get();
	foreach($list as $keys=>$items)
                {
                        $keys=intval($keys);
                        $works [$keys]["tag"]=$items->name;
                        $works [$keys]["usertag"]=$items->is_recommand1;
                        $works [$keys]["topicDetail"]=$items->topicDetail;
                        $works [$keys]["count"]=$items->count;//DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->count();
                        $works [$keys]["works"]=DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->select("works.id","works.title","works.cover","works.play_count as view_count","works.love_count")->orderBy("works.id","desc")->take(12)->get();
                        for($i=0;$i<count($works [$keys]["works"]);$i++){
                                $works [$keys]["works"][$i]->cover="http://7xikb7.com1.z0.glb.clouddn.com/".$works [$keys]["works"][$i]->cover."?imageView2/2/w/200";
                        }
                        if(DB::table("works_tags")->leftJoin("works","works_tags.work_id","=","works.id")->where(array("works_tags.tag_id"=>$items->id,"works.deleted_at"=>null,"works.is_private"=>0))->count()==0){
                                 unset($works [$keys]);
                        }
                        $works  = array_values($works );
                }
                
                return  $works;
    }




}

