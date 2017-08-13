<?php namespace Capsule\Core\Users\Commands;

use Capsule\Core\Temporaryfile;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\PermissionDeniedException;
use Capsule\Core\Users\AvatarUploadFailedException;
use Capsule\Core\Users\MobileExistsException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Cartalyst\Sentry\Users\UserExistsException;

class EditUserCommandHandler implements CommandHandler {
	use DispatchableTrait;

	protected $user;

	protected $tmpfile;

	public function __construct(User $user, Temporaryfile $tmpfile)
	{
		$this->user = $user;
		$this->tmpfile = $tmpfile;
	}

	public function handle( $command )
	{
		$user = $command->user;
		if ( $user->getId() !== $command->id ) 
		{
			throw new PermissionDeniedException(); //401
		}
		if ( $user->getId() !== $command->id )  
		{
			$user = $this->user->findOrFail($command->id);
		}
		// username
		if ( !empty($command->username) ) 
		{
			$persistedUser = $this->user->where('username', '=', $command->username)->first();
			if ( $persistedUser and $persistedUser->getId() != $user->getId() )
			{
				throw new UserExistsException("A user already exists with login [$command->username], logins must be unique for users.");
			}
			$user->changeUsername($command->username);
		}
		// sex
		if ( isset($command->sex) ) 
		{
			$user->sex = $command->sex;
		}
		// location
		if ( !empty($command->location) ) 
		{
			$user->location = $command->location;
		}
		// password
		if ( !empty($command->password) ) 
		{
			$user->changePassword($command->password);
		}
		// introduce
		if ( !empty($command->introduce) ) 
		{
			$user->introduce = $command->introduce;
		}
		// avatar
		if ( !empty($command->avatar) ) 
		{
			if ( is_null($this->tmpfile->findByUrl($command->avatar)) ) 
			{
				throw new AvatarUploadFailedException();
			}
			$user->changeAvatar($command->avatar);
		}

		// mobile
		if ( !empty($command->mobile) ) 
		{
			$persistedUser = $this->user->where('mobile', '=', $command->mobile)->first();
			if ( $persistedUser and $persistedUser->getId() != $user->getId() )
			{
				throw new MobileExistsException();
			}
			$user->changeMobile($command->mobile);
		}
		$user->save();
		$this->dispatchEventsFor($user);
		return $user;
	}
}