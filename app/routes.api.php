<?php
$action = function($class) {
    return function () use ($class) {
        $action = $this->app->make($class);
        $request = $this->app['request']->instance();
        $parameters = $this->app['router']->current()->parameters();
        return $action->handle($request, $parameters);
    };
};
// test
use Capsule\Core\Task;
Route::filter('attemptLogin', function($route, $request) {
    $prefix = 'Token ';
    if (starts_with($request->headers->get('authorization'), $prefix)) 
    {
        $token = substr($request->headers->get('authorization'), strlen($prefix));
        list($id, $code) = explode(':', $token, 2);
        $user = Sentry::getEmptyUser()->where('id', '=', $id)->where('persist_code', $code)->first();
        if ( $user ) 
        {
            Sentry::setUser($user);
        }
    }
});


Route::group(['prefix' => 'api', 'before' => 'attemptLogin'], function () use ($action) {
	 /*  打赏支付开关/var/www/capsule2/app/capsule/Api/Actions/Tags/status.php
    |--------------------------------------------------------------------------
    | Login 认证接口
    |--------------------------------------------------------------------------
    */
    Route::post('register', ['uses' => $action('Capsule\Api\Actions\Auth\Register')]);
    Route::post('reset', ['uses' => $action('Capsule\Api\Actions\Auth\Reset')]);
    Route::post('login', ['uses' => $action('Capsule\Api\Actions\Auth\Login')]);
    Route::post('logout', ['uses' => $action('Capsule\Api\Actions\Auth\Logout')]);
    Route::post('logoutold', ['uses' => $action('Capsule\Api\Actions\Auth\LogoutOld')]);
    Route::post('regdevice', ['uses' => $action('Capsule\Api\Actions\Auth\Device')]);
    Route::get('version', ['uses' => $action('Capsule\Api\Actions\Auth\Version')]);
    //Route::get('huanxin', ['uses' => $action('Capsule\Api\Actions\Huanxin')]);
    // Route::get('bind', ['uses' => $action('Capsule\Api\Actions\Auth\Bind')]);
     /*
    |--------------------------------------------------------------------------
    | Upload actions
    |--------------------------------------------------------------------------
    */
	 /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    Route::get('user/{uid}/show', ['uses' => $action('Capsule\Api\Actions\Users\Show')]);
    Route::get('user/{uid}/{aid}/getAlbum', ['uses' => $action('Capsule\Api\Actions\Albums\Getalbum')]);
    Route::post('user/{uid}/edit/', ['uses' => $action('Capsule\Api\Actions\Users\Edit')]);
    Route::post('user/createAlbum', ['uses' => $action('Capsule\Api\Actions\Albums\Create')]);
    Route::post('user/editAlbum', ['uses' => $action('Capsule\Api\Actions\Albums\Edit')]);
    Route::post('user/addWorkToAlbum', ['uses' => $action('Capsule\Api\Actions\Users\Addworktoalbum')]);
    Route::post('user/deleteWork', ['uses' => $action('Capsule\Api\Actions\Users\DeleteWork')]);
    Route::get('user/{uid}/edit/', ['uses' => $action('Capsule\Api\Actions\Users\Edit')]);
    Route::post('user/change/', ['uses' => $action('Capsule\Api\Actions\Users\Change')]);
    Route::get('user/{uid}/pwd/', ['uses' => $action('Capsule\Api\Actions\Users\Pwd')]);
    Route::post('user/{uid}/follow', ['uses' => $action('Capsule\Api\Actions\Users\Follow')]);
	
	// 开始
    Route::post('user/persons', ['uses' => $action('Capsule\Api\Actions\Users\FollowA')]);
    Route::post('user/personsa', ['uses' => $action('Capsule\Api\Actions\Users\FollowAndroid')]);//ceshi
    Route::post('user/{uid}/unfollow', ['uses' => $action('Capsule\Api\Actions\Users\Wollof')]);
    Route::get('user/{uid}/following', ['uses' => $action('Capsule\Api\Actions\Users\Following')]);
    Route::get('user/{uid}/follower', ['uses' => $action('Capsule\Api\Actions\Users\Follower')]);
    Route::get('user/{uid}/feeds', ['uses' => $action('Capsule\Api\Actions\Users\Feeds')]);
    Route::get('user/{uid}/feeds_old', ['uses' => $action('Capsule\Api\Actions\Users\FeedsOld')]);
    Route::get('user/browses', ['uses' => $action('Capsule\Api\Actions\Users\Browses')]);
    Route::get('user/works', ['uses' => $action('Capsule\Api\Actions\Users\Works')]); //feed
    Route::get('user/search',  ['uses' => $action('Capsule\Api\Actions\Users\Search')]);
    Route::get('user/recommand', ['uses' => $action('Capsule\Api\Actions\Users\Recommand')]);
    Route::get('user/discover', ['uses' => $action('Capsule\Api\Actions\Users\Discover')]);
    Route::get('user/rank', ['uses' => $action('Capsule\Api\Actions\Users\Ranking')]);
    Route::get('user/recruit', ['uses' => $action('Capsule\Api\Actions\Users\Recruit')]);
    Route::get('user/{uid}/pd', ['uses' => $action('Capsule\Api\Actions\Users\Pd')]);
    Route::get('user/{uid}/talk', ['uses' => $action('Capsule\Api\Actions\Users\Talk')]);
    Route::get('user/getorder',['uses'=>$action('Capsule\Api\Actions\Users\Getorder')]);
    Route::get('user/getpay',['uses'=>$action('Capsule\Api\Actions\Users\GetPay')]);
    Route::get('user/getpay_2',['uses'=>$action('Capsule\Api\Actions\Users\GetPay_New')]);
    Route::get('user/type',['uses'=>$action('Capsule\Api\Actions\Users\Type')]);
    Route::post('user/userauthentication',['uses'=>$action('Capsule\Api\Actions\Users\UserAuthentication')]);//labx认证
    Route::get('user/{uid}/get_authentication_info',['uses'=>$action('Capsule\Api\Actions\Users\UserAuthenticationInfo')]);


     /*
    |--------------------------------------------------------------------------
    | Albums
    |--------------------------------------------------------------------------
    */
    Route::get('album/{aid}/a', ['uses' => $action('Capsule\Api\Actions\Albums\Test')]);
    
    Route::get('album/check', ['uses' => $action('Capsule\Api\Actions\Albums\Check')]);

    /*
    |--------------------------------------------------------------------------
    | RecordUsers
    |--------------------------------------------------------------------------
    */
    Route::get('ruser/{uid}/test',['uses'=>$action('Record\Api\Actions\Users\Test')]);
    Route::get('reg', ['uses' => $action('Record\Api\Actions\Auth\Register')]);
     /*
    |--------------------------------------------------------------------------
    | Cashes
    |--------------------------------------------------------------------------
    */
    Route::get('cash/check', ['uses' => $action('Capsule\Api\Actions\Cashes\Check')]);
    Route::post('cash/refer', ['uses' => $action('Capsule\Api\Actions\Cashes\Refer')]);
     /*
    |--------------------------------------------------------------------------
    | Works
    |--------------------------------------------------------------------------
    */
    Route::get('works', ['uses' => $action('Capsule\Api\Actions\Works\Index')]);
    Route::get('work/dm', ['uses' => $action('Capsule\Api\Actions\Works\Daylymonthly')]);
    Route::get('work/test', ['uses' => $action('Capsule\Api\Actions\Works\Test')]);
    Route::post('work/create', ['uses' => $action('Capsule\Api\Actions\Works\Create')]);
    Route::post('work/createold', ['uses' => $action('Capsule\Api\Actions\Works\CreateOld')]);
    Route::post('work/createtest', ['uses' => $action('Capsule\Api\Actions\Works\Createtest')]);
    Route::post('work/{id}/love', ['uses' => $action('Capsule\Api\Actions\Works\Love')]);
    Route::post('work/{id}/nlove', ['uses' => $action('Capsule\Api\Actions\Works\Lovenew')]);
    Route::post('work/{id}/unlove', ['uses' => $action('Capsule\Api\Actions\Works\Unlove')]);
    Route::post('work/{id}/nunlove', ['uses' => $action('Capsule\Api\Actions\Works\Unlovenew')]);
    Route::get('work/{id}/edit', ['uses' => $action('Capsule\Api\Actions\Works\Edit')]);
    Route::get('work/{id}/show', ['uses' => $action('Capsule\Api\Actions\Works\Show')]);
    Route::get('work/{id}/show_ce', ['uses' => $action('Capsule\Api\Actions\Works\Show_ce')]);
    Route::get('work/{id}/show1', ['uses' => $action('Capsule\Api\Actions\Works\Show1')]);
    Route::get('work/{id}/status', ['uses' => $action('Capsule\Api\Actions\Works\Status')]);
    Route::get('work/{id}/shownew', ['uses' => $action('Capsule\Api\Actions\Works\ShowNew')]);
    Route::post('work/{id}/delete', ['uses' => $action('Capsule\Api\Actions\Works\Delete')]);
	Route::post('work/{id}/private', ['uses' => $action('Capsule\Api\Actions\Works\Privates')]);
    Route::get('work/{id}/tmpfile', ['uses' => $action('Capsule\Api\Actions\Works\Tmpfile')]);
    Route::get('work/search',  ['uses' => $action('Capsule\Api\Actions\Works\Search')]);//type=2乐迷话题 type=2 乐迷活动
    Route::get('work/discover', ['uses' => $action('Capsule\Api\Actions\Works\Discover')]);
    Route::get('work/newest', ['uses' => $action('Capsule\Api\Actions\Works\Newest')]);
    Route::get('user/test', ['uses' => $action('Capsule\Api\Actions\Users\Test')]);
    Route::get('work/newhomepage', ['uses' => $action('Capsule\Api\Actions\Works\Newhomepage')]);//根据标签拉取数据接口
    Route::get('work/newhomepage1', ['uses' => $action('Capsule\Api\Actions\Works\Newhomepage1')]);
    Route::get('work/hpbanner', ['uses' => $action('Capsule\Api\Actions\Works\Hpbanner')]);
    Route::get('work/manyprice', ['uses' => $action('Capsule\Api\Actions\Works\Manyprice')]);//多价格支付

    //申请labx 
    Route::post('work/applylabx', ['uses' => $action('Capsule\Api\Actions\Works\Applylabx')]);
    //labx个人页面
    Route::get('work/labx', ['uses' => $action('Capsule\Api\Actions\Works\Labx')]); 
    Route::get('work/labxtype', ['uses' => $action('Capsule\Api\Actions\Works\Labxtype')]);

     /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */
    Route::post('order/create', ['uses' => $action('Capsule\Api\Actions\Orders\Create')]);
    Route::post('goods/create', ['uses' => $action('Capsule\Api\Actions\Orders\Goods')]);
     /*
    |--------------------------------------------------------------------------
    | Advertisements
    |--------------------------------------------------------------------------
    */
    Route::get('adv/show',  ['uses' => $action('Capsule\Api\Actions\Advertisements\Index')]); /*
    |--------------------------------------------------------------------------
    | Comments
    |--------------------------------------------------------------------------
    */
    Route::get('comment/{id}/show',  ['uses' => $action('Capsule\Api\Actions\Comments\Show')]);
    Route::get('comment/{id}/commentlist',  ['uses' => $action('Capsule\Api\Actions\Comments\Commentlist')]);
    Route::post('comment/{id}/add',  ['uses' => $action('Capsule\Api\Actions\Comments\Add')]);
    Route::get('comment/{id}/del',  ['uses' => $action('Capsule\Api\Actions\Comments\Del')]);
     /*
    |--------------------------------------------------------------------------
    | Tags
    |--------------------------------------------------------------------------
    */
    Route::get('tag/search', ['uses' => $action('Capsule\Api\Actions\Tags\Search')]);
    Route::get('tag/recommand', ['uses' => $action('Capsule\Api\Actions\Tags\Recommand')]);
    Route::get('tag/discover', ['uses' => $action('Capsule\Api\Actions\Tags\Discover')]); //  音乐活动 (type=1) 乐迷话题(type=2)
    Route::get('tag/ndiscover', ['uses' => $action('Capsule\Api\Actions\Tags\Discovernew')]);
    Route::get('tag/topic', ['uses' => $action('Capsule\Api\Actions\Tags\Topic')]);
    Route::get('tag/isset', ['uses' => $action('Capsule\Api\Actions\Tags\Issets')]);
    Route::get('tag/hptaglist', ['uses' => $action('Capsule\Api\Actions\Tags\Hptaglist')]);
    Route::get('tag/hptaglist1', ['uses' => $action('Capsule\Api\Actions\Tags\Hptaglist1')]); //首页标签推荐
    Route::get('tag/tagstatus', ['uses' => $action('Capsule\Api\Actions\Tags\Status')]);
     //Route::get('tag/reg', ['uses' => $action('Capsule\Api\Actions\Tags\Reg')]);
     /*
    |--------------------------------------------------------------------------
    | Utags
    |--------------------------------------------------------------------------
    */
    //Route::get('tag/search', ['uses' => $action('Capsule\Api\Actions\Tags\Search')]);
    //Route::get('tag/recommand', ['uses' => $action('Capsule\Api\Actions\Tags\Recommand')]);
    //Route::get('tag/discover', ['uses' => $action('Capsule\Api\Actions\Tags\Discover')]);
    //Route::get('tag/ndiscover', ['uses' => $action('Capsule\Api\Actions\Tags\Discovernew')]);
    //Route::get('tag/topic', ['uses' => $action('Capsule\Api\Actions\Tags\Topic')]);
    Route::get('tag/reg', ['uses' => $action('Capsule\Api\Actions\Utags\Reg')]);
    Route::get('user/{uid}/tag', ['uses' => $action('Capsule\Api\Actions\Utags\Get')]);
    Route::post('tag/add', ['uses' => $action('Capsule\Api\Actions\Utags\Submit')]);
    Route::post('tag/addadd', ['uses' => $action('Capsule\Api\Actions\Utags\Submittest')]);
    Route::get('tag/addadd', ['uses' => $action('Capsule\Api\Actions\Utags\Submittest')]);
    Route::get('tag/utype', ['uses' => $action('Capsule\Api\Actions\Utags\Utype')]);    
    Route::get('tag/occupation', ['uses' => $action('Capsule\Api\Actions\Utags\Occupation')]);

     /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */
    Route::get('message/get', ['uses' => $action('Capsule\Api\Actions\Messages\Get')]);
    Route::get('message/getget', ['uses' => $action('Capsule\Api\Actions\Messages\Get123')]);
    Route::post('message/get', ['uses' => $action('Capsule\Api\Actions\Messages\Get')]);
    Route::get('message/selfpush', ['uses' => $action('Capsule\Api\Actions\Messages\Selfpush')]);
    Route::post('message/thank', ['uses' => $action('Capsule\Api\Actions\Messages\Thank')]);
     /*
    |--------------------------------------------------------------------------
    | Mashanglu
    |--------------------------------------------------------------------------
    */
    Route::get('audio/{tid}/show', ['uses' => $action('Capsule\Api\Actions\Audios\Index')]);
     /*
    |--------------------------------------------------------------------------
    | Global 全局接口
    |--------------------------------------------------------------------------
    */
    Route::get('makeuser', ['uses' => $action('Capsule\Api\Actions\Common\Makeuser')]);
    Route::get('paystatus', ['uses' => $action('Capsule\Api\Actions\Common\Paystatus')]);
    Route::get('publish', ['uses' => $action('Capsule\Api\Actions\Common\Publish')]);
    Route::any('sendsms', ['uses' => $action('Capsule\Api\Actions\Common\Sendsms')]);
    Route::get('sendsmstest', ['uses' => $action('Capsule\Api\Actions\Common\Sendsms1')]);
    Route::get('uptoken', ['uses' => $action('Capsule\Api\Actions\Common\Uptoken')]);
    Route::post('upload', ['uses' => $action('Capsule\Api\Actions\Callbacks\Upload')]);
    Route::get('pushmessage', ['uses' => $action('Capsule\Core\Push')]);
	Route::get('islogin', ['uses' => $action('Capsule\Api\Actions\Common\Islogin')]);
	Route::get('isloginscore', ['uses' => $action('Capsule\Api\Actions\Common\Isloginscore')]);
	Route::get('getscore', ['uses' => $action('Capsule\Api\Actions\Common\Getscore')]);
	Route::get('isexist', ['uses' => $action('Capsule\Api\Actions\Common\Isexist')]);
	Route::get('rsendsms', ['uses' => $action('Record\Api\Actions\Common\Sendsms')]);
    Route::get('test321', function(){
			$error=DB::table("works")->whereRaw("waveform='' and deleted_at is null")->select("id")->get();
			//return $error;
			foreach($error as $key => $item){
				Queue::push('Capsule\Core\Task@handleFetchPeaks', array('id' => $item->id));
				echo $item->id."<br>";
			}
			//Queue::push('Capsule\Core\Task@handleFetchPeaks', array('id' => 221));
    });
    Route::get('test321123', function(){
    	//Queue::push('Capsule\Core\Push@run', array('id' => 2933));
    	echo number_format(0, 2, '.', '');
    });
    Route::get('test123', function(){
            return "hello world";
    });

    Route::get('version/ioserror', function(){
            return "";
    });

    Route::get('user/qrcode_url', function(){
        
        
             $array['data']['qrcode_url'] = "http://pillele.cn/WxpayAPI_php_v3/example/qrcode.php?data=http://pillele.cn/slmy/my.php?id=".$_GET['id'];
           
             return Response::json($array, 200);
           
    });
    Route::post('test111', ['uses' => $action('Capsule\Api\Actions\Test')]);
    Route::post('test222', ['uses' => $action('Capsule\Api\Actions\Testtest')]);
    Route::get('test111', ['uses' => $action('Capsule\Api\Actions\Test')]);
    Route::get('test222', ['uses' => $action('Capsule\Api\Actions\Testtest')]);


    //wxpay lqx
    
    Route::get('wxpay/create', ['uses' => $action('Capsule\Api\Actions\Wxpay\Create')]);
    Route::get('wxpay/createreward', ['uses' => $action('Capsule\Api\Actions\Wxpay\Createreward')]);
    Route::post('wxpay/update', ['uses' => $action('Capsule\Api\Actions\Wxpay\Update')]);
    Route::post('wxpay/checklogin', ['uses' => $action('Capsule\Api\Actions\Wxpay\checklogin')]);
    Route::get('wxpay/token', ['uses' => $action('Capsule\Api\Actions\Wxpay\Token')]);
    Route::get('wxpay/test', ['uses' => $action('Capsule\Api\Actions\Wxpay\Test')]);
    Route::get('wxpay/code', ['uses' => $action('Capsule\Api\Actions\Wxpay\Code')]);
    Route::get('wxpay/h5', ['uses' => $action('Capsule\Api\Actions\Wxpay\H5pay')]);
    Route::get('wx/jssdk', ['uses' => $action('Capsule\Api\Actions\Wxpay\Jssdk_c')]);

    Route::any('enroll/create', ['uses' => $action('Capsule\Api\Actions\Enroll\Create')]);//@wda H5活动报名接口

    Route::get('xcx/scene', ['uses' => $action('Capsule\Api\Actions\Xcx\Scene')] );//小程序_风格列表——new
    Route::get('xcx/category', ['uses' => $action('Capsule\Api\Actions\Xcx\Index')] );//小程序_风格列表
    Route::get('xcx/region', ['uses' => $action('Capsule\Api\Actions\Xcx\Region')] );//小程序_地域列表@wda
    Route::get('xcx/worknew/{id}', ['uses' => $action('Capsule\Api\Actions\Xcx\WorksNew')] );//作品推荐接口_new
    Route::get('xcx/work/{id}', ['uses' => $action('Capsule\Api\Actions\Xcx\Works')] );//作品推荐接口_new
    Route::get('xcx/region_name/{channel}/{name}', ['uses' => $action('Capsule\Api\Actions\Xcx\Special')] );//小程序_渠道（场景/地点）@wda
    Route::get('xcx/missionlist', ['uses' => $action('Capsule\Api\Actions\Xcx\MissionList')] );//小程序_特定用户列表MissionList
    Route::get('xcx/user/{id}', ['uses' => $action('Capsule\Api\Actions\Xcx\Users')]);//小程序_风格用户随机作品
    Route::get('xcx/usernew/{id}', ['uses' => $action('Capsule\Api\Actions\Xcx\UsersNew')]);//小程序_风格用户随机作品_new

    

});
Route::group(['prefix' => 'rec'], function () use ($action) {
	/*
    |--------------------------------------------------------------------------
    | RecordUsers
    |--------------------------------------------------------------------------
    */
    Route::get('user/{uid}/show',['uses'=>$action('Record\Api\Actions\Users\Show')]);
    Route::get('login', ['uses' => $action('Record\Api\Actions\Auth\Login')]);
    Route::get('reg', ['uses' => $action('Record\Api\Actions\Auth\Register')]);
});

Route::get('pushone', "Capsule\Core\Push1" );


