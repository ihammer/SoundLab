<?php namespace Capsule\Api\Actions\Users;

use Sentry, Input, Response;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Core\Orders\Order;
use Capsule\Api\Actions\Base;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Serializers\PaySerializer;
use Capsule\Api\Serializers\OrderSerializer;
use Capsule\Core\Support\Json\Document;
class GetPay extends Base {

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
                 $pay = $this->getpay($user->getId());
                 $order = $this->getorder($user->getId());
                
                $newpay = $pay['data'];
                $neworder = $order['data'];
                $newdata = array_merge($newpay,$neworder);
                //pr($newdata);
                $krsortdata = array();
                $data = array();
                foreach ($newdata as $key => $value) {
                       $krsortdata[$value['id']]  =  $newdata[$key];
                }
                krsort($krsortdata);
                $data['data'] = array_values($krsortdata);
               
               return $this->printJSON($data);


        }

         function getpay($userid){
                 
               
                $serializer = new PaySerializer();
                
                $order=$this->order->join("works","orders.work_id","=","works.id")->where("orders.user_id","=",$userid)->where("orders.orderStatus","=",1)->where("works.deleted_at","=",null)->select("orders.*")->orderBy('created_at', 'desc')->get();

                $document = $this->document->setData($serializer->collection($order));
                return $this->respondToArray($document);


         }
        function getorder($userid){
                
               
                $serializer = new OrderSerializer();
      
                $order=$this->order->join("works","orders.work_id","=","works.id")->join("users","orders.user_id","=","users.id")->where("works.user_id","=",$userid)->where("orders.orderStatus","=",1)->where("works.deleted_at","=",null)->select("orders.*","users.username","users.avatar")->orderBy('created_at', 'desc')->get();
                
                $document = $this->document->setData($serializer->collection($order));
                return $this->respondToArray($document);


        }






}
?>


