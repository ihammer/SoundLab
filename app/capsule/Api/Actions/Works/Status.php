<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry,Response;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkSerializer;

class Status extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	public function run()
	{
		$id   = abs(intval($this->param('id')));
		$work = DB::table("works")->where("id","=",$id)->get();
		return Response::json(['status' => (int)$work[0]->compstatus]);exit;
	}
}