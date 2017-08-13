<?php namespace Capsule\Api\Serializers;
use DB;
use Capsule\Core\Users\User;

class UserSerializer extends UserBasicSerializer {

	protected function attributes($user)
	{
		$attributes = parent::attributes( $user );
		$user_authentication = DB::table('user_authentication')->where('userid','=',$user->id)->get();
        	if($user_authentication){
        	//pr($user_authentication);
        	$attributes += [
			'name'   => $user_authentication[0]->name,
			'address'  => $user_authentication[0]->address,
			'occupation'  => $user_authentication[0]->occupation,
			'style'  => $user_authentication[0]->style,
			'genre'  => $user_authentication[0]->genre,
			'member'  => $user_authentication[0]->member?$user_authentication[0]->member:'',
			'type'  => $user_authentication[0]->type,
		   ];
       	         }
                $attributes += [
			'fans_count'   => strval($user->fans_count),
			'follow_count' => strval($user->follow_count),
			'works_count'  => strval($user->works_count),
		];
		return $attributes;
	}
}
