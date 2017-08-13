<?php namespace Capsule\Core\Users\Commands;

use Sentry;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\CommandHandler;

class CreateUserCommandHandler implements CommandHandler {

	use DispatchableTrait;
	
	public function handle($command)
	{
		$user = $command->user;
		$newUser = Sentry::register($this->getPayLoad($command), !!$command->activated);
		$this->dispatchEventsFor($newUser);
		return $user;
	}
	protected function getPayLoad($command)
	{
		return [
			'username' => $command->username,
			'email'    => $command->email,
			'password' => $command->password,
		];
	}
}