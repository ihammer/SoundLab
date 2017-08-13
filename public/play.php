<?php
function isMobile(){
	$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';    
	$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';      
	function CheckSubstrs($substrs,$text){    
		foreach($substrs as $substr){  
			if(false!==strpos($text,$substr)){    
				return true;    
			}
		}
		return false;    
	}
	$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');  
	$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');    
	$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||    
	CheckSubstrs($mobile_token_list,$useragent);    
	if ($found_mobile){    
		return true;    
	}else{    
		return false;    
	}    
}  
if(isMobile()) {
function fgc($url){
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	return $output;
}
$works=json_decode(fgc("http://soundlab.com/api/work/".$_GET["id"]."/show"),1);
$peaks=json_decode(file_get_contents($works["links"]["waveform"]),1);
//echo count($peaks['peaks']);
// echo $peaks['peaks'][0];
// var_dump($peaks);
// exit;
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
$comment=json_decode(fgc("http://soundlab.com/api/comment/".$_GET["id"]."/show"),1);
$tmpfile=json_decode(fgc("http://soundlab.com/api/work/".$_GET["id"]."/tmpfile"),1);
foreach($works["data"]["texts"] as $key => $item){
	$works["data"]["texts"][$key]["timeline"]=intval($item["timeline"]*$works["data"]["duration"]);
}
foreach($works["data"]["timeline"] as $key => $item){
	$works["data"]["timeline"][$key]=intval($item*$works["data"]["duration"]);
}
$duration=gmstrftime("%M'%S'",$works["data"]["duration"]);
// echo '<pre>';               
// var_dump($works["data"]);
// echo '</pre>';die;
?>
<!DOCTYPE html>    
<html>
<head>
<title><?php echo $works["data"]["title"];?> | 声音实验室</title>
<meta charset="utf-8" >
<meta http-equiv="Content-Language" content="zh-CN"></meta>
<meta content="telephone=no" name="format-detection">
<meta name='apple-itunes-app' content='app-id=id991508808'>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
<script src="js/jquery.min.js"></script> 
<script  src="js/jquery.danmu.js"></script>
<style>
@charset "utf-8";
body,div,a,span,img,input,form{margin:0;padding:0;}
body{font-family:'Microsoft YaHei';background:#ffffff;background-size:100%;}
a,a:visited{color:#fff;}
a:hover,a:visited{text-decoration:none;}

#main_b{width:100%;position:fixed;left:0;bottom:0;z-index:99;}
#main_b input{width:100%;height:50px;background:#98999b;border:0;border-radius:0;font-size:18px;padding-left:10px;padding-top:5px;}
.layer_1_1 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_1 .showbtn_1{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_2 .showbtn_2 img{max-width: 100%; height: auto;}
.layer_1_2 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_2 .showbtn_2{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_1 .showbtn_1 img{max-width: 100%; height: auto;}
#main{position:relative;}
#main_a{position:relative;margin-bottom:55px;}
#main_a .layer_1{position:relative;width:100%;overflow: hidden;}
#main_a .layer_1 .showbtn{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=60); -moz-opacity:0.6; -khtml-opacity: 0.6; opacity: 0.6; }
#main_a .layer_1 .showbtn img{margin-top:35%;}
#main_a .layer_1 .zhezhao {position:absolute;left:0;top:0;text-align:center;width:100%;overflow: hidden;height: 100%;}
#main_a .layer_2{position:absolute;left:0;top:0;z-index:9;width:100%;}
#main_a .layer_2 .keyws{padding:5px;}
#main_a .layer_2 .keyws a{display:block;font-size:14px;line-height:13px;text-decoration:none;padding:2px 5px;border:1px solid #fff;color:#fff;float:left;margin-left:5px;}
#main_a .layer_2 .scroll{width:100%;height:100px;padding-top:20px;}
#main_a .layer_2 .scroll .scr_1{height:30px;background:#000000;color:#fff;clear:both;}
#main_a .layer_2 .scroll .scr_1 span{font-size:14px;float:left;line-height:30px;}
#main_a .layer_3{position:absolute;left:0;bottom:-75px;z-index:9;}
#main_a .layer_3 .tit_bg{position:relative;}
#main_a .layer_3 .tit_bg .tit_info{position:absolute;left:0;bottom:90px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_info span{display:block;background:#000;color:#fff;font-size:16px;width:150px;padding:5px 8px;}
#main_a .layer_3 .tit_bg .tit_time{position:absolute;right:10px;bottom:58px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_time span{font-size:12px;}
#main_a .layer_3 .tit_bg .tit_intro{position:absolute;left:0;z-index:9;bottom:50px;}
#main_a .layer_3 .tit_bg .tit_intro span{dispaly:inline-block;float:left;height:29px;line-height:29px;background:#98999b;padding:0px 5px;font-size:12px;color:#fff;margin-right: 5px;margin-bottom: 3px;}
#main_a .layer_3 .tit_bg .tit_muis{min-weight:500px;width:100%;height:55px;clear:both;}
#author{padding-top:33px;height:40px;overflow:hidden;}
#author .author_n{float:left;padding-left:10px;}
#author .author_pl{float:right;padding-right:10px;padding-top:10px;}
#author .author_n span{float:left;font-size:16px;line-height:30px;}
#author .author_n img{display:block;overflow:hidden;}
#author .author_pl span{float:left;font-size:16px;}
#author .author_pl .num{padding-right:10px;color:#999999;}
#danmu{
    width:100%;
    background-color:#fff;
    z-index:9999;
    background-color: rgba(000, 000, 000, 0);
    overflow:hidden; 
}
#danmu span{
    position:relative;
    font-size:18px;
    background-color:#000;
    color:#fff;
    display:inline-block;
    min-height:20px;height: auto;
    line-height: 20px;

}
#danmu span img{
	width: 20px;height:20px;
   margin:0;padding:0;
   overflow: hidden; 
}

 .breath { overflow:hidden;  color: #fff; opacity:0.1; -webkit-border-radius:2px;
            -o-border-radius:2px; border-radius:2px; -webkit-animation-name: breath;
            -webkit-animation-duration: 1s; /*人的普通呼吸时间是3秒每次，深呼吸时间是6秒每次*/ -webkit-animation-timing-function:
            ease-in-out; -webkit-animation-iteration-count: infinite; } @-webkit-keyframes
            'breath' { from { opacity:0.1; } 50% { opacity:1; } to { opacity:0.1; }
            } @-webkit-keyframes 'breath2' { from { opacity:0.5; } 50% { opacity:1;
            } to { opacity:0.5; } } 
            .size2{ width:50%;   -webkit-animation-name:
            breath2; }

/*.breathb {  opacity:0.1; -webkit-border-radius:5px;
            -o-border-radius:5px; border-radius:5px; -webkit-animation-name: breath;
            -webkit-animation-duration: 1s; /*人的普通呼吸时间是3秒每次，深呼吸时间是6秒每次*/ 
         /*   -webkit-animation-timing-function:ease-in-out; 
            -webkit-animation-iteration-count: infinite; 
          } @-webkit-keyframes
            'breath' { from { opacity:0.4; } 50% { opacity:1; } to { opacity:0.5; }
            } @-webkit-keyframes 'breath2' { from { opacity:0.5; } 50% { opacity:1;
            } to { opacity:0.5; } } 
            .sizeb2{ width:50%;   -webkit-animation-name:
            breath2; }*/
</style>
<script type="text/javascript">
$(window).load(function(){ 
	setTimeout('$("#loading").hide();',2000); 
    
}) 
</script>
</head>
<body>
<div style="display:none;"><img width="100%" height="100%" src="<?php echo $works["data"]["cover"];?>" /></div>
<div class="layer_1_1" onclick="$('.layer_1_1').hide();">
		<span class="showbtn_1"><img src="/ios.png" /></span>
</div>
<div class="layer_1_2" onclick="$('.layer_1_2').hide();">
		<span class="showbtn_2"><img src="/android.png" /></span>
</div>
<div style="display:none;">
<audio src="<?php echo $tmpfile["tmpfile"];?>" preload="true" id="video1" hidden>    
</audio></div>
<div id="main_b">
	<!--form><input type="text" value="输入弹幕..." /></form-->
</div>
<div id="author" style="padding-top:10px;">
	<div class="author_n">
            <span><a href="/slmy/my.php?id=<?php echo $works["data"]["user"]["uid"]?>"><img width="30" height="30" src="<?php echo $works["data"]["user"]["avatar"];?>" /></a></span>
		<span class="name">&nbsp;<?php echo $works["data"]["user"]["username"];?></span>
		<span class="name" style="color:#6b6b6b;font-size:14px;">&nbsp;<?php echo $works["data"]["user"]["sex"]==1?'男':'';?><?php echo $works["data"]["user"]["sex"]==2?'女':'';?><?php echo $works["data"]["user"]["sex"]==0?'外星人':'';?></span>
		<!-- <br> -->
		<!-- <span class="name" style="color:#6b6b6b;font-size:14px;">&nbsp;<?php echo $works["data"]["user"]["utype"];?></span> -->
	</div>
	<!-- <div class="author_pl">
		<span id="download"><img height="19" src="/test/helen/add3.png" /></span>
	</div> -->
</div>
<div id="main">
<div id="main_a">
	<div class="layer_1">
		<span class="showbtn" id="playButton"><img width="100" id="buttonPlay" height="100" src="/test/helen/6.png" /></span>
		<img width="100%" style="display:block;margin:0;padding:0;" id="bgImg" src="<?php echo $works["data"]["cover"];?>" />
		<span class="zhezhao" id="zhezhao"><img width="100%" height="100%" src="zhezhao.png" /></span>
	</div>
	<div class="layer_2">
		<div class="keyws">
		<?php
		foreach($works["data"]["tags"] as $key=>$item){
			switch ($item) {
				case "音#乐":
					$item="音乐";
					break;
				case "话#题":
					$item="话题";
					break;
				case "谈#话":
					$item="谈话";
					break;
				case "点#评":
					$item="点评";
					break;
				case "读#书":
					$item="读书";
					break;
				case "记#录":
					$item="记录";
					break;
				default:
					break;
			}
			echo '<a href="http://pillele.cn/playlist.php?topic='.$item.'" style="cursor:pointer;margin-top:5px;">'.$item.'</a>';
		}
		?>
		</div>
		<div style="clear:both;"></div>
		<div id="danmu">
			<div id="danmu_1" style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_2"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_3"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_4"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_5"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_6"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_7"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
			<div id="danmu_8"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
		</div>
	</div>
	<div class="layer_3" id="layer_3" style="width:100%;clear:both;">
		<div class="tit_bg" style="width:100%;">

			<div class="tit_muis" style="position:relative;"><img style="display:none;" width="100%" height="100%" src="/test/helen/5.png"></div>

				<div class="tit_muis" style="position:absolute;bottom:-255px;position:relative;width:50%;height:120px;margin-right:50%;overflow:hidden;">
					
					<div id="boxingdown" style="position:absolute;left:100%;height:42px;clear:both;top:31px;white-space:nowrap; overflow:hidden;">
					<?php foreach ($peaks['peaks'] as $k => $v) {?>
					<div style="float:left;height:42px;display: inline-block;white-space:nowrap; ">
					<img style="display: inline-block;float:left;margin-left:3px;white-space:nowrap; " width="3" height="<?php echo $v*0.6;?>" src="/test/helen/bo.png" />
					</div>
					<?php }?>
					</div>
				</div>

				<div class="tit_muis" style="position:absolute;bottom:-113px;position:relative;width:50%;height:120px;margin-left:50%;overflow:hidden;">
					<div id="boxingup" style="position:absolute;left:-0%;height:84px;overflow:hidden;top:10px;">
					<?php foreach ($peaks['peaks'] as $k => $v) {?>
					<div style="float:left;height:84px;line-height:84px;vertical-align:middle;">
					<img style="margin-left:3px;vertical-align:middle;" width="3" height="<?php echo $v*2*0.6;?>" src="/test/helen/bo2.png" />
					</div>
					<?php }?>
					</div>
					
				</div>
				<div id="positiona" style="position:absolute;position:relative;bottom:-53px;margin-left:52%;left:0%;">
					<div  class="breathb sizeb2" style="position:absolute;width:8px;height:8px;border:1px solid #ffffff;background:blue;border-radius:5px;float:left;"></div>
					
				</div>
			
				<div style="position:absolute;bottom:-30px;position:relative;width:100%;height:120px;overflow:hidden;">
					<div id="positionc" style="position:absolute;left:-0%;height:9px;overflow:hidden;top:10px;margin-left:50%;">
					<?php $aaa=count($peaks['peaks'])/$works["data"]["duration"]*6;
						foreach ($works["data"]["texts"] as $kw => $vw) {
						if($kw>0){
								$he = $vw['timeline']*$aaa-$hehe;
								$hehe = $vw['timeline']*$aaa+5;
						}else{ 
							$he = ($vw['timeline'])*$aaa;
							$hehe = $he+10;
						}
						?>
					<div  class="breathb sizeb2" style="float:left;height:8px;height:8px;display:block;">
					<img  style="display:block;margin-left:<?php echo $he;?>px;border:1px solid #ffffff;border-radius:5px;" width="8" height="8" src="/test/helen/bo3.png" />
					</div>
					<?php }?>
					</div>

					<div id="positiond" style="position:absolute;left:-0%;height:9px;overflow:hidden;top:23px;margin-left:50%;">
					<?php $aaat=count($peaks['peaks'])/$works["data"]["duration"]*6;
						foreach ($works["data"]['timeline'] as $kwt => $vwt) {
						if($kwt>0){
								$het = $vwt*$aaat-$hehet;
								$hehet = $vwt*$aaat;
					?>
					<div  class="breathb sizeb2" style="float:left;height:8px;height:8px;display:block;">
					<img  style="display:block;margin-left:<?php echo $het;?>px;border:1px solid #ffffff;border-radius:5px;" width="8" height="8" src="/test/helen/bo4.png" />
					</div>
					<?php
						}else{ 
							$het = $vwt*$aaat;
							$hehet = $het;
						}
						?>
					
					<?php }?>
					</div>
				</div>

			<div class="tit_info" id="texts">
				
			</div>
			<div class="tit_time">
				<span><font id="show_time">00'00'</font> | <?php echo $duration;?></span>
			</div>
			<?php if(!empty($works["data"]["location"])){?>
			<div id="positionb" class="tit_intro" style="position:absolute;bottom:32px;background:#98999b;font-size:14px;height:22px;line-height:22px;width:auto;color:#fff;padding:0 5px;margin-left:50%;">
			
				位置：<?php echo $works["data"]["location"];?>
				
			<!--?php
				for ($i = 0; $i < count($works['data']['persons']); $i++) {
					echo "<span>".$works['data']['persons'][$i]["key"].":".$works['data']['persons'][$i]["name"]."</span>";
				}
				?-->
				</div>
				<?php }?>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
<!--div style="width:100%;border-top:1px solid #D9D9D9;margin-top:-50px;""-->
</div>
<div id="download" style="background:#f3f3f3;width:100%;position:fixed;bottom:0px;z-index:9999;" >
<img width="100%" src="/test/helen/bt.jpg">
</div>
<!-- <div style="align:center;cursor:pointer;width:95%;font-size:45px;color:#FFF;background:#990000;border: solid red;MARGIN-RIGHT: auto; MARGIN-LEFT: auto;text-align:center;" id="download">下载</div> -->
</div>
<div id="loading" style="z-index: 10000;position: fixed;top:0;width:100%;height:100%;background:#000;padding-left:25%;padding-right:25%;padding-top:46%;">   
<img class="breath size2" src="/test/helen/loading2.png"  alt="loading.." />  
</div> 
<div id="author" style="position:absolute;bottom:68px;height:30px;padding-left:10px;width:97%;">
	<!-- <div class="author_n">
		<span><img width="40" height="40" src="<?php echo $works["data"]["user"]["avatar"];?>" /></span>
		<span class="name">&nbsp;<?php echo $works["data"]["user"]["username"];?></span>
	</div> -->
	<div class="author_pl" style="width:100%;">
		<span style="margin-left:8px;" style="display:block;float:left;"><img width="15" height="15" src="/test/helen/3_1.jpg" /></span>
		<span class="num" style="display:block;float:left;line-height:18px;">&nbsp;<?php echo $works["data"]["love_count"];?></span>
		<span style="display:block;float:left;"><img width="14" height="14" src="/test/helen/4_1.jpg" /></span>
		<span style="display:block;float:left;line-height:18px;">&nbsp;<font color="#999999"><?php echo $comment["meta"]["count"];?></font></span>
		<?php if(!empty($works["data"]["price"])!=0){?>
		<span style="display:block;height:22px;padding:0px 5px;font-size:22px;line-height:17px;float:right;color:#000;font-weight:900;"><?php echo $works["data"]["price"];?><font style="font-size:14px;">元</font></span>
		<?php }?>
	</div>
</div>
<script>
$(function(){
	//if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
	//	$("#download").show();
	//} else if (navigator.userAgent.match(/android/i)) {
	//	$("#download").hide();
	//};
	var lay1w=$('#main_a .layer_1').innerWidth()+"px";
	$('#main_a .layer_1').css('height',lay1w);
	$("#download").click(function(){
		var ua = navigator.userAgent.toLowerCase();
		if (ua.match(/MicroMessenger/i) == "micromessenger"){
			//$(".layer_1_1").show();
			if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
				$(".layer_1_1").show();
			} else if (navigator.userAgent.match(/android/i)) {
				$(".layer_1_2").show();
			}
		}else if (ua.match(/weibo/i) == "weibo"){
			//$(".layer_1_1").show();
			if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
				$(".layer_1_1").show();
			} else if (navigator.userAgent.match(/android/i)) {
				$(".layer_1_2").show();
			}
		} else if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
			window.location = "http://itunes.apple.com/app/id991508808";
		} else if (navigator.userAgent.match(/android/i)) {
    		var work_id=<?php echo $_GET['id'];?>;
    		//window.location = "http://pillele.cn/play.php?play=play&id="+work_id;
			window.location = "http://fir.im/s35A";
		    //var state = null;
		    //try {
		      //state = window.open("apps custom url schemes ", '_blank');
		    //} catch(e) {}
		    //if (state) {
		    //  window.close();
		    //} else {
		    //  window.location = "要跳转的页面URL";
		    //}
  	}
	});
	function formatTime(second){
		return ([parseInt(second / 60),second % 60].join("'")+"'").replace(/\b(\d)\b/g, "0$1");
	};
	$("#danmu").css("height",(screen.width*0.8)+"px");
	var i=0;
	var ii=0;
	var video=document.getElementById("video1");
	setInterval(function(){
		var texts=<?php echo json_encode($works["data"]["texts"]);?>;
		var image=<?php echo json_encode($works["data"]["images"]);?>;
		var timeline=<?php echo json_encode($works["data"]["timeline"]);?>;
		var bgimg=document.getElementById("bgImg");
		var textshow=document.getElementById("texts");
		var showTime=document.getElementById("show_time");
		if(texts!=""){
			if(parseInt(video.currentTime)==texts[i]['timeline']){
				textshow.innerHTML="<span>"+texts[i]['content']+"</span>";
				if(i<(texts.length-1)){
					i++;
				}
			}
		};
		if(parseInt(video.currentTime)==timeline[ii]){
			bgimg.src=image[ii];
			if(ii<(timeline.length-1)){
				ii++;
			}
		};
		showTime.innerHTML=formatTime(parseInt(video.currentTime));
	},1000);
	var start=0;
	var comment=<?php echo json_encode($comment["data"]);?>;
	$("#buttonPlay").click(function(){
		document.getElementById('video1').play();
		if(document.getElementById('video1').currentTime==0){
			//var boxingup = "<?php echo count($peaks['peaks'])*6+3;?>";
			boxingstop();
			$("#boxingup").css("left","0%");
        	$("#positiona").css("left","0%");
        	$("#positionb").css("left","0px");
        	$("#positionc").css("left","0%");
        	$("#positiond").css("left","0%");
        	$("#boxingdown").css("left","100%");
		}
		if(comment!=null){
			if(start==0){
				for (iii = 0; iii < comment.length; iii++) {
					 //tangmu("<img src='"+comment[iii]["avatar"]+"' width='15px'>:"+comment[iii]["content"],iii);
					 tangmu("<img src='"+comment[iii]["avatar"]+"' width='23px' style='position:absolute;margin:0;margin-left:0px;margin-top:0px;margin-bottom:0px;'>&nbsp;&nbsp;&nbsp;&nbsp;:"+comment[iii]["content"],iii);
				}
				start++;
			}else{
				for (iii = 0; iii < si.length; iii++) {
				 tangmu1(iii);
				}
			}
		}
		$("#playButton").hide();
		boxing();
	});
	setInterval(function(){
		if(document.getElementById('video1').ended){
			$("#playButton").show();
		}
	},10);
	$("#bgImg").click(function(){
		$('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
		// alert(1);
		boxingstop();
	});
	$("#danmu").click(function(){
		// $('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
		// alert(2);
		boxingstop();
	});
	$("#layer_3").click(function(){
		// $('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
		// alert(2);
		boxingstop();
	});
	
	
	var si=new Array();
	var x=new Array();
	function tangmu(text,j){
		//var textStyle="<span id=\"textStyle"+j+"\">"+text+"</span>";
		var textStyle="<span id=\"textStyle"+j+"\" style='display:inline-block;position:relative;margin-left:10px;width:1000px;width:auto;word-break:keep-all; white-space:nowrap'>"+text+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
		// var mathHeight = Math.round(Math.random()*$('#danmu').innerWidth()*0.30)+"px";
		// alert(j);
		var mathHeight = '5px';
		var jj = 1;
		// if(j>5){
		// 	jj = 2;
		// }else if(j>8){
		// 	jj = 3;
		// }else{
		// 	jj = 1;
		// }
	  	// var textLeft=$('#danmu').innerWidth()*jj+"px";
        var suiji =  Math.floor(Math.random() * 7 + 1);
        // alert(suiji);
	  	var textLeft=$('#danmu').innerWidth()+"px";
	  	if($('#danmu_'+suiji).html()==""){
	  		var textLeftb=Math.floor(Math.random() * 7 + 1)*10+"px";
	  		$('#danmu_'+suiji).css("padding-left",textLeftb);
	  	}
		$('#danmu_'+suiji).html($('#danmu_'+suiji).html()+textStyle);
		$("#textStyle"+j).css("left",textLeft);
		$("#textStyle"+j).css("top",mathHeight);
		x[j]=parseInt($("#textStyle"+j).css("left"));
	  si[j] = setInterval(function(){
	  	x[j]=parseInt($("#textStyle"+j).css("left"));
	    document.getElementById("textStyle"+j).style.left=x[j];
	    x[j]-=1;
	    $("#textStyle"+j).css("left",x[j]+"px");
	},0.1);
	};
	function tangmu1(j){
		si[j] = setInterval(function(){
	  x[j]=parseInt($("#textStyle"+j).css("left"));
	  document.getElementById("textStyle"+j).style.left=x[j];
	  x[j]-=1;
	  $("#textStyle"+j).css("left",x[j]+"px");
	},0.1);
	};
});
</script>

<script>
var i = 0;
var miao = '<?php echo $works["data"]["duration"]*10;?>';
var boxingup = "<?php echo count($peaks['peaks'])*6+3;?>";
var kuan = $('.layer_3').width();
var b = kuan/2;
var t;
var sudu = boxingup/miao;
var video=document.getElementById("video1");
function boxing() {
    t=setTimeout(function () {
	    i++;
        if ((i*sudu) < boxingup) {
        	$("#boxingup").css("left","-"+(i*sudu)+"px");
        	$("#positiona").css("left","-"+(i*sudu)+"px");
        	$("#positionb").css("left","-"+(i*sudu)+"px");
        	$("#positionc").css("left","-"+(i*sudu)+"px");
        	$("#positiond").css("left","-"+(i*sudu)+"px");
        	if((i*sudu)>=b){
        		var pp = (i*sudu)-b;
	        	$("#boxingdown").css("left","-"+pp+"px");
	        }else{
	        	var p = b-(i*sudu);
	        	$("#boxingdown").css("left",p+"px");
	        }
	        i=parseInt(video.currentTime*10);
            boxing();
        }
    }, 100);
}
function boxingstop() 
{
	i=parseInt(video.currentTime*10);
	clearTimeout(t);
} 
</script>
</body>
</html>
<?php
 }else{
 	header("location:http://pillele.cn/pcplay.php?id=".$_GET["id"]);
 }
 ?>