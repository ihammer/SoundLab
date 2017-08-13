<?php
session_start();
class ZpchomeController extends BaseController{
	 
	public function index()
	{
			if (isset($_SESSION['mobile']) && !empty($_SESSION['mobile'])) {
				$mobile = $_SESSION['mobile'];
				$users = DB::table("users")->where(array("mobile"=>$mobile))->get();

				$guanzhu = DB::table("users_follower")->where(array("touid"=>$users[0]->id))->get();
				$fensi = DB::table("users_follower")->where(array("fromuid"=>$users[0]->id))->get();

				$worksa0 = DB::table("works")->where(array("user_id"=>$users[0]->id,"deleted_at"=>NULL))->get();
				$perNumber=9; //每页显示的记录数
				// if (!isset($page)) {
				// var_dump($lovecounts);
				$page=Input::get('page'); //获得当前的页面值
				if(!isset($page)){
					$page=1;
				}
				$totalNumber=count($worksa0); //获得记录总数
				$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
				
				$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录

				$worksa = DB::table("works")->where(array("user_id"=>$users[0]->id,"deleted_at"=>NULL))->orderBy('id', 'des')->get();
				// foreach ($worksa as $key => $value) {
				// 	$lovecounts = DB::table("users_likes_records")
				// 	->where(array("work_id"=>$value->id))
				// 	->groupBy('work_id')
				// 	->selectRaw('work_id, count(id) as sum')
				// 	->get();
				// 	if($lovecounts){
				// 		$worksa[$key]->love_sum=$lovecounts[0]->sum;
				// 	// var_dump($lovecounts[0]->work_id);die;
				// 	}else{
				// 		$worksa[$key]->love_sum=0;
				// 	}
					
				// }
				// var_dump($worksa[0]);die;
				
				$id = Input::get('id');
				$w = 0;
				if(!empty($id)){
					$worksas = DB::table("works")->where(array("id"=>$id,"user_id"=>$users[0]->id,"deleted_at"=>NULL))->get();
					$w = count($worksas);
				}
				// var_dump($worksas);
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false ) {
			// $opus=DB::select("select id from works where deleted_at is NULL");
			// $rid=rand(0,(count($opus)-1));
			if($w>0){
				$play_id=$id;
			}else{
				$play_id=$worksa[0]->id;//echo $play_id;exit;
			}

			$works=json_decode($this->fgc("http://123.57.1.143/api/work/".$play_id."/show"),1);
			//$peaks=json_decode(file_get_contents($works["links"]["waveform"]),1);//print_r($peaks);exit;
			
			foreach($works["data"]["persons"] as $key=>$val){
				switch ($val['key']) { 	
					case 0:
						$works["data"]["persons"][$key]["key"]="人声";
						break;
					case 1:
						$works["data"]["persons"][$key]["key"]="创作者";
						break;
					case 2:
						$works["data"]["persons"][$key]["key"]="图像";
						break;
					case 3:
						$works["data"]["persons"][$key]["key"]="吉他";
						break;
					case 4:
						$works["data"]["persons"][$key]["key"]="贝司";
						break;
					case 5:
						$works["data"]["persons"][$key]["key"]="鼓";
						break;
					case 6:
						$works["data"]["persons"][$key]["key"]="键盘";
						break;
					case 7:
						$works["data"]["persons"][$key]["key"]="管乐器";
						break;
					case 8:
						$works["data"]["persons"][$key]["key"]="弦乐器";
						break;
					case 9:
						$works["data"]["persons"][$key]["key"]="民族乐器";
						break;
					default:
						break;
				}
			}
			$comment=json_decode($this->fgc("http://123.57.1.143/api/comment/".$play_id."/show"),1);
			$tmpfile=json_decode($this->fgc("http://123.57.1.143/api/work/".$play_id."/tmpfile"),1);
			foreach($works["data"]["texts"] as $key => $item){
				$works["data"]["texts"][$key]["timeline"]=intval($item["timeline"]*$works["data"]["duration"]);
			}
			foreach($works["data"]["timeline"] as $key => $item){
				$works["data"]["timeline"][$key]=intval($item*$works["data"]["duration"]);
			}
			$duration=gmstrftime("%M'%S'",$works["data"]["duration"]);//var_dump($works);die;
			$peaks=json_decode(file_get_contents($works["links"]["waveform"]),1);
			
			return View::make('web/home',[
				'mobile'=>$mobile,
				'users'=>$users,
				'worksa'=>$worksa,
				'startCount'=>$startCount,
				'perNumber'=>$perNumber,
				'page'=>$page,
				'totalPage'=>$totalPage,
				'totalNumber'=>$totalNumber,
				'guanzhu'=>count($guanzhu),
				'fensi'=>count($fensi),
				'works' => $works,
				'comment' => $comment,
				'tmpfile' => $tmpfile,
				'duration' => $duration,
				'play_id' => $play_id,
				'peaks' => $peaks,
				// 'lovecounts' => $lovecounts
			]);
		}


				// return View::make('web/home',['mobile'=>$mobile,'users'=>$users,'works'=>$works]);
			}else{
				return View::make('web/login');
			}
	}

	function fgc($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	
}