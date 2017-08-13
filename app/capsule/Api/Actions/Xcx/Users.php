<?php namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkSerializer;

class Users extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$id  = abs(intval($this->param('id')));
		
        $works = $this->work->with('author')->where('user_id', $id)->orderByRaw('RAND()')->first();	
        
        $previousId = $this->work->where('id', '<', $works->id)->max('id');
        $nextId     = $this->work->where('id', '>', $works->id)->min('id');	
		$data = array(
			'id'      => $works->id,
 			'play_url' => $works->playurl,
			'username' => $works->author->username,
			'title'    => $works->title,
			'previous_id' => $previousId,
			'next_id'     => $nextId,
            'duration'     => $works->duration
		);
        return Response::json($data);

	}
}