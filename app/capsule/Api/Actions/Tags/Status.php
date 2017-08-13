<?php namespace Capsule\Api\Actions\Tags;
use Cache;
use Capsule\Api\Actions\Base;


class Status extends Base {
	
	public function run()
	{
           if(empty($_GET['p'])){
		 $topictatus = Cache::get('topicdate');
         $data['topicdate'] = (string)$topictatus;
         $data['paytatus'] = '1';
          return $data;
         }else{
                $topictatus = Cache::get('makeusernum');
                var_dump($topictatus);
	}         
	}
}
