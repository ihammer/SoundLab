<?php
namespace Capsule\Api\Actions\Wxpay;

use Capsule\Api\Actions\Base;
use Capsule\Api\Actions\Pay;

class H5pay extends Base{
    
    //处理订单
    public function run(){
        $wxpayModel=new Pay();
        $data['appId']=$wxpayModel->getOpenid();
        $data['timeStamp']=time();
        $data['nonceStr']=$wxpayModel->getRandom(32);
        $data['package']="prepay_id=".$_GET['prepay_id'];
        $data['signType']="MD5";
        $data['paySign']=$wxpayModel->MakeSign($data);
        return $data;        
    }
    
//     public function run(){
// //         $wxpayModel=new Pay();
//        echo date("YmdHis",time());
//        echo "<br/>";
//        echo date("YmdHis",time()+1800);
//     }
    
}