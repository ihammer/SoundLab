<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Discover extends Base {
	
	protected $work;
	
	public function __construct(Work $work,User $user)
	{
		$this->work = $work;
		$this->user = $user;
	}
	
	public function run()
	{
		$type = intval($this->input('type', 0));
		$page  = max(1, intval($this->input('p', 0)));
		$serializer = new WorkBasicSerializer();
		if($type==0){
			$where=array("is_compshow"=>1,"deleted_at"=>null);
			if($page==1){
				//$labx1=DB::select('SELECT  `works`.`id` , COUNT( * ) AS comm_count,  `works`.`user_id` ,  `title` ,  `username` ,  `cover` ,  `comptime` ,  `type_id` ,  `price` FROM  `works` LEFT JOIN  `works_comments` ON  `works`.`id` =  `works_comments`.`work_id` WHERE  `works`.`deleted_at` IS NULL AND (`works`.`is_compshow` =1 AND  `works`.`deleted_at` IS NULL) AND (`works`.`is_compshowtype` =1 AND  `works`.`type_id` =1) GROUP BY  `works_comments`.`work_id` ORDER BY  `works`.`created_at` DESC LIMIT 0,6');
				$labx1=$this->work->where($where)->where(array("is_compshowtype"=>1,"type_id"=>1))->skip(0)->take(6)->orderBy('created_at', 'desc')->select("id","user_id","title","username","cover","comptime","type_id","price")->get();
				$labx1count=$this->work->where($where)->where(array("type_id"=>1))->count();
				$labx1[0]->comp_time=$labx1[0]->comptime;
				$labx1[0]->comptime=$labx1count;
				//$labx2=DB::select('SELECT  `works`.`id` , COUNT( * ) AS comm_count,  `works`.`user_id` ,  `title` ,  `username` ,  `cover` ,  `comptime` ,  `type_id` ,  `price` FROM  `works` LEFT JOIN  `works_comments` ON  `works`.`id` =  `works_comments`.`work_id` WHERE  `works`.`deleted_at` IS NULL AND (`works`.`is_compshow` =1 AND  `works`.`deleted_at` IS NULL) AND (`works`.`is_compshowtype` =1 AND  `works`.`type_id` =2) GROUP BY  `works_comments`.`work_id` ORDER BY  `works`.`created_at` DESC LIMIT 0,6');
				$labx2=$this->work->where($where)->where(array("is_compshowtype"=>1,"type_id"=>2))->skip(0)->take(6)->orderBy('created_at', 'desc')->select("id","user_id","title","username","cover","comptime","type_id","price")->get();
				$labx2count=$this->work->where($where)->where(array("type_id"=>2))->count();
				$labx2[0]->comp_time=$labx2[0]->comptime;
				$labx2[0]->comptime=$labx2count;
				//$labx3=DB::select('SELECT  `works`.`id` , COUNT( * ) AS comm_count,  `works`.`user_id` ,  `title` ,  `username` ,  `cover` ,  `comptime` ,  `type_id` ,  `price` FROM  `works` LEFT JOIN  `works_comments` ON  `works`.`id` =  `works_comments`.`work_id` WHERE  `works`.`deleted_at` IS NULL AND (`works`.`is_compshow` =1 AND  `works`.`deleted_at` IS NULL) AND (`works`.`is_compshowtype` =1 AND  `works`.`type_id` =3) GROUP BY  `works_comments`.`work_id` ORDER BY  `works`.`created_at` DESC LIMIT 0,6');
				$labx3=$this->work->where($where)->where(array("is_compshowtype"=>1,"type_id"=>3))->skip(0)->take(6)->orderBy('created_at', 'desc')->select("id","user_id","title","username","cover","comptime","type_id","price")->get();
				$labx3count=$this->work->where($where)->where(array("type_id"=>3))->count();
				$labx3[0]->comp_time=$labx3[0]->comptime;
				$labx3[0]->comptime=$labx3count;
				//$labx4=DB::select('SELECT  `works`.`id` , COUNT( * ) AS comm_count,  `works`.`user_id` ,  `title` ,  `username` ,  `cover` ,  `comptime` ,  `type_id` ,  `price` FROM  `works` LEFT JOIN  `works_comments` ON  `works`.`id` =  `works_comments`.`work_id` WHERE  `works`.`deleted_at` IS NULL AND (`works`.`is_compshow` =1 AND  `works`.`deleted_at` IS NULL) AND (`works`.`is_compshowtype` =1 AND  `works`.`type_id` =4) GROUP BY  `works_comments`.`work_id` ORDER BY  `works`.`created_at` DESC LIMIT 0,6');
				$labx4=$this->work->where($where)->where(array("is_compshowtype"=>1,"type_id"=>4))->skip(0)->take(6)->orderBy('created_at', 'desc')->select("id","user_id","title","username","cover","comptime","type_id","price")->get();
				$labx4count=$this->work->where($where)->where(array("type_id"=>4))->count();
				$labx4[0]->comp_time=$labx4[0]->comptime;
				$labx4[0]->comptime=$labx4count;
				$this->document->addMeta('labx1', $labx1);//$labx1);//,$labx2,$labx3,$labx4);周边 线下活动 生活方式
				$this->document->addMeta('labx2', $labx2);
				$this->document->addMeta('labx3', $labx3);
				$this->document->addMeta('labx4', $labx4);
			}
		}else{
			$where=array("is_compshow"=>1,"deleted_at"=>null,"type_id"=>$type);
		}
		$worksTotal = $this->work->where($where)->count();
		$count = $this->input('limit', 16);
		list($pages, $page) = $this->calculatePagination($worksTotal, $page, $count);
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$start = ($page - 1) * $count;
		$works = $this->work->where($where)->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
        $document = $this->document->setData($serializer->collection($works));
        return $this->respondWithDocument($document);
	}
}