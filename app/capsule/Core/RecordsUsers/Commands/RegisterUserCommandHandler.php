<?php namespace Capsule\Core\RecordsUsers\Commands;

use Cache, DB;
use Capsule\Core\RecordsUsers\User;
use Capsule\Core\RecordsUsers\Events\UserWasRegistered;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class RegisterUserCommandHandler implements CommandHandler {

	use DispatchableTrait;

	public function handle( $command )
	{
		$user = $command->user;
		$input = [
			'mobile'   => $command->mobile,
			'username' => $command->username,
			'password' => $command->password,
			'avatar'   => $command->avatar,
			'location' => $command->location,
			'sex'      => $command->sex,
			'introduce'=> $command->introduce,
		];
		if ( !empty($command->code) ) 
		{
			$code = Cache::pull($command->mobile);
			if ( empty($code) ) 
			{
				// throw 
				return false;
			}

			if ( $code !== $command->code ) 
			{
				// throw 
				return false;
			}
		}
		$user = User::register($input);
		$user->save();
		// autologin
		$user->attemptActivation($user->getActivationCode());
		// $userProvider = Sentry::getUserProvider();
		// $userProvider->setModel('Cartalyst\Sentry\Users\Eloquent\User');
		// $user = Sentry::register($input, true);
		// $user->raise(new UserWasRegistered($user));
		// 处理用户上传头像
		if ( !empty($avatarURL = $user->avatar)  && $this->isURL($user->avatar)/* 头像上传到七牛*/ ) 
		{
			// 
		}
		$this->dispatchEventsFor($user);
		return $user;
	}
	
	// @TODO utils
	public function getAvatarFromURL($url)
	{
		$result = null;
		if (ini_get('allow_url_fopen')) {
            $result = file_get_contents($url);
        } else {
        	// curl
        }
        return $result;
	}
	// @TODO utils
	public function isURL($path)
    {
        return (bool) preg_match('/^(https?|ftp):\/\//Ss', $path);
    }
}