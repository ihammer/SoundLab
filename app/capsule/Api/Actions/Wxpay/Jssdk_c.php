<?php
namespace Capsule\Api\Actions\Wxpay;
use DB,Response;
use Capsule\Api\Actions\Base;
use Capsule\Api\Actions\JSSDK;

class Jssdk_c extends Base{
    public function run(){
        $url   = $this->input('url');
        $jssdk=new JSSDK();
        return($jssdk->getSignPackage($url));
    }
}