<?php

namespace Capsule\Api\Actions\Works;

use DB,
    Sentry,Response;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;
/*
 * 首页banner图接口
 *
 */

class Hpbanner extends Base {

    protected $work;

    public function __construct(Work $work, User $user) {
        $this->work = $work;
        $this->user = $user;
    }
    
    public function run() {
        $workwhere = array('is_hpbanner' => 1, 'deleted_at' => null, 'is_private' => 0);
        $tagwhere=array("is_banner"=>1);
        
        $worksTotal = $this->work->where($workwhere)->count();
        
	    $tag   = DB::table("tags")->where($tagwhere)->select("id","img","name","is_recommand1","count","topicDetail")->orderBy("banner_at","desc")->get();
       // pr($tag);			
        $work = $this->work->with('author')->where($workwhere)->orderBy('hpbanner_at','desc')->get();
        if($tag){
        foreach($tag as $keys=>$items)
                {
                        $keys=intval($keys);
                        $works [$keys]["tag"]=$items->name;
                        $works [$keys]["img"]="http://7xikb7.com1.z0.glb.clouddn.com/".$items->img;
                        
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
                $tagTotal = count($works);
        }  else {
                $tagTotal = "0";     
        }
        $data['tagsTotal'] = $tagTotal;
        $data['worksTotal'] = $worksTotal;
        $data['feedstagsTotal'] = count($this->gettags());
        $data['works'] = $work;
        $data['tags'] = $works;
        $data['feedstags'] = $this->gettags();
        return Response::json($data);exit;
    }

public function  gettags(){
        $where=array("is_recommand1"=>1);
            $tagTotal=DB::table("tags")->where($where)->count();
            $pages=ceil($tagTotal/9);
            $page=isset($_GET["p"]) ? ($_GET["p"]>$pages ? 1 :$_GET["p"]) : 1;
            $list=DB::table("tags")->where($where)->select("id","name","is_recommand1","count","topicDetail")->skip(0)->take(5)->orderBy("banner_at", "desc")->get();
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
