<?php namespace Capsule\Api\Actions\Orders;
use Cache, DB, Str, Sentry, Response, Queue;
use Capsule\Api\Actions\Base;
use Capsule\Core\Orders\Order;
use Capsule\Core\Works\Work;
use Capsule\Core\Users\User;
use Capsule\Core\Messages\Message;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Goods extends Base {
	
	public function __construct(User $user,Work $work)
	{
		$this->user = $user;
		$this->work = $work;
	}
	
	public function run()
	{
		if ( empty($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException();
		}

                Cache::forever('order_test',$this->input('manyprice'));
                $manyprice =$this->manyprice($this->input('manyprice'));
		$manyprice = $manyprice?$manyprice:'';

                
		$order = new Order();
		$order->orderNO = $this->input('orderNO','');
		$order->price = $this->input('price');
		$order->amount = $this->input('amount',1);
		$order->total = $order->price*$order->amount;
		$order->rebate = $this->input('rebate',0);
		$order->outlay = $this->input('outlay');
		$order->orderType = $this->input('orderType',1);
		$order->orderFunc = $this->input('orderFunc',1);
		$order->orderStatus = $this->input('orderStatus',0);
		$order->user_id = $user->id;
		$order->work_id = $this->input('work_id',NULL);
		$order->title = $this->input('title',"");
		$order->goods = $this->input('goods',"");
		$order->contact = $this->input('cont',"");
		$order->detail = $this->input('detail',"").$manyprice;
		if($order->orderFunc==0 && $user->account>=$order->total){
			$user->account=$user->account-$order->total;
			$user->save();
			$order->orderStatus = 1;
		}elseif($order->orderFunc==0 && $user->account<$order->total){
			return Response::json(['success' => 'error','reason' => '余额不足']);
			exit;
		}/*elseif($order->orderFunc==3 && $user->score<$order->total){
			return Response::json(['success' => 'error','reason' => '积分不足']);
			exit;
		}elseif($order->orderFunc==3 && $user->score>=$order->total){
			$user->score=$user->score-$order->total;
			$user->save();
			$order->orderStatus = 1;
		}*/
		$order->save();
		if($order->orderStatus==1){
			$work=$this->work->findOrFail($order->work_id);
			if($work->is_compshow==0){
				$author=$this->user->findOrFail($work->user_id);
				$author->account=$author->account+($order->price*0.9);
				$author->save();
				if($author->devicetoken!="" && $author->id!=$user->id)
				{
					$message=new message();
					$message->userid=$author->id;
					$message->devicetoken=$author->devicetoken;
					$message->message=$user->username.' 为你的声音作品「'.$work->title.'」支付了 ¥'.number_format($order->total, 2, '.', '');
					$message->action='work:'.$work->id.':pay:people:'.$user->id;
					$message->save();
					Queue::push('Capsule\Core\Push@run', array('id' => $message->id));
				}
			}else{
				$sms = app('sms');
				$rd=rand(1000,9999);
			//	$template = '【Sound Lab】购买已成功，请保留该短信，凭短信入场。('.$rd.')';
			        $template  = '【Sound Lab】恭喜你已购买成功！你的订单号是('.$order->orderNO.')请妥善保存该短信（若为现场演出，凭短信入场）。感谢你对SoundLab的支持！';
                        	$pn=intval($this->input("phoneNum",0));
				if($pn==0){
					$result = json_decode($sms->send($user->mobile, $template), true);//return $result;exit;
				}else{
					$result = json_decode($sms->send($pn, $template), true);//return $result;exit;
				}
				//$result = json_decode($sms->send($user->mobile, $template), true);//return $result;exit;
			}
		}
		return Response::json(['success' => 'success','orderid' => $order->id,'compaign'=>intval($work->is_compshow),'mobile'=>$this->input("phoneNum")]);
		exit;
	}
        function manyprice($data){
			if(!empty($data)){
			$manyprice_str = '';
			foreach ($data as $key => $value) {
		       //		$manyprice_str .=$value['name'].',价格'.$value['price'].',数量'.$value['num'].'--||--';
		
                                    if(!empty($value['name'])){  
					$manyprice_str .=$value['name'].',价格'.$value['price'].',数量'.$value['num'].'||';
    					}else{
   					 $manyprice_str .='价格'.$value['price'].',数量'.$value['num'].'||';
    	
   					 }
                 	}
			return  $manyprice_str;
			}else{
				return  '';
			}
               
    }

}