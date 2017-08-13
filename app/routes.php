<?php
//Route::group(['prefix' => ''], function() {
	Route::any('/','IndexController@index');
	Route::any('download','IndexController@download');
	Route::any('helps','IndexController@helps');
	Route::any('helppost','IndexController@helppost');

	Route::any('home','ZpchomeController@index');
	Route::any('homeupload','ZpcuploadController@index');
	Route::any('changework','ZpchomeController@changework');
	Route::get('/homeid','ZpchomeController@index');
	Route::any('plogin','ZpcloginController@index');
	Route::any('pregist','ZpcloginController@regist');
	Route::any('findmm','ZpcloginController@findmm');
	Route::any('sublogin','ZpcloginController@sublogin');
	Route::any('ploginout','ZpcloginController@ploginout');
	Route::any('waveform','ZpcuploadController@waveform');

//	Route::any('/', function() { return "Hello World!"; }); 
//};
Route::group(['prefix' => '123xxxadmin'], function() {
	Route::get('login','AdminController@login');
	Route::get('admin','AdminController@index');
	Route::get('dologin','AdminController@dologin');
	Route::get('logout','AdminController@logout');
	Route::get('password','AdminController@password');
	Route::get('deluser','UserController@deluser');
	Route::get('delaudio','AudioController@delaudio');
	Route::get('saveuser','UserController@save');
	Route::post('upsave','UserController@upsave');
	Route::post('recommenduser','UserController@recommenduser');
	Route::post('upmedia','OpusController@upmedia');
	Route::get('getWorkTag','OpusController@getWorkTag');
	Route::post('uptag','OpusController@uptag');
	Route::get('delopus','OpusController@delopus');
	Route::post('recommandFb','TagController@recommandFb');
	Route::post('recommandReg','TagController@recommandReg');
	Route::post('recommandRel','TagController@recommandRel');
	Route::post('recommandRelr','TagController@recommandRelr');
	Route::post('recommandCnt','TagController@recommandCnt');
	Route::post('tagajaxUtagadd','TagController@ajaxUtagadd');
	Route::post('ajaxTag','TagController@ajaxTag');
	Route::post('ajaxUtag','UtagController@ajaxTag');
	Route::post('ajaxUtagadd','UtagController@ajaxUtagadd');
	Route::post('isrecommend','OpusController@isrecommend');
	Route::post('ismusician','OpusController@ismusician');
	Route::post('iscontshow','OpusController@iscontshow');
	Route::get('opus/{id}/imagelist', 'OpusController@imageList');
	Route::get('opus/{id}/edittest', 'OpusController@edittest');
	Route::get('opus/newlist', 'OpusController@newlist');
	Route::post('audio/store', 'AudioController@store');
	Route::post('audio/{id}/update', 'AudioController@update');
	Route::post('opus/uptonewest', 'OpusController@uptonewest');
	Route::get('opus/{id}/newverify', 'OpusController@newverify');
	Route::get('tag/{id}/tagop', 'TagController@tagop');
	Route::get('tag/utag', 'TagController@utag');
	Route::post('opus/uptonewest', 'OpusController@uptonewest');
	Route::post('iscompshow','OpusController@iscompshow');
	Route::post('iscompshowtype','OpusController@iscompshowtype');
	Route::get('getreason','OpusController@getreason');
	Route::post('opus/updatemedia','OpusController@updatemedia');
	Route::get('user/{id}/del','UserController@deluser');
	Route::get('user/{id}/scoreedit','UserController@scoreedit');
	Route::get('user/{id}/reset','UserController@resetpassword');
	Route::post('addpush','UserController@addpush');
	Route::post('checkmobile','UserController@checkmobile');
	Route::post('workpush','OpusController@workpush');
	Route::post('upload','UploadController@run');
	Route::post('upfile','UploadController@upfile');
	Route::post('jjuploads','UploadController@jjuploads');
	Route::post('testup','UploadController@test');
	Route::get('testff','UploadController@testff');
	Route::get('change','OpusController@changePerson');
	Route::get('testtotest','TestController@index');
	Route::resource('admin', 'AdminController');
	Route::resource('user', 'UserController');
	Route::resource('opus', 'OpusController');
	Route::resource('topic', 'TopicController');
	Route::resource('tag', 'TagController');
	Route::resource('tag/create', 'TagController@create');
	Route::resource('utag', 'UtagController');
	Route::resource('audio', 'AudioController');
	Route::resource('roleuser', 'RoleuserController');
	Route::resource('helps', 'HelpsController');
	Route::resource('scoreelse', 'ScoreelseController');
	Route::post('roleuser/upsave','RoleuserController@upsave');
	Route::post('helps/upsave','HelpsController@upsave');
	Route::get('roleuser/create','RoleuserController@create');
	Route::post('roleuser/saveuser','RoleuserController@save');
	Route::post('dopassword','AdminController@dopassword');
	Route::post('checkpassword','AdminController@checkpassword');
	Route::post('linksopus','OpusController@linksopus');
	Route::post('upsavescore','UserController@upsavescore');
	Route::post('upsavescoreelse','ScoreelseController@upsave');
	Route::post('ccomplate','ZpcuploadController@ccomplate');
	Route::resource('order','OrderController');
	
	
});


//wx
Route::group(['prefix' => 'wxpay'], function(){
    /*
     |--------------------------------------------------------------------------
     | RecordUsers
     |--------------------------------------------------------------------------
     */
    Route::get('create',"WxpayController@Create");
    Route::get('aaa',"WxpayController@aaa");
});
    

Route::get('users', function()
{
    return 'Users!';
});
App::missing(function($exception)
{
    return "Bazinga!!!";
});