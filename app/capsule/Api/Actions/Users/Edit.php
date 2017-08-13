<?php namespace Capsule\Api\Actions\Users;

use Sentry, Input;
use Capsule\Core\Users\User;
use Capsule\Core\Users\Commands\EditUserCommand;
use Capsule\Core\Users\AvatarUploadFailedException;
use Capsule\Core\Users\MobileExistsException;
use Capsule\Core\Support\Exceptions\ValidationFailureException;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\UserBasicSerializer;
use Cartalyst\Sentry\Users\UserExistsException;
use Illuminate\Support\MessageBag;

class Edit extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		$user = Sentry::getUser();
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}

		$input = [
			'user'     => $user,
			'id'       => $user->getId(),
			'username' => $this->input('username'),
			'avatar'   => $this->input('avatar'),
			'sex'      => $this->input('sex'),
			'location' => $this->input('location'),
			'tags'     => $this->input('tags'),   //关注标签
			'persons'  => $this->input('persons'), 
			'introduce'  => $this->input('introduce'), 
		];
		$errors = new MessageBag();
		try {
			$user = $this->execute(EditUserCommand::class, $input);
			$serializer = new UserBasicSerializer();
			$document = $this->document->setData($serializer->resource($user));
        	return $this->respondWithDocument($document);
		} catch( UserExistsException $e) {
			$errors->add('username', '用户名已经被占用');
		} catch(AvatarUploadFailedException $e)
		{
			$errors->add('avatar', '头像上传失败');
		} catch(MobileExistsException $e)
		{
			$errors->add('mobile', '手机号已经被占用');
		}
		if ( $errors->any() ) 
		{
			$exception = new ValidationFailureException();
	        $exception->setErrors($errors)->setInput($input);
	        throw $exception;
		}
	}
}