<?php
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\FormUploader;
use Qiniu\Storage\UploadManager;

class UploadController extends Controller{
	
	public $input=array();
	public $token;
	public $host="http://7xikb7.com1.z0.glb.clouddn.com/";
	
	public function __construct()
	{
		set_time_limit(0);
		$this->input=Input::all();
		$QINIU_ACCESS_KEY = "uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ";
        $QINIU_SECRET_KEY = "P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B";
        $auth = new Auth($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
		$bucket = 'test';
		$opts = array(
            'insertOnly' => 0
		);
		$this->token = $auth->uploadToken($bucket, null, 3600, $opts);
	}
	
	function getExt($mime){
		static $mime_types = array (
        'image/jpeg' => 'jpg', 
        'audio/mpeg' => 'mp3',
				'audio/mp3' => 'mp3',		
        'image/png' => 'png'
		);
		return isset($mime_types[$mime]) ? $mime_types[$mime] : 'application/octet-stream';
	}

	function getExt_jj($mime){
		static $mime_types = array (
        'image/jpeg' => 'jpg', 	
        'image/png' => 'png'
		);
		return isset($mime_types[$mime]) ? $mime_types[$mime] : 'application/octet-stream';
	}
	
public function testff(){
		echo '<form method="post" action="testup"
 enctype="multipart/form-data">
  
  <input name="file" type="file" /><input type="submit">
</form>';
	}
	
	public function test()
	{
		print_r($_FILES);exit;
    $key = 'ab.mp3';
		$upManager = new UploadManager();
        list($ret, $error) = $upManager->putFile($this->token, $key, $_FILES["file"]["tmp_name"]);
        if ($error !== null) {
			var_dump($error);
		} else {
			var_dump(json_decode(json_encode($ret)));
			$accessKey = 'uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ';
			$secretKey = 'P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B';
			$auth = new Auth($accessKey, $secretKey);
			$bucketMgr = New BucketManager($auth);
			
		
		}
    
	}

		
	public function path($hash)
    {
        $dates = array(date("Y"), date("md"));
        $parts = array_slice(str_split($hash, 2), 0, 2);
        return join('/', $dates) ."/".join('/', $parts)."/".uniqid();
    }
	
	public function run()
	{
		if($this->input["upto"]==1){
			$picname = $_FILES['avatar']['name'];
			$picsize = $_FILES['avatar']['size'];
			if ($picname != "") {
				if ($picsize > 5120000) {
					echo '图片大小不能超过1M';
					exit;
				}
				$type = strtolower(strstr($picname, '.'));
				if ($type != ".gif" && $type != ".jpg"  && $type != ".png") {
					echo '图片格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$pic_path = "/var/www/capsule2/public/tmpfile/". $pics;
				move_uploaded_file($_FILES['avatar']['tmp_name'], $pic_path);
			}
			$size = round($picsize/1024,2);
			$image_size = getimagesize($pic_path);
			$arr = array(
				'name'=>$picname,
				'pic'=>$pics,
				'size'=>$size,
				'width'=>$image_size[0],
				'height'=>$image_size[1]
			);
			echo json_encode($arr);
		}elseif($this->input["upto"]==2){
			$upfile=$this->crop();
			$this->upAvatar($upfile);
		}
	}
	
	public function upAvatar($upfile)
	{
		$info=pathinfo(realpath($upfile));
		$ch = curl_init();
		$data = array('file'=>new CURLFile(realpath($upfile)),'token'=>$this->token,'key'=> uniqid().".".$info['extension']);
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
		curl_setopt($ch,CURLOPT_URL,"http://upload.qiniu.com/");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		$result = curl_exec($ch);
		curl_close($ch);
		$res=json_decode($result);
		$this->moveFile($res,3,0);
		if(file_exists(realpath($upfile))) {
			unlink(realpath($upfile));
		}
	}
	
	public function upfile()
	{
		if($this->input["type"]==1){
			$key = uniqid().'.'.$this->getExt($_FILES['file']['type']);
			$upManager = new UploadManager();
			list($ret, $error) = $upManager->putFile($this->token, $key, $_FILES["file"]["tmp_name"]);
			if ($error !== null) {
				var_dump($error);
			} else {
				$res=json_decode(json_encode($ret));
				$this->moveFile($res,$this->input["type"],$_FILES["file"]["size"]);
			}

		}else if($this->input["type"]==2){
			$picname = $_FILES['file']['name'];
			$picsize = $_FILES['file']['size'];
			if ($picname != "") {
				if ($picsize > 5120000) {
					echo '图片大小不能超过1M';
					exit;
				}
				$type = strtolower(strstr($picname, '.'));
				if ($type != ".gif" && $type != ".jpg"  && $type != ".png") {
					echo '图片格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$pic_path = "/var/www/capsule2/public/tmpfile/". $pics;
				move_uploaded_file($_FILES['file']['tmp_name'], $pic_path);
			}
			$size = round($picsize/1024,2);
			$image_size = getimagesize($pic_path);
			$arr = array(
				'name'=>$picname,
				'pic'=>$pics,
				'size'=>$size,
				'width'=>$image_size[0],
				'height'=>$image_size[1]
			);
			echo json_encode($arr);
		}else if($this->input["type"]==3){
			$upfile=$this->crop();
			$this->upAvatar($upfile);
		}
		
	}
	
	public function moveFile($res,$type,$size)
	{
		$info=pathinfo($this->host.$res->key);
		$bucket="test";
		$accessKey = 'uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ';
		$secretKey = 'P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B';
		$auth = new Auth($accessKey, $secretKey);
		$bucketMgr = New BucketManager($auth);
		$key = $res->key;
		$key3 = "Group".str_pad($type, 2, '0', STR_PAD_LEFT)."/".$this->path($res->hash).".".$info['extension'];
		$err = $bucketMgr->move($bucket, $key , $bucket , $key3);
		if ($err !== null) {
			var_dump($err);
		} else {
			echo json_encode(array("src"=>$key3,"hash"=>$res->hash,"size"=>$size));
		}
	}

	public function moveFile_jj($res,$type,$size)
	{
		$info=pathinfo($this->host.$res->key);
		$bucket="test";
		$accessKey = 'uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ';
		$secretKey = 'P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B';
		$auth = new Auth($accessKey, $secretKey);
		$bucketMgr = New BucketManager($auth);
		$key = $res->key;
		$key3 = "Group".str_pad($type, 2, '0', STR_PAD_LEFT)."/".$this->path($res->hash).".".$info['extension'];
		$err = $bucketMgr->move($bucket, $key , $bucket , $key3);
		if ($err !== null) {
			var_dump($err);
		} else {
			return array("src"=>$key3,"hash"=>$res->hash,"size"=>$size);
		}
	}

	function jjuploads(){
		$state = array('data' => array(),'info'=>'上传失败','state' => 0);

		if($this->input["jj"]==1){
			$key = uniqid().'.'.$this->getExt($_FILES['file']['type']);
			$upManager = new UploadManager();
			list($ret, $error) = $upManager->putFile($this->token, $key, $_FILES["file"]["tmp_name"]);
			if ($error !== null) {
				var_dump($error);
			} else {
				$res=json_decode(json_encode($ret));
				$json = $this->moveFile_jj($res,$this->input["type"],$_FILES["file"]["size"]);
				exit(json_encode($json));
			}

		}else if($this->input["jj"]==2){
			$picname = $_FILES['file']['name'];
			$picsize = $_FILES['file']['size'];
			if ($picname != "") {
				if ($picsize > 5120000) {
					echo '图片大小不能超过1M';
					exit;
				}
				$type = $this->getExt_jj($_FILES['file']['type']);
				if ($type != "jpg"  && $type != "png") {
					echo '图片格式不对！';
					exit;
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . '.' .$type;
				$pic_path = "/var/www/capsule2/public/tmpfile/". $pics;
				move_uploaded_file($_FILES['file']['tmp_name'], $pic_path);
			}
			$size = round($picsize/1024,2);
			$image_size = getimagesize($pic_path);
			$arr = array(
				'name'=>$picname,
				'pic'=>$pics,
				'size'=>$size,
				'width'=>$image_size[0],
				'height'=>$image_size[1]
			);

			ob_start();
			$this->upAvatar($pic_path);
			$json = ob_get_contents();
			ob_end_clean();
			die(json_encode(json_decode($json)));

			//exit(json_encode($arr));
		}else if($this->input["jj"]==3){
			$upfile=$this->crop();
			$this->upAvatar($upfile);
		}else if($this->input["jj"]==4){
			// var_dump($_POST);
			// $key = uniqid().'.json';
			$a = $_POST['waveform'];
			$a2 = json_decode($a);
			foreach($a2 as $k => $v){
				$b[] = $v*100;
			}
		    $c = json_encode($b);
			$wavepeaks = '{"peaks":'.$c.'}';
			$rand = rand(100, 999);
			$pics = date("YmdHis") . $rand . '.json';
			$pic_path = "/var/www/capsule2/public/tmpfile/". $pics;
			file_put_contents($pic_path,$wavepeaks);
			ob_start();
			$this->upAvatar($pic_path);
			$json = ob_get_contents();
			ob_end_clean();
			$addressw = (array)json_decode($json);
			echo $addressw['src'];
		}

		// exit(json_encode($state));
	}
	
	public function crop()
	{
		$MemberFace = $this->sliceBanner("cute");
		return $MemberFace;
	}
	
	function sliceBanner($UserName){
		$x = (int)$this->input['x'];
		$y = (int)$this->input['y'];
		$w = (int)$this->input['w'];
		$h = (int)$this->input['h'];
		$pic = "/var/www/capsule2/public".$this->input['src'];
		
		//剪切后小图片的名字
		$str = explode(".",$pic);//图片的格式
		$type = $str[1]; //图片的格式
		$filename = $UserName."_".date("YmdHis").".". $type; //重新生成图片的名字
		$uploadBanner = $pic;
		$sliceBanner = "/var/www/capsule2/public/tmpfile/".$filename;//剪切后的图片存放的位置
		
		//创建图片
		$src_pic = $this->getImageHander($uploadBanner);
		$dst_pic = @imagecreatetruecolor($w, $h);
		@imagecopyresampled($dst_pic,$src_pic,0,0,$x,$y,$w,$h,$w,$h);
		@imagejpeg($dst_pic, $sliceBanner);
		@imagedestroy($src_pic);
		@imagedestroy($dst_pic);
		//删除已上传未裁切的图片
		if(file_exists($uploadBanner)) {
			unlink($uploadBanner);
		}
		//返回新图片的位置
		return $sliceBanner;
	}

	function getImageHander ($url) {
		$size=@getimagesize($url);
		switch($size['mime']){
			case 'image/jpeg': $im = imagecreatefromjpeg($url);break;
			case 'image/gif' : $im = imagecreatefromgif($url);break;
			case 'image/png' : $im = imagecreatefrompng($url);break;
			default: $im=false;break;
		}
		return $im;
	}
}