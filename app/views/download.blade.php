<!DOCTYPE html>    
<html>
<head>
<title>声音实验室</title>
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
a,a:visited{color:#fff;text-decoration: none;}
a:hover,a:visited{text-decoration:none;}
input[placeholder], [placeholder], *[placeholder] { 
color:#000000 !important; 
font-size: 18px;
} 
ul,li{list-style-type:none;}

</style>
</head>
<body>
<div id="show" onClick="hidesafri()" style="height:0;width:100%;background:#515556;overflow:hidden;">
<img src="/test/helen/safri.png" width="100%">
</div>
<div style="width:100%;margin:0 auto;text-align:center;margin-top:20%;clear:both;"><img src="/test/helen/logo.png" width="50%" /></div>
<div style="width:70%;margin:0 auto;text-align:center;margin-top:30px;clear:both;height:10px;border-top:1px solid #a9b1b3;line-height:24px;padding-top:20px;color:#a9b1b3;font-size:14px;font-family:'Microsoft YaHei';">
	声音实验室是一款基于录制，并且能够为声音添加插图，字幕和“价格”的新型社交应用<br><br><br>
	<a href="javascript:;" id="download" style="font-family:'Microsoft YaHei';border:3px solid #000000;color:#000000;font-size:20px;padding:5px 30px;">下载安装</a>
</div>
</body>
<script type="text/javascript">
	$("#download").click(function(){
		var ua = navigator.userAgent.toLowerCase();
		if (ua.match(/MicroMessenger/i) == "micromessenger"){
			$("#show").animate({height:150},"slow");
		}else if (ua.match(/weibo/i) == "weibo"){
			$("#show").animate({height:150},"slow");
		} else if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
			window.location = "http://itunes.apple.com/app/id991508808";
		} else if (navigator.userAgent.match(/android/i)) {
			window.location = "http://fir.im/s35A";
  		}
	});
	function hidesafri(){
		
		$("#show").animate({height:0},"slow");
		// $('#show').hide();
	}
</script>
</html>