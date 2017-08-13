<?php namespace Record\Api\Actions\Common;
date_default_timezone_set("Asia/Shanghai");
use Cache, DB, Str;
use Carbon\Carbon;
use Illuminate\Validation\Factory;
use Record\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\ValidationFailureException;

class Sendsms extends Base {

	protected $validator;

	protected $redis;

	protected static $timeout = 1;
	
	
	
	

	public function __construct(Factory $validator)
	{
		$this->validator = $validator;
	}
	
	public function run()
	{
		$input = array('mobile' => $this->input('mobile'), 'type' => $this->input('type'));

		$rules = [
			//'mobile' => 'required|numeric|between:13000000000,18999999999|unique:users,mobile',
			'mobile' => 'required|numeric|between:13000000000,18999999999',
			'type'   => 'required',
		];

		if ( $this->input("type") === 'reset' ) 
		{
			$rules = ['mobile' => 'required|numeric|between:13000000000,18999999999'];
		}

		$validator = $this->validator->make($input, $rules);
		if ( $validator->fails() ) 
		{
			//var_dump($validator->errors());echo "<br><br>";
			//var_dump($validator->getData());exit;
			
			$this->throwValidationException($validator->errors(), $validator->getData());
		}
		if( $this->input("type")!='reset'){
			$user=DB::connection('mysql_records')->table('users')->where('mobile', '=', $input['mobile'])->count();
			if($user>0){
				$ret["errors"]=array(array("code"=>"ValidationFailure","detail"=>"手机号 已经存在"));
				return $ret;
			}
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
			$mobile = DB::connection('mysql_records')->table('mobiles')->where('mobile', '=', $input['mobile'])->where('type', '=', $input['type'])->first();
			$cur_time=time();
			
				if ( $mobile ) 
				{
					if(strtotime($mobile->updated_at)+60 < $cur_time){
						DB::connection('mysql_records')->table('mobiles')->where('mobile', '=', $input['mobile'])
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
					DB::connection('mysql_records')->table('mobiles')->insert([
						'mobile' => $input['mobile'],
						'type'   => $input['type'],
						'is_verified' => 0,
						'try_count' => 0,
						'created_at' => new Carbon,
					]);
				}
				$template = sprintf('【声音实验室】您的校对号是%s', $codeString);
				//$template = sprintf('【灵犀一点科技文化有限公司】您的验证码是%s', $codeString);
				//$template = sprintf('【Sound Lab】您的验证码是%s。如非本人操作，请忽略本短信', $codeString);
				$result = json_decode($sms->send($input['mobile'], $template), true);//return $result;
				if ( $result['code'] != 0 ) 
				{
					throw new \Exception();
				}
				$expiresAt = Carbon::now()->addMinutes(1);
				// Redis
				Cache::put("R".$input['mobile'], $codeString, $expiresAt);
			//}else{
				//return $this->respondWithError('sendSmsFailed'.date("Y-m-d H:i:s",$cur_time), 400);
			//}
			
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