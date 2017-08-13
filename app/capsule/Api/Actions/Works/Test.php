<?php namespace Capsule\Api\Actions\Works;
use DB;
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
		$where=array('is_private'=>0,'is_recommend'=>1);
		$count = $this->input('limit', 10);
		$start = (1 - 1) * $count;
		$works = $this->work->with('author')->where($where)->skip($start)->take($count)->orderBy('recommendtime', 'desc')->get();
		$serializer = new WorkBasicSerializer();
        $document = $this->document->setData($serializer->collection($works));
        return $this->respondWithDocument($document);exit;
	}
}