<?php namespace Capsule\Core;

use Illuminate\Validation\Validator;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Entity extends Eloquent {

	const CLEAN_URL_CHECK_LIMIT = 1000;
	const CLEAN_URL_DEFAULT_SEPARATOR = '-';

	protected static $rules = [];
    protected static $messages = [];
    protected $validator;

	public function isNew()
	{
		return !$this->getKey();
	}
    
	public function getId()
	{
		return $this->getKey();
	}

	// public function generateCleanURL()
	// {
	// }

    public function __construct(array $attributes = [], Validator $validator = null)
    {
        parent::__construct($attributes);
        $this->validator = $validator ?: \App::make('validator');
    }

    public function valid()
    {
        return $this->getValidator()->passes();
    }

    public function assertValid()
    {
        $validation = $this->getValidator();
        if ($validation->fails()) {
            $this->throwValidationException($validation->errors(), $validation->getData());
        }
    }

    protected function getValidator()
    {
        return $this->validator->make($this->attributes, static::$rules, static::$messages);
    }
}