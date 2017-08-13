<?php namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Works extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$id  = abs(intval($this->param('id')));
		
        $works = $this->work->with('author')->where('id', $id)->first();	
		
		$previousId = $this->work->where('id', '<', $id)->max('id');
        $nextId     = $this->work->where('id', '>', $id)->min('id');	
		
        $recomend = $this->work->with('author')->where('top_sort','<>',0)->take(4)->orderBy('play_count','desc')->get();
        
        
        $serializer = new WorkBasicSerializer();
        
        $recomend = $serializer->collection($recomend);


		$data = array(
			'work'  => array(
				
				'id'      => $works->id,
	 			'play_url' => $works->playurl,
				'username' => $works->author->username,
				'title'    => $works->title,
				'previous_id' => $previousId,
				'next_id'     => $nextId,
                'duration'     => $works->duration
				
			),
			'recommend' =>$recomend->toArray()
		);
        return Response::json($data);

	}
}