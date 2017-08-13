<?php namespace Capsule\Api\Serializers;
use DB,Sentry;
use Capsule\Core\Orders\Order;

class OrderSerializer extends BaseSerializer {
	
	protected $type = "orders";

	protected function attributes($order)
	{
		//$user=DB::table('users')->find($comment->user_id);
		$datetime=date("Y-m-d",strtotime($order->created_at));
		$attributes = [
			'cash'     => $order->price*$order->amount,
			'user_id'  => $order->user_id,
			'username'  => $order->username,
			'avatar'  => "http://7xikb7.com1.z0.glb.clouddn.com/".$order->avatar."?imageView2/2/w/150",
			'title'  => $order->title,
			'datetime'  => $datetime,
		];
		return $attributes;
	}
}