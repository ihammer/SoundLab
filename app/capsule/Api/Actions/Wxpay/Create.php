<?php
namespace Capsule\Api\Actions\Wxpay;

use Capsule\Api\Actions\Base;
use Capsule\Core\Orders\Order;
use Capsule\Api\Actions\Pay;
use Cache;

class Create extends Base{
    
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
            $cacheData['name']  =$this->input('name');
            $cacheData['rebate']=$this->input('rebate',0);
            $cacheData['outlay']=$this->input('outlay',0);
            $cacheData['remarks']=$this->input('remarks');
            $cacheData['total'] =$this->input('total');
            
            Cache::put($orderNo, json_encode($cacheData), 10);
        }
       
        $code=$this->input("code","");
        if(empty($code)){
            $redirect_uri="http://".$_SERVER['HTTP_HOST']."/api/wxpay/create?orderNO=".$orderNo;
            $url=$wxpayModel->getCode($redirect_uri);//die;
            header("Location:".$url);die;
        }else{
            $res=$wxpayModel->getuserinfo($code);//用户信息
//             print_r($res);die;
        }
        
        //从缓存中拿数据
        $getCacheData = json_decode(Cache::get($_GET['orderNO'])); 
        
        $goodsarr[$getCacheData->price]=$getCacheData->amount;
        $contact['name']    =$getCacheData->name;
        $contact['tel']     =$getCacheData->tel;
        $contact['address'] =$getCacheData->address;
        
        $order = new Order();
		$order->orderNO       =$_GET['orderNO'];
		$order->price         =$getCacheData->price;
		$order->amount        =$getCacheData->amount;//数量
		$order->total         =$getCacheData->total;
		$order->rebate        =$getCacheData->rebate;
		$order->outlay        =$getCacheData->outlay;
		$order->orderType     =1;//'支付类型:0为充值，1为购买，2为众筹 3微信h5打赏',
		$order->orderFunc     =2;//'支付方式：0为余额，1为支付宝，2为微信，3为积分',
		$order->orderStatus   =0;//'支付状态：0为失败，1为成功',
		$order->user_id       =$getCacheData->userid;
		$order->work_id       =$getCacheData->workid;
		$order->title         =$getCacheData->title;
		$order->detail        =empty($getCacheData->remarks)?"":$getCacheData->remarks;
		$order->goods        =json_encode((object)$goodsarr);
		$order->contact      =json_encode($contact);
		$order->save();
		
		$data['price']    =$order->total;
		$data['orderNO']  =$order->orderNO;
		$data['title']    =$order->title;
		$data['work_id']  =$order->work_id;
		$data['openid']   =$res->openid;
		
		$result=$wxpayModel->unifiedOrder($data);//下单
		$url="http://".$_SERVER['HTTP_HOST']."/wxpay/h5pay.php?prepay_id=".$result['prepay_id']."&type=1";//type =1为 购买  2 为 打赏
	    header("Location:".$url);die;
        
    }
    
}