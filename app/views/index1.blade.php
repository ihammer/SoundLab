<!DOCTYPE html>
<html>
<head>
<title>声音实验室-<?php echo $works["data"]["title"];?></title>
<meta charset="utf-8" >
<meta http-equiv="Content-Language" content="zh-CN"></meta>
<meta content="telephone=no" name="format-detection">
<meta name='apple-itunes-app' content='app-id=id991508808'>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
<style>
@charset "utf-8";
body,div,a,span,img,input,form{margin:0;padding:0;}
body{font-family:'Microsoft YaHei';background:#ffffff;background-size:100%;}
a,a:visited{color:#fff;}
a:hover,a:visited{text-decoration:none;}

#main #main_b{width:100%;position:absolute;margin-bottom:1px;z-index:99;}
#main_b input{width:100%;height:50px;background:#98999b;border:0;border-radius:0;font-size:18px;padding-left:10px;padding-top:5px;}
.layer_1_1 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_1 .showbtn_1{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_2 .showbtn_2 img{max-width: 100%; height: auto;}
.layer_1_2 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_2 .showbtn_2{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_1 .showbtn_1 img{max-width: 100%; height: auto;}
#main{position:relative;}
#main_a{position:relative;margin-bottom:50px;}
#main_a .layer_1{position:relative;width:100%;}
#main_a .layer_1 .showbtn{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:99%; filter:alpha(opacity=60); -moz-opacity:0.6; -khtml-opacity: 0.6; opacity: 0.6; }
#main_a .layer_1 .showbtn img{margin-top:100px;}
#main_a .layer_1 .zhezhao {position:absolute;left:0;top:0;z-index=9990;text-align:center;width:100%}
#main_a .layer_2{position:absolute;left:0;top:0;z-index:9;width:100%;}
#main_a .layer_2 .keyws{padding:5px;}
#main_a .layer_2 .keyws a{display:block;font-size:14px;text-decoration:none;padding:5px;border:1px solid #fff;color:#fff;float:left;margin-left:5px;}
#main_a .layer_2 .scroll{width:100%;height:100px;padding-top:20px;}
#main_a .layer_2 .scroll .scr_1{height:30px;background:#000000;color:#fff;clear:both;}
#main_a .layer_2 .scroll .scr_1 span{font-size:14px;float:left;line-height:30px;}
#main_a .layer_3{position:absolute;left:0;bottom:-20px;z-index:9;}
#main_a .layer_3 .tit_bg{position:relative;}
#main_a .layer_3 .tit_bg .tit_info{position:absolute;left:0;bottom:30px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_info span{display:block;background:#000;color:#fff;font-size:16px;width:150px;padding:5px 8px;}
#main_a .layer_3 .tit_bg .tit_time{position:absolute;right:10px;bottom:5px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_time span{font-size:12px;}
#main_a .layer_3 .tit_bg .tit_intro{position:absolute;left:0;bottom:-20px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_intro span{background:#98999b;padding:5px 8px;font-size:12px;color:#fff;}
#main_a .layer_3 .tit_bg .tit_muis{min-weight:500px;width:100%;height:55px;clear:both;}
#author{margin-top:0px;height:100px;overflow:hidden;}
#author .author_n{float:left;padding-left:5px;}
#author .author_pl{float:right;padding-right:10px;padding-top:10px;}
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
}
#iSlider-effect-wrapper {
height: 720px;
width: 540px;
margin: 0;
margin-top:1%;
background: url('test/bg_1.png') no-repeat top center;
background-size: 100%;
overflow: hidden;
position: relative;
}
#animation-effect {
border: 0;
width: 289px;
height: 497px;
background-color: #FFFFFF;
margin-top: 95px;
}
.iSlider-effect {
overflow: hidden;
position: relative;
margin: 0;
margin-left:126px;
border: 1px solid #FFFFFF;
}
#qr {
text-align:center;
margin:0;
margin-left:20%;
margin-top:12%;
}
</style>
<script src="js/jquery.min.js"></script> 
<script  src="js/jquery.danmu.js"></script>
</head>
<body>
<div style="display:none;"><img width="257px" height="257px" src="<?php echo $works["data"]["cover"];?>" /></div>
<div style="display:none;">
	<audio src="<?php echo $tmpfile["tmpfile"];?>" preload="true" id="video1" hidden></audio>
</div>
<div id="qr" style="float:left;text-align:center;">
	<div style="text-align:center;"><font style="font-size:40px">Welcome To SoundLab</font><br><font style="font-size:40px">欢迎来到声音实验室</font><br><font style="font-size:40px">ようこそ声実験室</font><br><br></div>
	<div id="qrios" style="float:left;text-align:center;">
		<img src="test/ios.png" width="200px">
		<br><a style="color:#000;text-decoration:none;" href="http://itunes.apple.com/app/id991508808"><font style="font-size:18px">iPhone下载地址</font></a>
	</div>
	<div id="qrandroid" style="float:right;text-align:center;">
		<img src="test/android.jpg" width="200px">
		<br><a style="color:#000;text-decoration:none;" href="http://pkg.fir.im/1b10e9dc8e5381a777f9427a3b23f4f93da86c98.apk?attname=soundPillCopy-201511161528.apk_1.0.0.apk&e=1447838929&token=LOvmia8oXF4xnLh0IdH05XMYpH6ENHNpARlmPc-T:xc3NMvblZzsWUuek9fjvG4daSto="><font style="font-size:18px">Android下载地址</font></a>
	</div>
</div>
<div id="iSlider-effect-wrapper" style="float:left;">
    <div id="animation-effect" class="iSlider-effect">
    	
		<div id="main">
			<div id="main_a">
				<div class="layer_1">
					<span class="showbtn" id="playButton"><img width="100" id="buttonPlay" height="100" src="/test/helen/6.png" /></span>
					<img width="100%" height="100%" id="bgImg" src="<?php echo $works["data"]["cover"];?>" />
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
							case "买#卖":
								$item="买卖";
								break;
							case "其#他":
								$item="其他";
								break;
							case "段#子":
								$item="段子";
								break;
							default:
								break;
						}
						echo '<a style="cursor:pointer;margin-top:5px;">'.$item.'</a>';
					}
					?>
					</div>
					<div style="clear:both;"></div>
					<div id="danmu"></div>
				</div>
				<div class="layer_3">
					<div class="tit_bg">
						<div class="tit_muis"><img width="100%" height="100%" src="/test/helen/5.png"></div>
						<div class="tit_info" id="texts">
							
						</div>
						<div class="tit_time">
							<span><font id="show_time">00'00'</font> | <?php echo $duration;?></span>
						</div>
						<div class="tit_intro">
							<?php
							for ($i = 0; $i < count($works['data']['persons']); $i++) {
								echo "<span>".$works['data']['persons'][$i]["key"].":".$works['data']['persons'][$i]["name"]."</span>&nbsp;";
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>
			<div id="author">
				<div class="author_n" style="float:left;">
					<span><img width="40" height="40" src="<?php echo $works["data"]["user"]["avatar"];?>" /></span>
					<span class="name" style="width:100px;height:40px;overflow:hidden;">&nbsp;<?php echo $works["data"]["user"]["username"];?></span>
				</div>
				<div class="author_pl" style="float:right;">
					<span><img width="15" height="15" src="/test/helen/3.png" /></span>
					<span class="num">&nbsp;<?php echo $works["data"]["play_count"];?></span>
					<span><img width="15" height="15" src="/test/helen/4.jpg" /></span>
					<span>&nbsp;<?php echo $comment["meta"]["count"];?></span>
				</div>
			</div>
		</div>
		<div id="main_b">
				<input type="text" placeholder="输入弹幕..." readonly />
			</div>
	</div>
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
			//$(".layer_1_1").show();
			if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
				$(".layer_1_1").show();
			} else if (navigator.userAgent.match(/android/i)) {
				$(".layer_1_2").show();
			}
		} else if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
			window.location = "http://itunes.apple.com/app/id991508808";
		} else if (navigator.userAgent.match(/android/i)) {
    		var work_id=<?php echo $play_id;?>;
    		//window.location = "http://pillele.cn/play.php?play=play&id="+work_id;
			window.location = "http://fir.im/soundLab";
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
	$("#danmu").css("height","215px");
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
		if(parseInt(video.currentTime)==timeline[ii]){
			bgimg.src=image[ii];//alert(image[ii]);
			if(ii<(timeline.length-1)){
				ii++;
			}
		}
		}
		showTime.innerHTML=formatTime(parseInt(video.currentTime));
	},1000);
	var start=0;
	var comment=<?php echo isset($comment["data"]) ? json_encode($comment["data"]) : null;?>;
	$("#buttonPlay").click(function(){
		document.getElementById('video1').play();
		if(comment!=null){
			if(start==0){
				for (iii = 0; iii < comment.length; iii++) {
					 tangmu("<img src='"+comment[iii]["avatar"]+"' width='23px' style='position:absolute;margin:0;margin-left:1px;margin-top:1px;margin-bottom:0px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+comment[iii]["content"],iii);
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
		$('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
	});
	
	var si=new Array();
	var x=new Array();
	function tangmu(text,j){
		var textStyle="<span id=\"textStyle"+j+"\" style='position:relative'>"+text+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
		mathHeight = Math.round(Math.random()*289*0.60)+"px";
	  var textLeft=$('#danmu').innerWidth()+Math.round(Math.random()*289)+"px";
		$('#danmu').html($('#danmu').html()+textStyle);
		$("#textStyle"+j).css("left",textLeft);
		$("#textStyle"+j).css("top",mathHeight);
		x[j]=parseInt($("#textStyle"+j).css("left"));
	  si[j] = setInterval(function(){
	  	x[j]=parseInt($("#textStyle"+j).css("left"));
	    document.getElementById("textStyle"+j).style.left=x[j];
	    x[j]-=1;
	    $("#textStyle"+j).css("left",x[j]+"px");
	},1);
	};
	function tangmu1(j){
		si[j] = setInterval(function(){
	  x[j]=parseInt($("#textStyle"+j).css("left"));
	  document.getElementById("textStyle"+j).style.left=x[j];
	  x[j]-=1;
	  $("#textStyle"+j).css("left",x[j]+"px");
	},1);
	};
});
</script>
</body>
</html>