<?php namespace Capsule\Core\Works\Commands;

use Capsule\Core\Works\Work;
use Capsule\Core\Support\Exceptions\PermissionDeniedException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class DeleteWorkCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $work;

	public function __construct(Work $work)
	{
		$this->work = $work;
	}

	public function handle($command)
	{
		$user = $command->user;
		$work = $this->work->findOrFail($command->id);
		// check permission
		if ( $user->getId() !== $work->user_id ) 
		{
			throw new PermissionDeniedException();
		}
		$work->delete();
		$work->author->decrement('works_count');
		$this->dispatchEventsFor($work);
		return $work;
	}
}