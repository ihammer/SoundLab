<?php namespace Capsule\Api\Actions\Auth;

use Cache, Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\ValidationFailureException;
use Laracasts\Commander\Events\DispatchableTrait;
use Illuminate\Validation\Factory;

class Reset extends Base {

	use DispatchableTrait;

	protected $user;
	protected $validator;

	public function __construct(User $user, Factory $validator)
	{
		$this->user = $user;
		$this->validator = $validator;
	}

	public function run()
	{
		$mobile   = $this->input('mobile');
		$code     = $this->input('code');
		$password = $this->input('password');
		$input = compact('mobile', 'code', 'password');
		$savedCode = Cache::get($mobile);

		$rules = [
			'mobile'   => 'required',
			'code'     => "required|in:{$savedCode}",
			'password' => 'required',
		];

		$validator = $this->validator->make($input, $rules);
		if ( $validator->fails() ) 
		{
        	throw (new ValidationFailureException)
        		->setErrors($validator->errors())
        		->setInput($validator->getData());
		}
		if ( is_null($user = $this->user->where('mobile', '=', $mobile)->first()) ) 
		{
			return $this->respondWithError('ResourceNotFound', 404);
		}
		$user->changePassword($password)->save();
		$this->dispatchEventsFor($user);
		Cache::forget($mobile);
		return Response::json(['status' => true]);
	}
}