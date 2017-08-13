<?php namespace Capsule\Api\Serializers;
use DB,Sentry;
use Capsule\Core\Orders\Order;
use Capsule\Core\Works\Work;

class PaySerializer extends BaseSerializer {
	
	protected $type = "pays";

	protected function attributes($order)
	{
		//$user=DB::table('users')->find($comment->user_id);
		$item =[];

		$work = Work::find($order->work_id);
		$datetime=date("Y-m-d",strtotime($order->created_at));
		$attributes = [
			'cash'      => $order->price*$order->amount,
			'user_id'   => $work->author->id,
			'username'  => $work->author->username,
			'avatar'    => $work->author->avatar,
			'title'     => $order->title,
			'datetime'  => $datetime,
		];


		return $attributes;
	}
}
