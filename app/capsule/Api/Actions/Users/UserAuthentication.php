<?php namespace Capsule\Api\Actions\Users;
use DB,Response,Sentry,Cache;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\UserBasicSerializer;

class UserAuthentication extends Base {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	public function run()
	{
        $user = Sentry::getUser();
	$userid = $user->getId();
        $check =  DB::table("user_authentication")->where('userid',$userid)->get();        
        $data = array(
            'name'=>$this->input('name'),
            'mobile'=>$this->input('mobile'),
            'address'=>$this->input('address'),
             'occupation'=>$this->input('occupation'),
             'style'=>$this->input('style'),
             'genre'=>$this->input('genre'),
             'genreid'=>$this->input('genreid'),
             'userid'=>$userid,
             'type'=>$this->input('type'),
             'member'=>$this->input('member')
                );

         if(empty($check)){
            $resid = DB::table('user_authentication')->insertGetId($data);
            if(!empty($resid)){
                  //Cache::forever('user_auth','1');
               return Response::json(['success']);

            }
	    }else{
            $resid = DB::table('user_authentication')->where('userid', $userid)->update($data);
            if(!empty($resid)){
              //Cache::forever('user_auth','1');//缓存用户认证申请状态
                return Response::json(['success']);
            }
         }
       }
         
       
}
