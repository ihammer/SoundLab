<?php
namespace Capsule\Api\Actions\Wxpay;

use Capsule\Api\Actions\Base;
use Capsule\Api\Actions\Pay;
use log;
use DB,Sentry;
use Queue;
use Capsule\Core\Messages\Message;
use Cache;
  
class Update extends Base{
    
    public function run(){
        $xml = file_get_contents("php://input");
        $wxpayModel = new Pay();
        $result=$wxpayModel->FromXml($xml);
//         $result['out_trade_no']="1479698953VKD9WX7HAUVFFPUEHDO1O9";
//         $result['result_code']="SUCCESS";
        if ($result['result_code']=="SUCCESS"){//支付成功
            //修改订单状态
            DB::table('orders')->where('orderNO', $result['out_trade_no'])->update(array("orderStatus"=>1,"updated_at"=>date("Y-m-d H:i:s",time())));
            //查询订单类型  购买 or 打赏
            $res=DB::table('orders')->where('orderNO', $result['out_trade_no'])->get();
            
            if($res[0]->orderType==1){//购买
                //不作操作
            }else if($res[0]->orderType==3){//打赏
                $workData=DB::table('works')->where('id', $res[0]->work_id)->get();
                $userData=DB::table("users")->where("id",$workData[0]->user_id)->get();
                $WxUserData=DB::table("users")->where("id",$res[0]->wx_user)->get();
//                 echo "微信用户".$WxUserData[0]->username."打赏了你的作品「".$workData[0]->title."」";
                $message=new message();
                $message->userid=$userData[0]->id;
                $message->devicetoken=$userData[0]->devicetoken;
                $message->message="微信用户".$data->nickname."打赏了你的作品「".$workData[0]->title."」";
                //                 $message->action='work:'.$id.':love:people:'.$user->id;
                $message->save();
                Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
            }
            
        }else{//支付失败
            
        }
      //  DB::table('orders')->where('orderNO', "14791181614NT1TS5G0A1CS4QWBGH198")->update(array("orderStatus"=>1,"updated_at"=>date("Y-m-d H:i:s",time())));
        echo "SUCCESS";
    }
}