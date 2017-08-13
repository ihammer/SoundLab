<?php namespace Capsule\Core\Support;

class SMS {

	protected $apiKey;
	/**
	 * The event dispatcher instance.
	 *
	 * @var \Illuminate\Events\Dispatcher
	 */
	protected $events;
	/**
	 * The log writer instance.
	 *
	 * @var \Illuminate\Log\Writer
	 */
	protected $logger;

	public function __construct($api = null) 
	{
		$this->apiKey = $api;
	}

	// 测试sms服务是否可用
	public function test()
	{
		// 
	}

	public function setLogger()
	{
		// 
	}

	public function getLogger()
	{
		// 
	}

	public function setEvent()
	{
		// 
	}
	
	public function getEvent()
	{
		// 
	}

	public function setKey($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function getKey()
	{
		return $this->apiKey;
	}
	/**
	* url 为服务的url地址
	* query 为请求串
	*
	*/
	protected function post($url,$query){
		$data = "";
		$info =parse_url($url);
		$fp   =fsockopen($info["host"],80,$errno,$errstr,30);
		if(!$fp){
			return $data;
		}
		$head ="POST ".$info['path']." HTTP/1.0\r\n";
		$head.="Host: ".$info['host']."\r\n";
		$head.="Referer: http://".$info['host'].$info['path']."\r\n";
		$head.="Content-type: application/x-www-form-urlencoded\r\n";
		$head.="Content-Length: ".strlen(trim($query))."\r\n";
		$head.="\r\n";
		$head.=trim($query);
		$write  = fputs($fp,$head);
		$header = "";

		while ($str = trim(fgets($fp,4096))) 
		{
			$header.=$str;
		}
		while (!feof($fp))
		{
			$data .= fgets($fp,4096);
		}
		return $data;
	}
	/**
	* 普通接口发短信
	* apikey 为云片分配的apikey
	* text 为短信内容
	* mobile 为接受短信的手机号
	*
	*/
	function send($mobile, $text, $callback = null)
	{
		$url          ="http://yunpian.com/v1/sms/send.json";
		$apikey       = $this->apiKey;
		$encoded_text = urlencode("$text");
		$post_string  ="apikey=$apikey&text=$encoded_text&mobile=$mobile";
		$result = $this->post($url, $post_string);
		if (!is_null($callback))  call_user_func($callback, $user, $token);
		return $result;
	}
	/**
	* 模板接口发短信
	* apikey 为云片分配的apikey
	* tpl_id 为模板id
	* tpl_value 为模板值
	* mobile 为接受短信的手机号
	*
	*/
	function sendWithTpl($tpl_id, $tpl_value, $callback = null)
	{
		$url               ="http://yunpian.com/v1/sms/tpl_send.json";
		$encoded_tpl_value = urlencode("$tpl_value");
		$post_string       ="apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
		return $this->post($url, $post_string);
	}
}