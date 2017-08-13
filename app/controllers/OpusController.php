<?php
class OpusController extends FormController{
	public $host="http://7xikb7.com1.z0.glb.clouddn.com/";
	public function __construct()
     {
            
     	$tables="works";
		 
          $this->fields_all = [
               'id' => [
                    'show' => '序号',
               ],
               'user_id' => [
                    'show' => '用户ID',
               ],
               'type' => [
                    'show' => '文件类型',
					'search' => "type=1"
               ],
			   'mime' => [
                    'show' => '文件类型',
               ],
               'url' => [
                    'show' => '文件路径',
               ],
			   'filename' => [
                    'show' => '文件名',
               ],
			   'ext' => [
                    'show' => '文件后缀',
               ],
			   'filesize' => [
                    'show' => '文件大小',
               ],
			   'etag' => [
                    'show' => '文件HASH',
               ],
			   'payload' => [
                    'show' => '文件预处理',
               ],
               'created_at' => [
                    'show' => '创建时间',
               ],
               'updated_at' => [
                    'show' => '更新时间',
               ],
          ];
 
          $this->fields_show = ['id', 'filename', 'created_at'];
          $this->fields_edit = ['id', 'filename'];
          $this->fields_create = ['id', 'filename'];
          parent::__construct();
     }
	 
	 public function index()
     {
		$labx=isset($_GET["labx"]) ? $_GET["labx"] : 0;
		if($labx==0){
		 	$models = DB::table("works")->leftJoin('users','works.user_id','=','users.id')->select("users.username as uname","works.*")->orderBy("id","desc")->get();
		}else{
			$models = DB::table("works")->leftJoin('users','works.user_id','=','users.id')->where(array("is_compshow"=>1))->select("users.username as uname","works.*")->orderBy("id","desc")->get();
		}
		return View::make('form.opuslist', [
		   'models' => $models,'labx'=>$labx,'labtype'=>array(1=>"唱片",2=>"周边",3=>"线下活动",4=>"生活方式"),
		]);
     }
     public function linksopus()
     {
//		 echo $_POST['queryString'];
		 if(isset($_POST['queryString'])) {
			 $queryString = $_POST['queryString'];

			 if(strlen($queryString) >0) {
				 $sel = DB::table("users")->where("username","like",$queryString."%")->get();
				 if($sel) {
					 foreach($sel as $k => $v){
						 echo '<li onClick="fill(\''.$v->username.'\',\''.$v->id.'\',\''.$v->mobile.'\');">'.$v->username.'</li>';
					 }
				 } else {
					 echo 'ERROR: 没有数据.';
				 }
			 }
		 }
     }

     public function newlist()
     {
     	$verify=isset($_GET["verify"]) ? $_GET["verify"] : 1;
		  $models = DB::table("works")->leftJoin('users','works.user_id','=','users.id')->where(array("deleted_at"=>NULL))->where("is_verify","=",$verify)->orderBy("works.created_at","desc")->select("users.username as uname","works.*")->get();
		  return View::make('form.opusnewlist', [
               'models' => $models,'host'=>$this->host,
          ]);
     }
	 
	 function getMime($ext){
		static $mime_types = array (
         'jpg' => 'image/jpeg', 
         'jpeg' => 'image/jpeg', 
         'mp3' => 'audio/mpeg',		
         'png' => 'image/png'
		);
		return isset($mime_types[$ext]) ? $mime_types[$ext] : 'application/octet-stream';
	}
	
	public function getWorkTag()
	{
		$list=DB::table("works_tags")->leftJoin("tags",'works_tags.tag_id',"=","tags.id")->where("work_id","=",$_GET["id"])->select("tags.name")->get();
		foreach($list as $key=>$items)
		{
			if($key==0){
				$str=$items->name;
			}else{
				$str.=",".$items->name;
			}
		}
		return $str;
	}
	
	public function uptag(){
		DB::update("UPDATE tags SET count = count-1 WHERE id IN (SELECT tag_id FROM works_tags WHERE work_id =".$_POST["id"].")");
		DB::delete("delete from works_tags where work_id =".$_POST["id"]);
		if($_POST["tag"]!="")
		 {
		 	$workid=$_POST["id"];
			 $tags=explode(",",$_POST["tag"]);
			 foreach($tags as $key=>$item)
			 {
				 if($item!="")
				 {
					 $tag=new Tag();
					 if(!$tag->where("name",$item)->first()){
						$tag->user_id = "";
						$tag->name = $item;
						$tag->save();
						DB::table("works_tags")->insert(array("work_id"=>$workid,"tag_id"=>$tag->id));
						DB::update('update tags set count = count+1 where id = ?', array($tag->id));
					 }else{
						$isset = $tag->where("name",$item)->first();
						DB::table("works_tags")->insert(array("work_id"=>$workid,"tag_id"=>$isset->id));
						DB::update('update tags set count = count+1 where id = ?', array($isset->id));
					 }
					 
				 }
			 }
			}
	}
	
	
	function getreason(){
		$work = new Work();
		$workinfo = $work->find($_GET["id"]);
		echo $workinfo->reason;
	}
	
	public function isrecommend()
	{
		$ret=array('is_recommend' => $_POST["is_recommend"],'recommendtime' => date('Y-m-d H:i:s',time()));
		if($_POST["reason"]!=""){
			$ret['reason'] = $_POST["reason"];
		}
		DB::table('works')->where('id', $_POST["id"])->update($ret);
	}
	
	public function ismusician()
	{
		DB::table('works')->where('id', $_POST["id"])->update(array('is_musician' => $_POST["is_musician"]));
	}
	public function iscontshow()
	{
		DB::table('works')->where('id', $_POST["id"])->update(array('is_contshow' => $_POST["is_contshow"]));
	}
	public function iscompshow()
	{
		DB::table('works')->where('id', $_POST["id"])->update(array('is_compshow' => $_POST["is_compshow"],'comptime'=>$_POST["comptime"],'price'=>$_POST["price"]));
	}
	public function iscompshowtype()
	{
		DB::table('works')->where('id', $_POST["id"])->update(array('is_compshowtype' => $_POST["is_compshowtype"]));
	}
	 public function create()
     {
		 $upload=new UploadController();
		 $models = DB::table("users")->get();
		 $types = DB::table("types")->get();
          return View::make('form.opusadd', [
               'models' => $models,'token' => $upload->token,"types"=>$types,
          ]);
     }
	 
	 public function upmedia()
     {
		 $pathinfo=pathinfo($this->host.$_POST["playurl"]);
		 $playurl=explode("/",$_POST["playurl"]);
		 $work = new Work();
		 $work->user_id=$_POST["user_id"];
		 $work->username=$_POST["username"];
		 $work->title=$_POST["title"];
		 $work->cover=$_POST["src"][0];
		 $work->playurl=$_POST["playurl"];
		 $work->is_dmshow=$_POST["is_dmshow"];
		 $work->is_compshow=$_POST["is_compshow"];
		 $work->comptime=$_POST["comptime"];
		 $work->type_id=$_POST["type_id"];
		 $work->price=$_POST["price"];
		 $work->pricetype=$_POST["pricetype"]; 
		 $work->compstatus=$_POST["is_compshow"]==0?'0':$_POST["compstatus"]; 
		 $work->is_recommend=$_POST["is_recommend"];
		 $work->reason=$_POST["reason"];
		 $work->is_verify=$_POST["is_verify"];
		 $work->modified=date("Y-m-d H:i:s",time());
		 if($_POST["is_recommend"]==1){
			 $work->recommendtime=date("Y-m-d H:i:s",time());
		 }
		 $persons = array();
		 if($_POST["persons"]!="")
		 {
			 $arr_p = explode(";",$_POST["persons"]);
			 foreach($arr_p as $key=>$item)
			 {
				 $itemEx=explode(":",$item);
				 $persons[$key]["key"]=intval($itemEx[0]);
				 $persons[$key]["name"]=$itemEx[1];
				 unset($itemEx);
			 }
			}
		 $work->persons=serialize($persons);
		 $work->filename=$playurl[count($playurl)-1];
		 $work->etag=$_POST["etag"];
		 $work->mime=$this->getMime($pathinfo["extension"]);
		 $mediaInfo=json_decode(file_get_contents($this->host.$_POST["playurl"]."?avinfo"));
		 $work->duration=intval($mediaInfo->format->duration);
		 $work->filesize=$mediaInfo->format->size;
		 $texts = array();
		 if($_POST["texts"]!="")
		 {
			 $arr_t = explode(";",$_POST["texts"]);
			 foreach($arr_t as $key=>$item)
			 {
				 $itemEx=explode(":",$item);
				 $texts[$key]["content"]=$itemEx[1];
				 $texts[$key]["timeline"]=$itemEx[0]/$work->duration;
				 unset($itemEx);
			 }
			}
			$work->texts=serialize($texts);
			echo "<br><br>";
			$work->save();
			DB::update('update users set works_count = works_count+1 where id = ?', array($_POST["user_id"]));
		 if($_POST["tag"]!="")
		 {
			 $tags=explode(",",$_POST["tag"]);
			 foreach($tags as $key=>$item)
			 {
				 if($item!="")
				 {
					 $tag=new Tag();
					 if(!$tag->where("name",$item)->first()){
						$tag->user_id = $_POST["user_id"];
						$tag->name = $item;
						$tag->save();
						DB::table("works_tags")->insert(array("work_id"=>$work->id,"tag_id"=>$tag->id));
						DB::update('update tags set count = count+1 where id = ?', array($tag->id));
					 }else{
						$isset = $tag->where("name",$item)->first();
						DB::table("works_tags")->insert(array("work_id"=>$work->id,"tag_id"=>$isset->id));
						DB::update('update tags set count = count+1 where id = ?', array($isset->id));
					 }
					 
				 }
			 }
			}
		 foreach($_POST["src"] as $key => $item)
		 {
			 $iteminfo=pathinfo($this->host.$item);
			 $itemurl=explode("/",$item);
			 $workimage=new Workimage();
			 $workimage->work_id=$work->id;
			 $workimage->orderby=($key+1)*10;
			 $workimage->etag=$_POST["hash"][$key];
			 $workimage->url=$item;
			 $workimage->filename=$itemurl[count($itemurl)-1];
			 $workimage->filesize=$_POST["size"][$key];
			 $workimage->timeline=$_POST["timeline"][$key];
			 $workimage->mime=$this->getMime($iteminfo["extension"]);
			 $workimage->save();
		 }
		 Queue::push('Capsule\Core\Task@handleFetchPeaks', array('id' => $work->id));
		 return Redirect::to(action($this->controller . '@index'));
     }
	 
	 public function updatemedia()
     {
		 $work = new Work();
		 $work = $work->find($_POST["work_id"]);
		 $work->user_id=$_POST["user_id"];
		 $work->username=$_POST["username"];
		 $work->title=$_POST["title"];
		 $work->price=$_POST["price"];
		 $work->is_recommend=$_POST["is_recommend"];
		 $work->is_private=$_POST["is_private"];
		 $work->is_dmshow=$_POST["is_dmshow"];
		 $work->is_compshow=$_POST["is_compshow"];
		 $work->type_id=$_POST["type_id"];
		 $work->compstatus=$_POST["is_compshow"]==0?'0':$_POST["compstatus"]; 
		 $work->comptime=$_POST["comptime"];
		 $work->pricetype=$_POST["pricetype"];
		 if($_POST["is_recommend"]==1){
			 $work->recommendtime=date("Y-m-d H:i:s",time());
		 }
		 if(!empty($_POST["reason"])){
		 $work->reason=$_POST["reason"];
		 }
		 $persons = array();
		 if($_POST["persons"]!="")
		 {
			 $arr_p = explode(";",$_POST["persons"]);
			 foreach($arr_p as $key=>$item)
			 {
				 $itemEx=explode(":",$item);
				 $persons[$key]["key"]=intval($itemEx[0]);
				 $persons[$key]["name"]=$itemEx[1];
				 unset($itemEx);
			 }
			}
		 $work->persons=serialize($persons);
		 $texts = array();
		 if($_POST["texts"]!="")
		 {
			 $arr_t = explode(";",$_POST["texts"]);
			 foreach($arr_t as $key=>$item)
			 {
				 $itemEx=explode(":",$item);
				 $texts[$key]["content"]=$itemEx[1];
				 $texts[$key]["timeline"]=$itemEx[0]/$work->duration;
				 unset($itemEx);
			 }
		}
		$work->texts=serialize($texts);
		DB::table('works_images')->where('work_id', '=', $_POST["work_id"])->delete();
		foreach($_POST["src"] as $key => $item)
		 {
			 $iteminfo=pathinfo($this->host.$item);
			 $itemurl=explode("/",$item);
			 $workimage=new Workimage();
			 $workimage->work_id=$work->id;
			 $workimage->orderby=($key+1)*10;
			 $workimage->etag=$_POST["hash"][$key];
			 $workimage->url=$item;
			 $workimage->filename=$itemurl[count($itemurl)-1];
			 $workimage->filesize=$_POST["size"][$key];
			 $workimage->timeline=$_POST["timeline"][$key];
			 $workimage->mime=$this->getMime($iteminfo["extension"]);
			 $workimage->save();
			 if($_POST["timeline"][$key]==0){
			 	$work->cover=$item;
			}
		 }
		 $work->save();
		return Redirect::to(action($this->controller . '@index'));
     }
	 
	 public function imageList($id){
		 $work = new Work();
		 $work = $work->find($id);
		 $workimage=new Workimage();
		 $workimage=$workimage->where("work_id","=",$id)->get();
		 return View::make('form.imagelist', [
               'workimage' => $workimage,
			   'work' => $work
          ]);
	 }
	 
	 public function edit($id)
     {
		 $model = DB::table("works")->find($id);
		 $types = DB::table("types")->get();
		 $models = DB::table("users")->get();
		 $text = unserialize($model->texts);
		 $texts="";
		 foreach($text as $key => $item){
			$texts .= ($key==0 ? "" : ";").$item["timeline"]*$model->duration.":".$item["content"];
		 }
		 $person = unserialize($model->persons);
		 $persons="";
		 foreach($person as $key => $item){
			$persons .= ($key==0 ? "" : ";").$item["key"].":".$item["name"];
		 }
		 $images=DB::table("works_images")->where("work_id","=",$id)->get();
		 return View::make('form.opusedit', [
               'model' => $model,
			   "models" => $models,
			   "texts" => $texts,
			   "persons" => $persons,
			   "host"=>$this->host,
			   "images"=>$images,
			   "types"=>$types,
          ]);
     }
	 
     public function newverify($id)
     {
		 $model = DB::table("works")->find($id);
		 $models = DB::table("users")->get();
		 $workimage=new Workimage();
		 $workimage=$workimage->where("work_id","=",$id)->get();
		 $text = unserialize($model->texts);
		 $texts="";
		 foreach($text as $key => $item){
			$texts .= ($key==0 ? "" : ";").$item["timeline"]*$model->duration.":".$item["content"];
		 }
		 $person = unserialize($model->persons);
		 $persons="";
		 foreach($person as $key => $item){
			$persons .= ($key==0 ? "" : ";").$item["key"].":".$item["name"];
		 }
		 return View::make('form.opusverify', [
               'model' => $model,
               'workimage' => $workimage,
			   "models" => $models,
			   "texts" => $texts,
			   "persons" => $persons,
			   "host"=>$this->host,
          ]);
     }
	 
		public function uptonewest()
		{
			DB::update("UPDATE works SET is_verify = ".$_POST["is_verify"]." WHERE id = ".$_POST["work_id"]);
			return Redirect::to(action($this->controller . '@newlist'));
		}
	 
	 public function delopus()
	 {
		 $id=Input::get('id');
		 //DB::update("UPDATE tags SET count = count-1 WHERE id IN (SELECT tag_id FROM works_tags WHERE work_id =".$id.")");
		 DB::update("UPDATE works SET deleted_at = '".date("Y-m-d H:i:s")."' WHERE id = ".$id);
		 return Redirect::to(action($this->controller . '@index'));
	 }
 
     public function destroy($id)
     {
         $model = new $this->model;
         $model->destroy($id);
         
     }
     
	public function changePerson(){
		$models = DB::table("works")->where(array("deleted_at"=>NULL))->where("id",">",386)->whereNotIn("user_id",array(45,46))->select("works.*")->get();
		foreach($models as $keys=>$item){
			$person=unserialize($item->persons);
			$i=count($person);
			foreach($person as $key => $items){
				switch($person[$key]["key"]){
					case 0:
						break;
					case 1:
						$person[$key]["key"]=3;
						break;
					case 2:
						$person[$key]["key"]=4;
						break;
					case 3:
						$person[$key]["key"]=5;
						break;
					case 4:
						$person[$key]["key"]=6;
						break;
					case 5:
						$person[$key]["key"]=7;
						$person[$i]["key"]=8;
						$person[$i]["name"]=$person[$key]["name"];
						$i++;
						break;
					case 6:
						unset($person[$key]);
						break;
					case 7:
						$person[$key]["key"]=1;
						break;
					default:
						break;
				}
			}
			DB::update("UPDATE works SET persons = '".serialize($person)."' WHERE id = ".$item->id);
			//echo "UPDATE works SET persons = '".serialize($person)."' WHERE id = ".$item->id;echo "<br>";//if($keys==105) exit;
		}
	}
	
			public function workpush(){
				$users = DB::select("select id,devicetoken,LENGTH(devicetoken) as len from users where LENGTH(devicetoken) > 40");//echo count($users);exit;
				$content=$_POST["content"];
				$id=$_POST["id"];
				$curtime=date("Y-m-d H:i:s",time());
				foreach($users as $item){
					if($item->len==64){
						//$item->devicetoken=$token="b67c0dd8a7d93c2dfcf33105be83ec160f806c0c5c78483caf93f7a02a522074";
						//$item->id=1062;
						$sid = DB::table("system_messages")->insertGetId(
																															array(
																																'userid'=>$item->id,
																																'devicetoken'=>$item->devicetoken,
																																'message'=>$content,
																																'action'=>"work:".$id,
																																'created_at'=>$curtime,
																																'updated_at'=>$curtime
																															)
																														);
						Queue::push('Capsule\Core\Push@run', array('id' => $sid));//exit;
					}
				}
				echo 1;exit;
			}
}