<?php namespace Capsule\Api\Actions\Auth;

use Config, Response, Sentry, OAuth;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\Token;
use Capsule\Core\Users\Commands\RegisterUserCommand;
use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\Common\Http\Exception\TokenResponseException;
use Capsule\Core\Support\Exceptions\ProviderNotFoundException;
use Capsule\Core\Support\Exceptions\ArgumentNotEnoughException;

class Login extends Base {

	protected $token;
	protected $service;
	protected $accessToken;
	protected $uid;
	
	public function __construct(Token $token) 
	{
		$this->token = $token;
		OAuth::setHttpClient('CurlClient');
	}

	public function run()
	{
		$this->service     = ucfirst($this->input('service'));
		$this->accessToken = $this->input('access_token');
		$this->uid         = $this->input('uid');

		if ( !$this->service OR !$this->accessToken )
		{
			throw new ArgumentNotEnoughException();
		}
		$service     = ucfirst($this->input('service'));
		$accessToken = $this->input('access_token');
		$uid         = $this->input('uid');

		try
		{
			$this->checkProvider($service);
			$first = false;
			if ( is_null($token = $this->getToken()) ) 
			{
				$provider = OAuth::consumer( $service );
				$oauthToken = $this->createToken();
				$provider->getStorage()->storeAccessToken($this->service, $oauthToken);
				$userInfo = $this->getUserFromApi($provider);

				$token                = $this->token->newInstance();
				$token->provider      = $provider->service();
				$token->access_token  = $oauthToken->getAccessToken();
				$token->refresh_token = !empty($oauthToken->getRefreshToken()) ? $oauthToken->getRefreshToken() : "";
				$token->uid           = $this->uid;
				$token->expiry_in     = !empty($oauthToken->getEndOfLife()) ? $oauthToken->getEndOfLife() : 0;
				// new User
				$user = $this->execute(RegisterUserCommand::class, $userInfo);
				$user->tokens()->save($token);
				$first = true;
			} else 
			{
				$user = $token->user;
			}

			if ( empty($user) ) 
			{
				return $this->respondWithError('loginFailed');
			}

			if ( !$first ) 
			{
				// $token->access_token = $token->getAccessToken();
				// $token->refresh_token = !empty($token->getRefreshToken()) ? $token->getRefreshToken() : "";
				// $token->expiry_in = !empty($token->getEndOfLife()) ? $token->getEndOfLife() : 0;
				// $token->save();
			}

			Sentry::login($user, true);
			return Response::json(['uid' => $user->getId(), 'token' => $user->persist_code]);

		} catch(ProviderNotFoundException $e)
		{
			return $this->respondWithError("provoiderNotFound");
		} catch(TokenResponseException $e) 
		{
			return $this->respondWithError('fetchTokenFailed');
		} catch(\Exception $e)
		{
			return $this->respondWithError('loginFailed');
		}
	}
	
	protected function createToken()
	{
		$token = new StdOAuth2Token();
		$token->setAccessToken($this->accessToken);
		return $token;
	}

	protected function getToken()
	{
		if ( $this->service === 'Douban' ) 
		{
			return $this->token->where('provider', '=', $this->service)->where('uid', '=', $this->uid)->first();
		} else 
		{
			return $this->token->where('provider', '=', $this->service)->where('acccess_token', '=', $this->accessToken)->first();
		}
	}

	protected function getUserFromApi($provider)
	{
		$result = $this->parseResult($provider);
		if ( $result === false ) 
		{
			return $result;
		}
		$array = [];
		switch ( $provider->service() ) 
		{
			case 'Sina':
				$array['uid']      = isset($result['id']) ? $result['id'] : $result['idstr'];
				$array['username'] = isset($result['name']) ? $result['name'] : '';
				$array['avatar']   = $result['avatar_hd'];
				$array['location'] = $result['location'];
				$array['desc']     = isset($result['description']) ? $result['description'] : '';
				$array['sex']      = isset($result['gender']) ? $result['gender'] : '';
				break;
		}
		return $array;
	}

	protected function parseResult($provider)
	{
		switch ( $provider->service() ) 
		{
			case 'Sina':
				$result = json_decode($provider->request('users/show.json?uid='. $this->uid), true);
				break;
			
			default:
				$result = false;
				break;
		}
		return $result;
	}

	protected function checkProvider($service)
	{
		$activeProviders = Config::get('oauth-4-laravel::consumers');
		if ( is_null($activeProviders) OR !array_key_exists($service, $activeProviders)) 
		{
			throw new ProviderNotFoundException("Provider dose not found");
		}
	}
}