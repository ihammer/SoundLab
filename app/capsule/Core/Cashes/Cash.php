<?php namespace Capsule\Core\Cashes;

use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class Cash extends Entity {

	use EventGenerator;

	protected $guarded = [];
	protected $table   = "cashes";
	
	public static function start($cash1,$alipay,$user_id)
	{
		$cash = new static;
		$cash->cash    = $cash1 < 100 ? $cash1-2 : $cash1;
		$cash->alipay   = $alipay;
		$cash->user_id=$user_id;
		$cash->service=$cash1 < 100 ? 2 : 0;
		$cash->status=0;
		return $cash;
	}
}