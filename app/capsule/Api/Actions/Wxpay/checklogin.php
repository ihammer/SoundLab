<?php namespace Capsule\Api\Actions\Wxpay;

use Capsule\Api\Actions\Base;
use Sentry,DB;


session_start();

class checklogin extends Base {

	public function run()
	{
	    $_SESSION['userid']="5297";
	    return '{"uid":"5297","token":"$2y$10$BIVeRmUWjXCyLxoIEg5idOng6bxda0W11\/\/g5R9oGd0b23doPIS0."}';
	       
	}
}