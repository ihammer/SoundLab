<?php
/**
 * Created by PhpStorm.
 * User: 武德安
 * Date: 2017/6/30
 * Time: 10:32
 */
namespace Capsule\Api\Actions;
class JSSDK {
    private $appId;
    private $appSecret;

    public function __construct($appId="", $appSecret="") {
        $this->appId = 'wx942974d1fc3eba25';
        $this->appSecret = '04fee1b258d7dafac5c4c41d91ff2e42';
    }

    public function getSignPackage($url_) {
        $jsapiTicket = $this->getJsApiTicket();
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url_";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url_,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
    //获取指定长度的随机值
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    //
    private function getJsApiTicket() {
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $rurl = file_get_contents($url);
            $rurl = json_decode($rurl,true);
            return $rurl['ticket'];
    }

    //获取Token
    private function getAccessToken() {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appId.'&secret='.$this->appSecret;
        $rurl = file_get_contents($url);
        $rurl = json_decode($rurl,true);
        if(array_key_exists('errcode',$rurl)){
            return false;
        }else{
            $access_token = $rurl['access_token'];
            return $access_token;
        }
    }
}