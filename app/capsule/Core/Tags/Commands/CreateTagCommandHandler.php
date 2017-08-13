<?php namespace Capsule\Core\Tags\Commands;

use Capsule\Core\Tags\Tag;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class CreateTagCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $tag;

	public function __construct(Tag $tag)
	{
		$this->tag = $tag;
	}
	
	public function handle($command)
	{
		$user = $command->user;

		$tag = $this->tag->create($this->getPayLoad($command));

		$this->dispatchEventsFor($tag);
		
		return $tag;
	}
	
	protected function getPayLoad($command)
	{
		return [
			'user_id'      => 3,
			'name'         => $command->name,
			'count'        => 0,
			'is_recommand' => $command->recommand,
		];
	}
}