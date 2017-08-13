<?php namespace Capsule\Api\Actions\Common;

use DB, Sentry, Input, Response,Hash,Cache;
use Capsule\Core\Users\User;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;
use Capsule\Api\Actions\Base;
use Capsule\Api\Actions\Auth\Register;
class Makeuser extends Base {



	public function run(){
         ignore_user_abort(); // run script in background
		     set_time_limit(0);
         $num = Cache::get('makeusernum');//话题推荐客户端提醒

         $count = 1000+$num;
         $inum = $num?$num:1;
          for($i=$inum+1;$i<=$count;$i++){

          	$xiaomi = DB::select('select username from xiaomi_com where id = ?', array($i));

          	//pr($xiaomi[0]->username);
          	$created_at = $this->rand_time(date('y-m-d',time()-3600*24*30*6),date('y-m-d',time()));
        //    $created_at = $this->rand_time(date('y-m-d',time()),date('y-m-d',time()));
			$last_login = strtotime($created_at)+3600*24*(rand(1,10));
			$updated_at = strtotime($created_at)+3600*24*(rand(1,2));
			$mobile_info = $this->make_mobile();
                $data=array(
		 	"uuid"=>$this->make_uuid(),
			"username" => $xiaomi[0]->username,
			"mobile" => $mobile_info['mobile'],
			'password' => $this->make_char(8),
			'avatar'   => 'Group0'.date("w").'/'.date("Y",strtotime($created_at)).'/'.date("md",strtotime($created_at)).'/F'.$this->make_char(1,1).'/'.$this->make_char(2,2).'/'.$this->make_char(13).'.jpg',
			'sex'      => $this->make_char(1,3),
			'location' => $mobile_info['city_info'],
			'introduce'=>'',
			'utype_id'=>0,
			'created_at'=>$created_at,
			'persist_code'=>Hash::make($this->make_char(44)),
			'fans_count'=>rand(1,10),
			'follow_count'=>rand(1,50),
			'works_count'=>rand(1,10),
                         'score'=>rand(1,30),
                         'visit'=>rand(1,50),
                'last_login'=>$last_login,
                'activated_at'=>$created_at,
               'deviceToken'=>$this->make_deviceToken(64),
                'updated_at'=>$updated_at,


		 );
		$user=Sentry::register($data);
		//pr($user);
		$Response = $user->save();
		if($Response){
	       echo 'success';
	       echo '<br>'	;	
          //  mylog('--success--插入xiaomi--id--'.$i);
		}else{
		echo 'fails';
	       echo '<br>'	;	
	 //      mylog('--fails--插入xiaomi--id--'.$i);		
		}
       Cache::forever('makeusernum', $i);//
          }
       
	echo  'makeuser--'.$num;	

		 

	}


function make_deviceToken(){
	$i = rand(1,2);
	if($i==1){
        return    $this->make_char(64);
	}else{
	   return    $this->make_char(19);	
	}
}



function  make_mobile(){
   sleep(10);

$arr = array(
    130,131,132,133,134,135,136,137,138,139,
    144,147,
    150,151,152,153,155,156,157,158,159,177,178,
    180,181,182,183,184,185,186,187,188,189,
);
for($i = 0; $i < 10; $i++) {
    $tmp[] = $arr[array_rand($arr)].mt_rand(1000,9999).mt_rand(1000,9999);
}
$i = rand(0,9);
array_unique($tmp);
$mobile = $tmp[$i];
//pr($mobile);
$ch = curl_init();
    $url = 'http://apis.baidu.com/showapi_open_bus/mobile/find?num='.$mobile;
    $header = array(
        'apikey:d68b10b9720119834bc486a252cff695',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);

    

    $Response =  json_decode($res,1);
    $data = array();  
    if(!empty($Response['showapi_res_body']['prov'])&&!empty($Response['showapi_res_body']['city'])){
    		 $data['city_info'] = $Response['showapi_res_body']['prov'].' '.$Response['showapi_res_body']['city'];
    	      $data['mobile'] = $mobile;
    }else{
    		$data['city_info'] = rand(0,1)?'北京 海淀':'北京 朝阳';
    		$data['mobile'] = $mobile;
    }     
    
    return  $data; 
}

//生成随机时间
function rand_time($start_time,$end_time){

  $start_time = strtotime($start_time);
  $end_time = strtotime($end_time);
  return  date('Y-m-d H:i:s', mt_rand($start_time,$end_time));
}


	
function make_uuid(){
 	//pr(date("m",time()));
 $str1 = date("h",time()).$this->make_char(6);
 $str2 ='a'.$this->make_char(3);

 $str3 = '11e'.date("w");
 $str4 = $this->make_char(4);
 $str5 = $this->make_char(12);
 $str = $str1.'-'.$str2.'-'.$str3.'-'.$str4.'-'.$str5;
 return $str;

}






function make_char( $length = 8 ,$type=0){  

// 密码字符集，可任意添加你需要的字符  
if($type==1){
	$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h','i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's');
}elseif($type==0){
	$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',  

'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',  

't', 'u', 'v', 'w', 'x', 'y','z','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9','0', '1', '2', '3', '4', '5', '6', '7', '8', '9');  

}elseif ($type==2) {
	$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',  

'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',  

't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',  

'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',  

'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z');  

}elseif ($type==3) {
	$chars = array('0','1','2');
}

// 在 $chars 中随机取 $length 个数组元素键名  

$char_txt = '';  

for($i = 0; $i < $length; $i++){  

   // 将 $length 个数组元素连接成字符串  

   $char_txt .= $chars[array_rand($chars)];  

}

return $char_txt;

}








}
?>
