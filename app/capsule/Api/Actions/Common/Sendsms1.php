<?php namespace Capsule\Api\Actions\Common;
date_default_timezone_set("Asia/Shanghai");
use Cache, DB, Str;
use Carbon\Carbon;
use Illuminate\Validation\Factory;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\ValidationFailureException;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class Sendsms1 extends Base {

	protected $validator;

	protected $redis;

	protected static $timeout = 1;
	
	protected $connection = 'mysql_records';

	public function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}
	
	public function run()
	{
	    
		$input = array('mobile' => $this->input('mobile'), 'type' => $this->input('type'));

		$rules = [
			'mobile' => 'required|numeric|between:13000000000,18999999999|unique:users,mobile',
			// 'mobile' => 'required|numeric|between:13000000000,18999999999',
			'type'   => 'required',
		];

		if ( $this->input("type") === 'reset' ) 
		{
			$rules = ['mobile' => 'required|numeric|between:13000000000,18999999999'];
		}

		$validator = $this->validator->make($input, $rules);
		if ( $validator->fails() ) 
		{
			$this->throwValidationException($validator->errors(), $validator->getData());
		}
		try {
			$sms = app('sms');
			$code = array();
			while (count($code) < 4)
			{
				$code[] = rand(0, 9);
				$code = array_unique( $code );
			}
			$codeString = implode('', $code);
			$mobile = DB::table('mobiles')->where('mobile', '=', $input['mobile'])->where('type', '=', $input['type'])->first();
			$cur_time=time();
			
				if ( $mobile ) 
				{
					if(strtotime($mobile->updated_at)+60 < $cur_time){
						DB::table('mobiles')->where('mobile', '=', $input['mobile'])
							->where('type', '=', $input['type'])
							->update([
								'try_count'  => $mobile->try_count + 1,
								'updated_at' => new Carbon,
							]);
					}else{
						return $this->respondWithError('sendSmsFailed'.date("Y-m-d H:i:s",$cur_time), 400);
					}
				} else
				{
					DB::table('mobiles')->insert([
						'mobile' => $input['mobile'],
						'type'   => $input['type'],
						'is_verified' => 0,
						'try_count' => 0,
						'created_at' => new Carbon,
					]);
				}
				
				
				
				// 配置信息
				$config = [
				    'app_key'    => $_ENV['ALIDAYU_APP_KEY'],
				    'app_secret' => $_ENV['ALIDAYU_APP_SECRET'],
				];
				 
				$client = new Client(new App($config));
				$req    = new AlibabaAliqinFcSmsNumSend;
				 
				$req->setRecNum($input['mobile'])
				->setSmsParam([
				    'code' =>$codeString
				])
				->setSmsFreeSignName($_ENV['ALIDAYU_SIGN_NAME'])
				->setSmsTemplateCode($_ENV['ALIDAYU_SMS_ID']);
				 
				 
				$resp = $client->execute($req);
				 
				if ( empty($resp->result->success) )
				{
				   throw new \Exception();die;
				}
				
// 				$template = sprintf('【声音实验室】您的校对号是%s', $codeString);
// 				//$template = sprintf('【灵犀一点科技文化有限公司】您的验证码是%s', $codeString);
// 				//$template = sprintf('【Sound Lab】您的验证码是%s。如非本人操作，请忽略本短信', $codeString);
// 				$result = json_decode($sms->send($input['mobile'], $template), true);//return $result;
// 				if ( $result['code'] != 0 ) 
// 				{
// 					throw new \Exception();
// 				}
				$expiresAt = Carbon::now()->addMinutes(1);
				// Redis
				Cache::put($input['mobile'], $codeString, $expiresAt);
			//}else{
				//return $this->respondWithError('sendSmsFailed'.date("Y-m-d H:i:s",$cur_time), 400);
			//}
			
		} catch (\Exception $e)
		{
			return $this->respondWithError('sendSmsFailed', 500,$resp);
		}
		return $this->respondWithoutContent();
	}
	public function throwValidationException($errors, $input)
	{
		$exception = new ValidationFailureException();
        $exception->setErrors($errors)->setInput($input);
        throw $exception;die;
	}

	protected function getConnection()
	{
		// return redis connection
	}
}