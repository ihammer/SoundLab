<?php namespace Capsule\Api\Actions\Works;
use DB;
use Capsule\Core\Tags\Tag;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Search extends Base {
	
	protected $work;
	protected $tag;

	public function __construct(Work $work, Tag $tag)
	{
		$this->work = $work;
		$this->tag  = $tag;
	}
	
	public function run()
	{
		$q  = $this->input("q");
		$by = $this->input('by');
		$query = $this->work->newQuery()->with('author');
		if ( $q ) 
		{
			if ( $by === 'tag' ) 
			{
				if ( $tag = $this->tag->where('name', '=', $q)->first() ) 
				{
					switch($q)
					{
						case "记录":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("记录","记#录"))->select('works.*');
							break;
						case "音乐":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("音乐","音#乐"))->select('works.*');
							break;
						case "话题":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("话题","话#题"))->select('works.*');
							break;
						case "谈话":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("谈话","谈#话"))->select('works.*');
							break;
						case "读书":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("读书","读#书"))->select('works.*');
							break;
						case "点评":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("点评","点#评"))->select('works.*');
							break;
						case "买卖":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("买卖","买#卖"))->select('works.*');
							break;
						case "观点":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("观点","观#点"))->select('works.*');
							break;
						case "段子":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("段子","段#子"))->select('works.*');
							break;
						case "其他":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("其他","其#他"))->select('works.*');
							break;
						case "故事":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("故事","故#事"))->select('works.*');
							break;
						case "电影":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("电影","电#影"))->select('works.*');
							break;
						case "教学":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("教学","教#学"))->select('works.*');
							break;
						case "旅行":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("旅行","旅#行"))->select('works.*');
							break;
						default:
							$query = $tag->works()->newQuery();
							break;
					}
				} else
				{
					switch($q)
					{
						case "记录":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("记录","记#录"))->select('works.*');
							break;
						case "音乐":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("音乐","音#乐"))->select('works.*');
							break;
						case "话题":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("话题","话#题"))->select('works.*');
							break;
						case "谈话":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("谈话","谈#话"))->select('works.*');
							break;
						case "读书":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("读书","读#书"))->select('works.*');
							break;
						case "点评":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("点评","点#评"))->select('works.*');
							break;
						case "买卖":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("买卖","买#卖"))->select('works.*');
							break;
						case "观点":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("观点","观#点"))->select('works.*');
							break;
						case "段子":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("段子","段#子"))->select('works.*');
							break;
						case "其他":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("其他","其#他"))->select('works.*');
							break;
						case "故事":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("故事","故#事"))->select('works.*');
							break;
						case "电影":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("电影","电#影"))->select('works.*');
							break;
						case "教学":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("教学","教#学"))->select('works.*');
							break;
						case "旅行":
							$query=$this->work->leftJoin("works_tags",'works.id','=','works_tags.work_id')->leftJoin('tags','works_tags.tag_id','=','tags.id')->leftJoin('users','works.user_id','=','users.id')->whereIn("tags.name",array("旅行","旅#行"))->select('works.*');
							break;
						default:
							$query = $query->where('id', '<', 0);
							break;
					}
					
				}
			} else 
			{
				$query = $query->where('title', 'like', '%'.$q.'%');
			}
		}
		$worksTotal=$query->count();
		//$page  = max(1, intval($this->input('p', 0)));
		$page  = intval($this->input('p', 1));
		$count = $this->input('limit', 10);
		$this->document->addMeta('detail', '');
		list($pages, $page) = $this->calculatePagination($worksTotal, $page, $count);
		if ( $tag = $this->tag->where('name', '=', $q)->first() ) 
		{
			if($tag->topicDetail!=""){
				$this->document->addMeta('detail', $tag->topicDetail);
			}
                        $this->document->addMeta('img', $tag->img?"http://7xikb7.com1.z0.glb.clouddn.com/".$tag->img:"");
		}
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$this->document->addMeta('total', $worksTotal);
		$start = ($page - 1) * $count;
		$works = $query->where("works.is_private","=",0)->groupBy('works.id')->skip($start)->take($count)->orderBy('works.created_at', 'desc')->get();
		$serializer = new WorkBasicSerializer();
    $document = $this->document->setData($serializer->collection($works));
    return $this->respondWithDocument($document);
	}
}
