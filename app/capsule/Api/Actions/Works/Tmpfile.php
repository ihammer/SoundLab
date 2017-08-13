<?php namespace Capsule\Api\Actions\Works;

use Capsule\Api\Actions\Base;
use Capsule\Core\Works\Work;
use Illuminate\Http\JsonResponse;

class Tmpfile extends Base {

	protected $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$wid  = abs(intval($this->param('id')));
		$work = $this->work->findOrFail($wid);
		$work->increment('play_count');
		return new JsonResponse([
			'tmpfile' => $work->playurl,
			'times'   => $work->play_count
		]);
	}
}