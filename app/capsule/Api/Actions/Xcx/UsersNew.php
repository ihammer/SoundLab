<?php namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkSerializer;

class UsersNew extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$id  = abs(intval($this->param('id')));

		if(!in_array($id,array('2610', '2115', '204029','203983','4609','203840','67','7626','44073','14479','187373'))){
            $data['status']="400";
            $data['mag']="这个用户暂时不开放哦！";
            return Response::json($data);
        }
        $works = $this->work->with('author')->where('user_id', $id)->orderByRaw('RAND()')->first();
        $previousId = $this->work->where('id', '<', $works->id)->where('user_id', $id)->max('id');
        $nextId     = $this->work->where('id', '>', $works->id)->where('user_id', $id)->min('id');
        $data = array(
            'status'=>200,
            'data'  => array(
                'id'      => $works->id,
                'play_url' => $works->playurl,
                'username' => $works->author->username,
                'title'    => $works->title,
                'previous_id' => $previousId,
                'next_id'     => $nextId,
                'duration'     => $works->duration

            )
        );
        return Response::json($data);

	}
}