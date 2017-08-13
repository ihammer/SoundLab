<?php namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class WorksNew extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$id  = abs(intval($this->param('id')));
        //推荐数据
        $recomend = $this->work->with('author')->where('top_sort','<>',0)->take(4)->orderBy('play_count','desc')->get();
        $serializer = new WorkBasicSerializer();
        $recomend = $serializer->collection($recomend);
		$data = array(
			'recommend' =>$recomend->toArray()
		);
        return Response::json($data);

	}
}