<?php namespace Record\Api\Actions\Auth;

use Response, Nsentry, DB;
use Record\Api\Actions\Base;
use Record\Core\Users\User;

class Login extends Base {

	protected $user;
	protected $client_id='YXA6ffR9oOXjEeWfD3lUIHcqVQ';
	protected $client_secret='YXA6mcQ6Qwu5x9eGPVwZH4obRlG3O5s';
	protected $base_url="https://a1.easemob.com/soundlab/soundlab/";
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function run()
	{
		try {
			
			$user = Nsentry::authenticate([
				'mobile' => $this->input('mobile'),
				'password' => $this->input('password'),
			]);
			$res=$this->createUser($user->getId(),$user->getId().$this->input('mobile'));
			if(isset($_POST["deviceToken"])){
				DB::update("UPDATE users SET devicetoken = '".$_POST["deviceToken"]."' WHERE id = ".$user->getId());
			}
			return Response::json([
				'uid' 	=> $user->getId(), 
				'token' => $user->persist_code,
			]);
		} catch(\Exception $e)
		{
			throw $e;
		}
	}
	function createUser($username,$password){
		$url=$this->base_url.'users/'.$username.'/password';
		$options=array(
			"newpassword"=>md5($password)
		);
		$body=json_encode($options);
		$header=array($this->getToken());
		$result=$this->postCurl($url,$body,$header,"put");
		return $result;
	}
	function getToken()
	{
		global $client_id,$client_secret;
		$options=array(
		"grant_type"=>"client_credentials",
		"client_id"=>$this->client_id,
		"client_secret"=>$this->client_secret
		);
		$body=json_encode($options);
		$url=$this->base_url.'token';
		$tokenResult = $this->postCurl($url,$body,$header=array());
		return "Authorization:Bearer ". $tokenResult["access_token"];
	}
	function postCurl($url,$body,$header,$type="POST"){
		//1.����һ��curl��Դ
		$ch = curl_init();
		//2.����URL����Ӧ��ѡ��
		curl_setopt($ch,CURLOPT_URL,$url);//����url
		//1)��������ͷ
		//array_push($header, 'Accept:application/json');
		//array_push($header,'Content-Type:application/json');
		//array_push($header, 'http:multipart/form-data');
		//����Ϊfalse,ֻ������Ӧ������(true�Ļ�������Ӧͷһ����ȡ��)
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt ( $ch, CURLOPT_TIMEOUT,5); // ���ó�ʱ���Ʒ�ֹ��ѭ��
		//���÷�������ǰ�ĵȴ�ʱ�䣬�������Ϊ0�������޵ȴ���
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
		//��curl_exec()��ȡ����Ϣ���ļ�������ʽ���أ�������ֱ�������
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//2)�豸������
		if (count($body)>0) {
			//$b=json_encode($body,true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);//ȫ������ʹ��HTTPЭ���е�"POST"���������͡�
		}
		//��������ͷ
		if(count($header)>0){
		  	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		}
		//�ϴ��ļ��������
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// ����֤֤����Դ�ļ��
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);// ��֤���м��SSL������
		
		//3)�����ύ��ʽ
		switch($type){
			case "GET":
				curl_setopt($ch,CURLOPT_HTTPGET,true);
				break;
			case "POST":
				curl_setopt($ch,CURLOPT_POST,true);
				break;
			case "PUT"://ʹ��һ���Զ����������Ϣ������"GET"��"HEAD"��ΪHTTP��									                     �������ִ��"DELETE"?�������������ε�HTT
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
				break;
			case "DELETE":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
				break;
		}
		
		
		//4)��HTTP�����а���һ��"User-Agent: "ͷ���ַ�����-----����
	
		curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
	
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)' ); // ģ���û�ʹ�õ������
		//5)
		
		
		//3.ץȡURL���������ݸ������
		$res=curl_exec($ch);
	
		$result=json_decode($res,true);
		//4.�ر�curl��Դ�������ͷ�ϵͳ��Դ
		curl_close($ch);
		if(empty($result))
			return $res;
		else
			return $result;
	
	}

	public function throwException()
	{
		 // 
	}
}