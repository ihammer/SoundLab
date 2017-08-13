<?php namespace Capsule\Core\Tags\Commands;

use Capsule\Core\Tags\Tag;
use Laracasts\Commander\CommandHandler;

class DeleteTagCommandHandler implements CommandHandler {

	protected $tag;

	public function __construct(Tag $tag)
	{
		$this->tag = $tag;
	}

	public function handle($command)
	{
		$user = $command->user;
		$tag = $this->tag->findOrFail($command->id);
		$tag->works()->sync([]);
		$tag->followedUsers()->sync([]);
		$tag->delete();
		return $tag;
	}
}
