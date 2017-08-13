<?php
namespace Capsule\Api\Actions\Wxpay;

use Capsule\Api\Actions\Base;
// use Capsule\Api\Actions\Pay;
use Cache;
use DB;

class Test extends Base{
    
    //获取微信用户信息
    public function run(){
//         $cacheData="14792086908EU7XMBBAMCD3FWKUS9W8W";
//         Cache::put("14792086908EU7XMBBAMCD3FWKUS9W8W", $cacheData, 1);
        
//         $wxpayModel=new Pay();
//         $code=$this->input("code","");
//         if(empty($code)){
//             $redirect_uri="http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
//             $url=$wxpayModel->getCode($redirect_uri);//die;
//             header("Location:".$url);die;
//         }else{
//             $res=$wxpayModel->getuserinfo($code);
//             print_r($res);
//         }

        $value = Cache::get($this->input('key'));
        print_r($value);die;

//         $res=DB::table('orders')->where('orderNO', "1479350983COEAS9NSREG9FDX27O8URA")->get();
//         print_r($res[0]->orderNO);
        
//         if($res[0]->orderType==1){//购买
//         echo 1;
//         }else if($res[0]->orderType==3){//打赏
//         echo 3;
//         }
        
    }
    
//     public function run(){
// //         $wxpayModel=new Pay();
//        echo date("YmdHis",time());
//        echo "<br/>";
//        echo date("YmdHis",time()+1800);
//     }
    
}