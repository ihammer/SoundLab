<?php namespace Capsule\Api\Actions\Cashes;

use DB, Sentry, Input, Response;
use Capsule\Core\Cashes\Cash;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Core\Cashes\Commands\CreateCashCommand;
use Capsule\Api\Actions\Base;

class Refer extends Base {

	protected $cash;

	public function __construct(Cash $cash)
	{
		$this->cash = $cash;
	}

	public function run()
	{
		$user = Sentry::getUser();
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}else {
			if($user->checkPassword($this->input('password'))){
				if($this->input('cash')>2 && $this->input('cash') <= $user->account){
					$input = [
					'user_id'     => $user->getId(),
					'cash'    => $this->input('cash'),
					'alipay'    => $this->input('alipay'),
					];
					try {
						$cash = $this->execute(CreateCashCommand::class, $input);
						$user->account=$user->account-$this->input('cash');
						$user->save();
						return Response::json(['status' => true]);
			        } catch (\Exception $e)
			        {
			        	throw $e;
			        }
				}else{
					return Response::json(['status' => false]);
				}
			}else{
				return Response::json(['status' => false]);
			}
		}
		exit;
	}
}