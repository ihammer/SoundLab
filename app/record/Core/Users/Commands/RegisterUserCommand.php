<?php namespace Record\Core\Users\Commands;

class RegisterUserCommand {

	public $user;
	// 手机号
	public $mobile;
	// 用户名
	public $username;
	// 密码
	public $password;
	// 头像
	public $avatar;
	// 位置
	public $location;
	// 性别
	public $sex;
	// 验证码
	public $code;
	
	public function __construct($username, $avatar, $location, $sex, $password, $mobile, $code, $introduce, $user = null)
	{return $username;
		$this->mobile   = $mobile;
		$this->username = $username;
		$this->password = $password;
		$this->avatar   = $avatar;
		$this->location = $location;
		$this->sex      = $sex;
		$this->code     = $code;
		$this->introduce     = $introduce;
		$this->user     = $user;
	}
}
