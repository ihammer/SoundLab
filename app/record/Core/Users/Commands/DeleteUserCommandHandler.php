<?php namespace Record\Core\Users\Commands;

use Record\Core\Users\User;
use Record\Core\Support\Exceptions\PermissionDeniedException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class DeleteUserCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function handle( $command )
	{
		$user = $command->user;
		if ( $user->getId() !== $work->user_id ) 
		{
			throw new PermissionDeniedException();
		}
		$userToDelete = $this->user->findOrFail($command->id);
		$userToDelete->delete();
		// tags
		// works
		// feeds
		$this->dispatchEventsFor($userToDelete);
		return $userToDelete;
	}
}