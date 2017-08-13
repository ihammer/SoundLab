<?php
namespace Capsule\Api\Actions\Wxpay;

use Capsule\Api\Actions\Base;
use Capsule\Core\Orders\Order;
use Capsule\Api\Actions\Pay;
use Cache;
use DB;

class Createreward extends Base{
    
    public function run(){
        
        $wxpayModel=new Pay();
        $orderNo=time().$wxpayModel->getRandom(22);
        if(empty($_GET['orderNO'])){//放入缓存
            $cacheData['price'] =(int)$this->input('price');
            $cacheData['workid']=$this->input('workid');
            $cacheData['userid']=$this->input('userid');
            $cacheData['title'] =$this->input('title'); 
            $cacheData['tel']   =$this->input('tel');
            $cacheData['amount']=$this->input('amount',1);
            $cacheData['address']=$this->input('address');
            $cacheData['name']=$this->input('name');
            $cacheData['rebate']=$this->input('rebate',0);
            $cacheData['outlay']=$this->input('outlay',0);
            
            Cache::put($orderNo, json_encode($cacheData), 10);
        }
       
        $code=$this->input("code","");
        if(empty($code)){
            $redirect_uri="http://".$_SERVER['HTTP_HOST']."/api/wxpay/createreward?orderNO=".$orderNo;
            $url=$wxpayModel->getCode($redirect_uri);//die;
            header("Location:".$url);die;
        }else{
            $res=$wxpayModel->getuserinfo($code);//用户信息
        }

        //从缓存中拿数据
        $getCacheData = json_decode(Cache::get($_GET['orderNO'])); 

        $wx_users = DB::table("users")->where(array("uuid"=>$res->openid))->get();
        if(empty($wx_users)){
            $wx_user_id=DB::table('users')->insertGetId(
                array(
                    'uuid'        => $res->openid,
                    'username'    => $res->nickname,
                    'sex'         => $res->sex,
                    'utype_id'    => 0,
                    'devicetoken' => $wxpayModel->getRandom(22),
                    'avatar'      => $res->headimgurl,
                    'score'       => 0,
                    'visit'       => 0,
                    'account'     => 0,
                    'introduce'   => 0,
                    'location'    => $res->country.$res->province.$res->city,
                    'mobile'      => 0,
                    'password'    => $wxpayModel->getRandom(22),
                    'permissions' => 0,
                    'activated'   => 0,
                    'activation_code'    => 0,
                    'fans_count'         => 0,
                    'follow_count'       => 0,
                    'works_count'        => 0,
                    'recommend'          => 0,
                    'recommendtime'      => date("Y-m-d H:i:s",time()),
                    'created_at'         => date("Y-m-d H:i:s",time()),
                    'updated_at'         => date("Y-m-d H:i:s",time()),
                    'isRelogin'          =>0
                )
            );
        }else{
            $wx_user_id=$wx_users[0]->id;
        }
        
        $goodsarr[$getCacheData->price]=$getCacheData->amount;
        $contact['name']    =$res->nickname;
        $contact['tel']     ="";
        $contact['address'] =trim($res->country.$res->province.$res->city);
        
        $order = new Order();
		$order->orderNO       =$_GET['orderNO'];
		$order->price         =$getCacheData->price;
		$order->amount        =$getCacheData->amount;
		$order->total         =$getCacheData->price*$getCacheData->amount;
		$order->rebate        =$getCacheData->rebate;
		$order->outlay        =$getCacheData->outlay;
		$order->orderType     =3;//'支付类型:0为充值，1为购买，2为众筹 3微信h5打赏',
		$order->orderFunc     =2;//'支付方式：0为余额，1为支付宝，2为微信，3为积分',
		$order->orderStatus   =0;//'支付状态：0为失败，1为成功',
		$order->work_id       =$getCacheData->workid;
		$order->title         =$getCacheData->title;
		$order->detail        ="";
		$order->goods        =json_encode((object)$goodsarr);
		$order->contact      =json_encode($contact);
		$order->wx_user      =$wx_user_id;
		
		$order->save();
		
		$data['price']    =$order->price;
		$data['orderNO']  =$order->orderNO;
		$data['title']    =$order->title;
		$data['work_id']  =$order->work_id;
		$data['openid']   =$res->openid;
		
		$result=$wxpayModel->unifiedOrder($data);//下单
		$url="http://".$_SERVER['HTTP_HOST']."/wxpay/h5pay.php?prepay_id=".$result['prepay_id']."&type=2";//type =1为 购买  2 为 打赏
	    header("Location:".$url);die;
        
    }
    
}