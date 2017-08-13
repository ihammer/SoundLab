<?php
//if( (isset($_GET["play"]) && $_GET["play"]=="play") || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false ) {
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
$works=json_decode(fgc("http://123.57.1.143/api/work/".$_GET["id"]."/show"),1);
//$peaks=json_decode(file_get_contents($works["links"]["waveform"]),1);//print_r($peaks);exit;
foreach($works["data"]["tags"] as $key=>$val){
	if($val!="拜年" && $val!="马上鹿" && $val!="其它" && $val!="恶搞" && $val!="情人节"){
		$title=$val;
	}
}
$comment=json_decode(fgc("http://123.57.1.143/api/comment/".$_GET["id"]."/show"),1);
$tmpfile=json_decode(fgc("http://123.57.1.143/api/work/".$_GET["id"]."/tmpfile"),1);
foreach($works["data"]["texts"] as $key => $item){
	$works["data"]["texts"][$key]["timeline"]=intval($item["timeline"]*$works["data"]["duration"]);
}
foreach($works["data"]["timeline"] as $key => $item){
	$works["data"]["timeline"][$key]=intval($item*$works["data"]["duration"]);
}
$duration=gmstrftime("%M'%S'",$works["data"]["duration"]);
?>
<!DOCTYPE html>    
<html>
<head>
<title><?php echo $title;?>|马上鹿</title>
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
#main_a{position:relative;margin-bottom:55px;background:#fae000;}
#main_a .layer_1{position:relative;width:100%;}
#main_a .layer_1 .showbtn{position:absolute;left:0;top:0;z-index:9999;text-align:center;width:100%;height:85%;}
#main_a .layer_1 .showbtn img{margin-top:30%;}
#main_a .layer_1 .zhezhao {position:absolute;left:0;top:0;z-index=9990;text-align:center;width:100%}
#main_a .layer_2{position:absolute;left:0;top:0;z-index:9;width:100%;}
#main_a .layer_2 .keyws{padding:5px;}
#main_a .layer_2 .keyws a{display:block;font-size:14px;line-height:13px;text-decoration:none;padding:2px 5px;border:1px solid #fff;color:#fff;float:left;margin-left:5px;}
#main_a .layer_2 .scroll{width:100%;height:100px;padding-top:20px;}
#main_a .layer_2 .scroll .scr_1{height:30px;background:#000000;color:#fff;clear:both;}
#main_a .layer_2 .scroll .scr_1 span{font-size:14px;float:left;line-height:30px;}
#main_a .layer_3{position:absolute;left:0;bottom:-19px;z-index:9;}
#main_a .layer_3 .tit_bg{position:relative;}
#main_a .layer_3 .tit_bg .tit_info{position:absolute;left:0;bottom:30px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_info span{display:block;background:#000;color:#fff;font-size:16px;width:150px;padding:5px 8px;}
#main_a .layer_3 .tit_bg .tit_time{position:absolute;right:10px;bottom:5px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_time span{font-size:12px;}
#main_a .layer_3 .tit_bg .tit_intro{position:absolute;left:0;z-index:9;}
#main_a .layer_3 .tit_bg .tit_intro span{dispaly:inline-block;float:left;height:29px;line-height:29px;background:#98999b;padding:0px 5px;font-size:12px;color:#fff;margin-right: 5px;margin-bottom: 3px;}
#main_a .layer_3 .tit_bg .tit_muis{min-weight:500px;width:100%;height:55px;clear:both;}
#author{padding-top:33px;height:100px;overflow:hidden;}
#author .author_n{float:left;padding-left:10px;}
#author .author_pl{float:right;padding-right:30px;padding-top:10px;}
#author .author_n span{float:left;font-size:16px;line-height:40px;}
#author .author_n img{display:block;overflow:hidden;}
#author .author_pl span{float:left;font-size:16px;line-height:20px;}
#author .author_pl .num{padding-right:20px;}
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
   margin:0;padding:0;overflow: hidden; 
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
</style>
</head>
<body>
<div style="display:none;text-align: center"><img width="80%" height="80%" src="<?php echo $works["data"]["cover"];?>" /></div>
<div class="layer_1_1" onclick="$('.layer_1_1').hide();">
		<span class="showbtn_1"><img src="/ios.png" /></span>
</div>
<div class="layer_1_2" onclick="$('.layer_1_2').hide();">
		<span class="showbtn_2"><img src="/android.png" /></span>
</div>
<div style="display:none;">
<audio src="<?php echo $tmpfile["tmpfile"];?>" preload="true" id="video1" hidden>    
</audio></div>
<div id="main">
<div id="main_a">
	<div class="layer_1" style="text-align: center">
		<span class="showbtn" id="playButton"><img width="60%" id="buttonPlay" height="60%" src="/test/helen/1.pic.jpg" /></span>
		<img width="70%" height="70%" id="bgImg" src="<?php echo $works["data"]["cover"];?>" style="border:2px solid #FFF;margin-top: 20%;margin-bottom: 20%" />
		<span style="position:absolute;text-align: right;top: 65%;right: 18%;"><font color="#FFF" size="15"><?php echo $works["data"]["duration"];?>''</font></span>
	</div>
	<div style="position:absolute;text-align: center;top: 85%;width:100%"><font color="#000" size="6px">&nbsp;&nbsp;马上鹿，马上录！<!--?php echo $title;?--></font></div>
</div>
<div style="clear:both;"></div>
<!--div style="width:100%;border-top:1px solid #D9D9D9;margin-top:-50px;""-->
</div>
<!--div style="cursor:pointer;width:80%;position:fixed;bottom:125px;left:18%"><font color="#AAA" size="5px">春晚拜年恶搞录音神器！</font></div-->
<div style="cursor:pointer;width:80%;position:fixed;bottom:90px;left:23%" id="mdownload"><img width="70%" src="/test/helen/load1.png"></div>
<div style="cursor:pointer;width:80%;position:fixed;bottom:30px;left:23%" id="download"><img width="70%" src="/test/helen/7_3.png"></div>
<!--div style="align:center;cursor:pointer;width:95%;font-size:45px;color:#FFF;background:#990000;border: solid red;MARGIN-RIGHT: auto; MARGIN-LEFT: auto;text-align:center;" id="download">下载</div-->
</div>
<script>
$(function(){
	//if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
	//	$("#download").show();
	//} else if (navigator.userAgent.match(/android/i)) {
	//	$("#download").hide();
	//};
	$("#download").click(function(){
		var ua = navigator.userAgent.toLowerCase();
		if (ua.match(/MicroMessenger/i) == "micromessenger"){
			if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
				$(".layer_1_1").show();
			} else if (navigator.userAgent.match(/android/i)) {
				$(".layer_1_2").show();
			}
		} else if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
			window.location = "http://itunes.apple.com/app/id991508808";
		} else if (navigator.userAgent.match(/android/i)) {
    		var work_id=<?php echo $_GET['id'];?>;
			window.location = "http://fir.im/s35A";
  	}
	});
	$("#mdownload").click(function(){
		var ua = navigator.userAgent.toLowerCase();
		if (ua.match(/MicroMessenger/i) == "micromessenger"){
			if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
				$(".layer_1_1").show();
			} else if (navigator.userAgent.match(/android/i)) {
				$(".layer_1_2").show();
			}
		} else if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
			window.location = "http://itunes.apple.com/app/id1078153352";
		} else if (navigator.userAgent.match(/android/i)) {
    		var work_id=<?php echo $_GET['id'];?>;
			window.location = "http://fir.im/s35A";
  	}
	});
	function formatTime(second){
		return ([parseInt(second / 60),second % 60].join("'")+"'").replace(/\b(\d)\b/g, "0$1");
	};
	$("#danmu").css("height",(screen.width*0.4)+"px");
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
	});
	$("#bgImg").click(function(){
		$('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
	});
	$("#danmu").click(function(){
		// $('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
	});
	
	var si=new Array();
	var x=new Array();
	function tangmu(text,j){
		//var textStyle="<span id=\"textStyle"+j+"\">"+text+"</span>";
		var textStyle="<span id=\"textStyle"+j+"\" style='position:relative'>"+text+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
		var mathHeight = Math.round(Math.random()*$('#danmu').innerWidth()*0.30)+"px";
		// var mathHeight = 10+"px";
		// var Arr = ["20","40"];  
		// var n = Math.floor(Math.random() * Arr.length + 1)-1;  
		// var mathHeight = Arr[n]+"px"; 

		// var jjarr = [1,2,3,3,4,5,6,7,8,9];
		// var mathHeights ＝ jjarr[Math.floor(Math.random()*jjarr.length)]+"px";
		var jj = 1;
		if(j>5){
			jj = 2;
		}else if(j>8){
			jj = 3;
		}else{
			jj = 1;
		}
	  	var textLeft=$('#danmu').innerWidth()*jj+"px";
		$('#danmu').html($('#danmu').html()+textStyle);
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
</body>

</html>