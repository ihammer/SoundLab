<?php namespace Capsule\Core\Cashes\Commands;

use Cache, DB;
use Capsule\Core\Cashes\Cash;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class CreateCashCommandHandler implements CommandHandler {

	use DispatchableTrait;

	public function handle( $command )
	{
		$cash = Cash::start(
			$command->cash,     
			$command->alipay,     
			$command->user_id
		);
		$cash->save();
		return $cash;
	}
}