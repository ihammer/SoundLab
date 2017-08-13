<?php namespace Admin;

use Sentry, Input, View, Redirect;
use Capsule\Core\Users\User;
use Capsule\Core\Users\Commands\CreateUserCommand;
use Capsule\Core\Users\Commands\DeleteUserCommand;
use Capsule\Core\Support\Exceptions\ValidationFailureException;
use Laracasts\Commander\CommanderTrait;

class UserController extends \AdminController
{
	use CommanderTrait;

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
		parent::__construct();
	}

	public function getIndex()
	{
           
		$keyword = Input::get('keyword');
		$query = $this->user->newQuery();
		if ( $keyword ) 
		{
			$query = $query->where('username', 'like', '%'.$keyword.'%');
		}
		$users = $query->paginate(10);
		// $create_url = link_to_route("backend.user.create", '用户管理');
		// echo $create_url;
		// var_dump($users->getTotal());
		return View::make('backend.user.index', compact('users', 'keyword'));
	}

	// 新建用户
	public function getCreate()
	{
		return View::make('backend.user.create');
	}

	public function postCreate()
	{
		$user = null;
		$input = [
			'username'              => Input::get('username'),
			'email'                 => Input::get('email'),
			'password'              => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
			'activated'             => Input::get('activated'),
			'user'                  => $user,
		];
		try {
			$user = $this->execute(CreateUserCommand::class, $input);
		}
		catch( ValidationFailureException $exception)
		{
            $this->messageBag->merge($exception->getErrors());
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $this->messageBag->add('email', 'Login field is required.');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $this->messageBag->add('password', 'Password field is required.');
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $this->messageBag->add('email', 'User with this login already exists.');
		}
		return Redirect::back()->withInput()->withErrors($this->messageBag);
	}

	public function getEdit($id)
	{
		try {
			$user = Sentry::findUserById($id);

			print $user;
			// return View::make('backend.users.edit', compact('user'));
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// 
		}
	}
	
	public function postEdit($id)
	{
		try {

			$user = Sentry::findUserById($id);

		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// 
		}
		// redirect
	}

	public function getDelete($id)
	{
		$user = Sentry::getUser();
		try {
			$this->execute(DeleteUserCommand::class, compact('id', 'user'));
			return Redirect::back()->with('success', '删除成功');
		} catch (\Exception $exception)
		{
			return Redirect::back()->with('error' , '删除失败，请重试');
		}
	}
}