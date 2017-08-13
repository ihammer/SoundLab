<?php
session_start();
class IndexController extends BaseController{
	 
	public function index()
	{
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false ) {
			$opus=DB::select("select id from works where deleted_at is NULL");
			$rid=rand(0,(count($opus)-1));
			$play_id=$opus[$rid]->id;//echo $play_id;exit;
			$works=json_decode($this->fgc($_ENV['HOST']."/api/work/".$play_id."/show"),1);
			//print_r($works);die;
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
			return View::make('index', [
				'works' => $works,
				'comment' => $comment,
				'tmpfile' => $tmpfile,
				'duration' => $duration,
				'play_id' => $play_id,
				'peaks' => $peaks,
			]);
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
	function download(){
		return View::make('download');
	}
	function helps(){
		return View::make('helps');
	}
	function helppost(){
		if($_POST['advice'] && $_POST['contact']){
			$sqlarray = array(
				'info' => $_POST['advice'], 
				'contact' => $_POST['contact'], 
				);
			$arrayName = array(
				'info' => $_POST['advice'], 
				'contact' => $_POST['contact'], 
				'status' => 0,
				'created_at' => date("Y-m-d H:i:s",time()),
				'updated_at' => date("Y-m-d H:i:s",time()),
				);
			$sel = DB::table("helps")->where($sqlarray)->get();
			if(count($sel)>0){
				echo "<script>alert('重复提交！');window.location.href='http://pillele.cn/helps?advice=".$_POST['advice']."&contact=".$_POST['contact']."';</script>";
			}else{
				$ins = DB::table("helps")->insert($arrayName);
				if($ins){
					echo "<script>alert('提交成功！');window.location.href='http://pillele.cn/helps?advice=".$_POST['advice']."&contact=".$_POST['contact']."';</script>";
				}else{
					echo "<script>alert('提交失败！');window.location.href='http://pillele.cn/helps?advice=".$_POST['advice']."&contact=".$_POST['contact']."';</script>";
				}
			}
			
		}else{
			echo "<script>alert('请填写您的 宝贵意见 以及 联系方式！');window.location.href='http://pillele.cn/helps?advice=".$_POST['advice']."&contact=".$_POST['contact']."';</script>";
		}
	}
}