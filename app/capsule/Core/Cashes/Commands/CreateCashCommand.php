<?php namespace Capsule\Core\Cashes\Commands;

class CreateCashCommand {

	public $user_id;
	public $cash;
	public $alipay;
		
	public function __construct($user_id, $cash, $alipay)
	{
		$this->user_id   = $user_id;
		$this->cash = $cash;
		$this->alipay = $alipay;
	}
}
