<?php namespace Capsule\Api\Actions\Users;

use Sentry, Input, Response;
use Capsule\Core\Users\User;
use Capsule\Core\Orders\Order;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Serializers\OrderSerializer;

class Getorder extends Base {

	protected $user;
	protected $order;

	public function __construct(User $user,Order $order)
	{
		$this->user = $user;
		$this->order = $order;
	}
	
	public function run()
	{
		$user = Sentry::getUser();
		if ( !$user ) 
		{
			throw new UserUnauthorizedException();
		}
		$page  = max(1, intval($this->input('p', 0)));
		$count = 10;
		$start = ($page - 1) * $count;
		$serializer = new OrderSerializer();
		$total=$this->order->join("works","orders.work_id","=","works.id")->join("users","orders.user_id","=","users.id")->where("works.user_id","=",$user->getId())->where("orders.orderStatus","=",1)->count();
		//$total=$this->order->join("works","orders.work_id","=","works.id")->join("users","orders.user_id","=","users.id")->where("works.user_id","=",45)->where("orders.orderStatus","=",1)->count();
		list($pages, $page) = $this->calculatePagination($total, $page, $count);
		$order=$this->order->join("works","orders.work_id","=","works.id")->join("users","orders.user_id","=","users.id")->where("works.user_id","=",$user->getId())->where("orders.orderStatus","=",1)->select("orders.*","users.username","users.avatar")->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		//$order=$this->order->join("works","orders.work_id","=","works.id")->join("users","orders.user_id","=","users.id")->where("works.user_id","=",45)->where("orders.orderStatus","=",1)->select("orders.*","users.username","users.avatar")->skip($start)->take($count)->orderBy('created_at', 'desc')->get();
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$this->document->addMeta('total', $total);
		$document = $this->document->setData($serializer->collection($order));
		return $this->respondWithDocument($document);exit;
	}
	
}