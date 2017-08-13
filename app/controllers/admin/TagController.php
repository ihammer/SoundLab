<?php namespace Admin;

use Sentry, Input, View, Redirect;
use Capsule\Core\Tags\Tag;
use Capsule\Core\Tags\Commands\CreateTagCommand;
use Capsule\Core\Tags\Commands\DeleteTagCommand;
use Capsule\Core\Support\Exceptions\ValidationFailureException;
use Laracasts\Commander\CommanderTrait;

class TagController extends \AdminController {

	use CommanderTrait;

	protected $tag;

	public function __construct(Tag $tag)
	{
		$this->tag = $tag;
	}

	public function getIndex()
	{
		$tags = $this->tag->paginate(10);

		return View::make('backend.tag.index', compact('tags'));
	}

	public function getCreate()
	{
		return View::make('backend.tag.create');
	}

	public function postCreate()
	{
		$input = [
			'name' => Input::get('name'),
			'recommand' => Input::get('recommand'),
			'user' => null,
		];

		try {
			$tag = $this->execute(CreateTagCommand::class, $input);
		} catch(\Exception $exception)
		{
			exit('create failed');
		}
		// 创建成功返回编辑页面
		return Redirect::route('backend.tag.edit', $tag->id);
	}

	public function getEdit($id)
	{
		// 
	}

	public function postEdit($id)
	{
		// 
	}

	public function getDelete($id)
	{
		$user = null;

		$tag = $this->execute(DeleteTagCommand::class, compact('id', 'user'));
		
		// printf("<pre>%s</pre>", print_r(\DB::getQueryLog(), true));
		return Redirect::route('backend.tag.index');
	}
}
