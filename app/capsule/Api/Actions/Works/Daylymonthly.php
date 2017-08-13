<?php namespace Capsule\Api\Actions\Works;
use DB;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Daylymonthly extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	public function run()
	{
		$where=array('is_private'=>0,'is_recommend'=>1);
		//$worksTotal = $this->work->where('is_private', '=', 0)->count();
		$worksTotal = $this->work->where($where)->count();
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 30);
		list($pages, $page) = $this->calculatePagination($worksTotal, $page, $count);
		//$list["data"]=DB::table("tags")->where("is_recommand1","=",1)->select("name")->skip($start)->take(5)->orderBy("date1","desc")->get();
		$banner=DB::table("banners")->where("status","=",1)->select("image","type","detail")->get();;
		if($banner){
			$this->document->addMeta('banner', $banner);
		}
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		//$this->document->addMeta('topic', $list["data"]);
		$start = ($page - 1) * $count;
		//$works = $this->work->with('author')->where('is_private', '=', 0)->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		$works = $this->work->with('author')->where($where)->skip($start)->take($count)->orderBy('recommendtime', 'desc')->get();
		$serializer = new WorkBasicSerializer();
        $document = $this->document->setData($serializer->collection($works));
        return $this->respondWithDocument($document);exit;
	}
}