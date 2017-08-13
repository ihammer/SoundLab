<?php namespace Capsule\Api\Serializers;
use DB;
use Capsule\Core\Users\User;

class UserBasicSerializer extends BaseSerializer {

	protected $type = 'users';
    
    protected function attributes($user)
    {
	    if($user->utype_id==0){
		    $utype="暂无分类";
		}else{
	    	$usertype=DB::table("utypes")->find($user->utype_id);
	    	$utype=$usertype->name;
	    }
        $attributes = [
            'username'  => $user->username,
            'utype'  => $utype,
            'avatar'    => $user->avatar,
            'location'  => $user->location,
            'sex'       => strval($user->sex),
            'introduce' => $user->introduce,
            'score' => $user->score,
            'visit' => $user->visit,
            'account' => $user->account,
            'persist_code'=>$user->persist_code,
            'album_list'	=>	$user->albums,
            'authentication'=> $user->authentication
        ];
        return $attributes;
    }
}
