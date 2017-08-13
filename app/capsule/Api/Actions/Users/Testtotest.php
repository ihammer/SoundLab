<?php namespace Capsule\Api\Actions\Users;

//use DB, Response, Sentry;
use Capsule\Api\Actions\Base;
use Capsule\Core\Works\Work;
//use Illuminate\Redis\Database as Redis;
//use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Testtotest extends Base {

	protected $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}
	
	public function run()
	{
		$work=$this->work->findOrFail('833');
		var_dump($work->user_id);
	}
}