<?php

use Capsule\Core\Users\Token;
use Capsule\Core\Users\Commands\RegisterUserCommand;
use Laracasts\Commander\CommanderTrait;
// exceptions
use Capsule\Core\Support\Exceptions\ProviderNotFoundException;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Token\Exception\ExpiredTokenException;

class AuthController extends BaseController {

	use CommanderTrait;

	protected $token;
	
	public function __construct(Token $token)
	{
		parent::__construct();
		OAuth::setHttpClient('CurlClient');
		$this->token = $token;
	}
	
	public function loginWithDouban()
	{
		$code = Input::get('code');
		$provider = OAuth::consumer( 'Douban' );

		if ( !empty($code) ) 
		{
			$token = $provider->requestAccessToken( $code );
			$params = $token->getExtraParams();
			// 豆瓣每次授权token都不同，所以不能用access_token作为查询条件
		} else
		{
			// 跳转到认证界面
			$url = $provider->getAuthorizationUri();
	      	return Redirect::to( (string)$url );
		}
	}

	// 微博登陆
	public function loginWithSina()
	{
		$provider = OAuth::consumer( 'Sina' );
		return $this->handle($provider);
	}

	// QQ登录
	public function loginWithQQ()
	{
		return "QQ";
	}

	//微信登录
	public function loginWithWeixin()
	{
		return 'weixin';
	}

	protected function handle($provider)
	{
		try {
			$this->checkProvider($provider);
			$code = Input::get('code');
			if ( !empty($code) ) 
			{
				// 豆瓣每次请求到的token都不一样，除了第一次，其它每次访问token都需要更新数据表
				$token = $provider->requestAccessToken( $code );
				$first = false;
				if ( is_null($userToken = $this->hasToken($provider->service(), $token)) ) 
				{
					// 注册新用户
					try {
						$userInfo = $this->getUser($provider);
						// $userinfo === false 没找到提取方法
						// $userinfo === array() 提取失败
						$userToken = $this->token->newInstance();
						$userToken->provider = $provider->service();
						$userToken->access_token = $token->getAccessToken();
						$userToken->refresh_token = !empty($token->getRefreshToken()) ? $token->getRefreshToken() : "";
						$userToken->uid = $userInfo['uid'];
						$userToken->expiry_in = !empty($token->getEndOfLife()) ? $token->getEndOfLife() : 0;

						// 创建新用户
						$user = $this->execute(RegisterUserCommand::class, $userInfo);
						$user->tokens()->save($userToken);
						$first = true;
					} catch (ExpiredTokenException $e)
					{
						exit('token guo qi');
						//是否有refreshtoken
						// 有，通过api延长access_token
						// 无，微博就没有，重新认证，完事更新token
						// 一般到这步不存在token过期的问题。
					}
				} else 
				{
					$user = $userToken->user;
				}

				if ( empty($user) ) 
				{
					return Redirect::to('/')->with('error', '您的用户数据存在异常，请联系系统客服');
				}
				// 如果不是第一次请求token，需要更新token信息，保证token值最新
				if ( !$first ) 
				{
					$userToken->access_token = $token->getAccessToken();
					$userToken->refresh_token = !empty($token->getRefreshToken()) ? $token->getRefreshToken() : "";
					$userToken->expiry_in = !empty($token->getEndOfLife()) ? $token->getEndOfLife() : 0;
					$userToken->save();
				}

				Sentry::login($user, true);
				return Redirect::to('testlogin');
			} else 
			{
				$url = $provider->getAuthorizationUri();
		      	return Redirect::to( (string)$url );
			}
		}catch(ProviderNotFoundException $e) 
		{
			$errorMsg = "你特么点哪儿了";
		}
		catch(TokenResponseException $e)
		{
			$errorMsg = "请求过程中发生错误,请重试";
		}
		catch(\Exception $e)
		{

			$errorMsg = "服务器异常，请稍后重试";
		}
		var_dump($errorMsg);
		exit();
		$redirect = Session::get('loginRedirect', '/');
		return Redirect::to($redirect)->with('error', $errorMsg);
	}
	
	// 每一个有变化的都需要修改这里，太尼玛2
	protected function hasToken($service, $token)
	{
		if ( $service === 'Douban' ) 
		{

		} elseif ( $service === 'Sina' ) 
		{
			return $this->token->where('provider', $service)->where('access_token', $token->getAccessToken())->first();
		}
	}

	protected function createNewUser($userInfo)
	{
		$user = $this->execute(RegisterUserCommand::class, $userInfo);
		return $user;
	}

	protected function checkProvider($provider)
	{
		$activeProviders = Config::get('oauth-4-laravel::consumers');

		if ( is_null($activeProviders) OR !array_key_exists($provider->service(), $activeProviders)) 
		{
			throw new ProviderNotFoundException("{$provider->service()} dose not found");
		}
	}

	// 统一用户信息
	protected function getUser($provider)
	{
		$method = "getUserFrom{$provider->service()}";
		if ( method_exists($this, $method) ) 
		{
			$result = $this->getResult($provider);
			$userInfo = $this->$method($result);
		} else 
		{
			$userInfo = false;
		}
		return $userInfo;
	}

	// 访问接口获取用户信息
	protected function getResult($provider)
	{
		switch ( $provider->service() ) 
		{
			case 'Sina':
				$result = json_decode($provider->request('users/show.json?uid=1694116743'), true);
				break;
			default:
				$result = array();
				break;
		}
		return $result;
	}

	protected function getUserFromSina($result)
	{
		$user = array();
		$user['uid']      = isset($result['id']) ? $result['id'] : $result['idstr'];
		$user['username'] = isset($result['name']) ? $result['name'] : '';
		$user['avatar']   = $result['avatar_hd'];
		$user['location'] = $result['location'];
		$user['desc']     = isset($result['description']) ? $result['description'] : '';
		$user['sex']      = isset($result['gender']) ? $result['gender'] : '';
		return $user;
	}

	protected function payLoad($uid, $username, $avatar, $location, $desc, $sex)
	{
		return ['uid' => $uid, 'username' => $username, 'avatar' => $avatar, 'location' => $location, 'desc' => $desc, 'sex' => $sex];
	}
}