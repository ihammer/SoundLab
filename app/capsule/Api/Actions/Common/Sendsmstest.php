<?php namespace Capsule\Api\Actions\Common;
date_default_timezone_set("Asia/Shanghai");
use Cache, DB, Str;
use Capsule\Api\Actions\Base;

class Sendsmstest extends Base {

	protected static $timeout = 1;
	
	public function run()
	{
		$input = array('mobile' => $this->input('mobile'));
		try {
			$sms = app('sms');
			$template = '【Sound Lab】购买已成功，请保留该短信，凭短信入场。';
			$result = json_decode($sms->send($input['mobile'], $template), true);return $result;exit;
			if ( $result['code'] != 0 ) 
			{
				throw new \Exception();
			}
			
		} catch (\Exception $e)
		{
			return $this->respondWithError('sendSmsFailed', 400);
		}
		return $this->respondWithoutContent();
	}
	public function throwValidationException($errors, $input)
	{
		$exception = new ValidationFailureException();
        $exception->setErrors($errors)->setInput($input);
        throw $exception;
	}

	protected function getConnection()
	{
		// return redis connection
	}
}