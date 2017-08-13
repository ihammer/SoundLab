<?php
namespace Capsule\Api\Actions\Wxpay;
use Capsule\Api\Actions\Base;
use Capsule\Api\Actions\Pay;

class Code extends Base{
    public function run(){
        $code=$_GET['code'];
        $wxpayModel=new Pay();
        $wxpayModel->getopenid($code);
    }
}