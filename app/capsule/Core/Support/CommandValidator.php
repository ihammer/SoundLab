<?php namespace Capsule\Core\Support;

use Illuminate\Validation\Factory;
use Capsule\Core\Support\Exceptions\ValidationFailureException;

class CommandValidator {
	
	protected $rules;

	protected $validator;
	
	public function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}

	public function validate($command)
	{
		$validator = $this->validator->make(get_object_vars($command), $this->rules);
		if ( $validator->fails() ) 
		{
			$this->throwValidationException($validator->errors(), $validator->getData());
		}
	}
	
	public function throwValidationException($errors, $input)
	{
		$exception = new ValidationFailureException();
        $exception->setErrors($errors)->setInput($input);
        throw $exception;
	}
}