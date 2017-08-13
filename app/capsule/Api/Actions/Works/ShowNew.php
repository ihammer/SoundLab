<?php namespace Capsule\Api\Actions\Works;
use DB,Sentry,Response;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkSerializer;

class ShowNew extends Base {

	protected $work;
	
	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	public function run()
	{
		$id   = abs(intval($this->param('id')));
		$work = $this->work->findOrFail($id);
		foreach($work->texts as $val){
			//gettype($ret["timeline"]);
			print_r($val["timeline"]);
		}
		print_r($work->texts);exit;
		//$work = DB::table("works")->where("id","=",$id)->get();
		// event
		$work->increment('view_count');
		$serializer = new WorkSerializer();
		//$tl=$work->timeline;
		//return $tl;exit;
		$document = $this->document->setData($serializer->resource($work));
		$document->addLink('waveform', $work->waveform);
		if ( !empty( $user = Sentry::getUser() ) ) 
		{
			$this->document->addMeta('userAvatar', $user->avatar);
		}
		return $this->respondWithDocument($document);exit;
	}
}