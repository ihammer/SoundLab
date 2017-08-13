<?php namespace Capsule\Api\Actions\Common;
use Response,Queue;
use Capsule\Api\Actions\Base;

class Paystatus extends Base {

        public function run()
        {

         $data['status'] = '1';
         
        Queue::push('Capsule\Core\Makeuser@run', array('id' => 1)); 
        echo "执行－－".date('y-m-d h:i:s',time());


        }

}
