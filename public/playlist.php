<?php
if(!empty($_GET["topic"])){
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
$i=1;
$works=json_decode(fgc("http://soundlab.com/api/work/search?q=".$_GET["topic"]."&by=tag&p=".$i),1);
//echo $works["meta"]["total"];exit;
// http://pillele.cn/play.php?id=xxxx
for($i;$i<=$works["meta"]["pages"];$i++){
	$a=json_decode(fgc("http://soundlab.com/api/work/search?q=".$_GET["topic"]."&by=tag&p=".$i),1);
	foreach($a["data"] as $item){
		$work[]=$item;
	}
	//print_r($a["data"]);echo "<br><br>";
	unset($a);
}
// print_r($work);
}
?>
<!DOCTYPE html>    
<html>
<head>
<title><?php echo $_GET["topic"];?> | 声音实验室</title>
<meta charset="utf-8" >
<meta http-equiv="Content-Language" content="zh-CN"></meta>
<meta content="telephone=no" name="format-detection">
<meta name='apple-itunes-app' content='app-id=id991508808'>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
<script src="js/jquery.min.js"></script> 
<script  src="js/jquery.danmu.js"></script>
<style>
@charset "utf-8";
body,div,a,span,img,input,form,ul,li,dl,dt,dd{margin:0;padding:0;list-style-type: none;}
body{font-family:'Microsoft YaHei';background:#ffffff;background-size:100%;}
a,a:visited{color:#000;text-decoration:none;}
a:hover,a:visited{text-decoration:none;}

body{width: 100%;height: 100%;}
.pltop{
	width: 100%;
	margin: auto;
	text-align: center;
	height: auto;
	padding-bottom: 8px;
	border-bottom:1px solid #e8e8e8;
}
.layer_1_1 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_1 .showbtn_1{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_2 .showbtn_2 img{max-width: 100%; height: auto;}
.layer_1_2 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_2 .showbtn_2{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_1 .showbtn_1 img{max-width: 100%; height: auto;}
.pltop a{
	display: block;
	width: 100%;
	height:30px;
	font-weight: 900;
	font-size: 24px;
	text-align: center;
	margin: 15px 0 0 0;
	color: #000000;
	
}
 .pltopa {
 	min-height:76px;
 	height: auto;
 	border-bottom:1px solid #e8e8e8;
 	position: relative;
 }
 .pltopa .pltl{
 	width: 100%;
 	float: left;
 	min-height:76px;
 	height: auto;
 }
 .pltopa .pltl p{
  	padding:10px 0 10px 3%;
  	line-height: 22px;
  	margin: 0;
  	min-height:76px;
 	height: auto;
 	font-size: 14px;
  }
 .pltopa .pltr{
 	width: 20%;
 	float: left;
 	text-align: center; 
 	position: absolute;
 	right: 1%;
 	/*top:20%;*/

 }
.pltop span{
	font-weight: none;
	font-size: 14px;
	color: #7d7d7d;
	text-align: center;
}
.plist ul li{
	display:block;
	float:left;
	background:#ffffff;
	width:45.5%;
	margin-left: 3%;
	margin-top:10px;
}
.plist ul li .plimg{
	float: left;
	/*width: 18%;*/
	width: 100%;
	text-align: left;
}
.plist ul li .plimg img{
	
	
}
.plist ul li .plinfo{
	float: left;
	width:90%;
	padding-left: 5%;
}
.plist ul li .plinfo a{
	display: inline-block;
	/*margin-top: 5px;*/
	font-size: 14px;
	line-height: 24px;
	height: 50px;
	/*overflow: hidden;*/
	/*display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;*/
}
.plist ul li .plinfo span{
	display: inline-block;
	width: 100%;
	color: #acacac;
	text-align: right;
	height: 20px;line-height: 20px;
	font-size: 14px;
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
<script type="text/javascript">
$(window).load(function(){ 
	setTimeout('$("#loading").hide();',2000); 
	
	var mathHeight3 = $('＃titms').innerHeight()+26;
    var mathHeight2 = $('.pltr').innerHeight()*0.5;
    var mathHeight = ($('#pltopa').innerHeight()*0.5-mathHeight2+mathHeight3)+"px";
   
    $(".pltr").css("margin-top",mathHeight);
}) 
</script>
</head>
<body>
<?php if(!empty($works["meta"]['detail'])){?>
<div class="pltopa" id="pltopa">
	<div class="pltl">
		<p style="font-size:14px;color:#6b6b6b;">
		<span style="display:block;height:4px;width:100%;clear:both;"></span>
		<span style="color:#000000;font-size:18px;">#<?php echo $_GET["topic"];?>#<span id="download" style="float:right;padding-right:3%;"><a href="javascript:;"><img height="16px" style="padding-top:2px;"  src="/test/helen/add2.png" /></a></span></span>
		<span style="display:block;height:8px;width:100%;clear:both;"></span>
		<?php echo $works["meta"]['detail'];?>
		</p>
	</div>
	<!-- <div class="pltr" id="download">
		<a href="javascript:;"><img width="40%"  src="/test/helen/add.png" /></a>
		<span style="font-size:12px;color:#7d7d7d;clear:both;display:block;">共 <?php echo $works["meta"]["total"]>0?$works["meta"]["total"]:0;?> 条</span>
		<br>
	</div> -->
	<div style="clear:both;"></div>
</div>
<?php }else{?>
<div class="pltop" id="download" >
	<a href="javascript:;" ><img width="130" src="/test/helen/i.png" /></a>
	<span>共 <?php echo $works["meta"]["total"]>0?$works["meta"]["total"]:0;?> 条</span>
</div>
<?php }?>
<div class="plist" style="background:#f6f6f6;">
	<ul>
	<?php foreach($work as $v){?>
		<li onclick="javascript:window.location.href='http://pillele.cn/play.php?id=<?php echo $v['id'];?>'" >
			<div class="plimg" ><img width="100%" src="<?php echo $v['cover'];?>" /></div>
			<div class="plinfo">
				<a href="http://pillele.cn/play.php?id=<?php echo $v['id'];?>"><?php echo $v['title'];?></a>
				<span>
				<img width="20" style="display:inline-block;margin:0;padding:0;margin-left:-5px;float:left;" src="/test/helen/play_gray_button@3x.png" />
				<font style="height:20px;text-align:left;line-height:22px;display:inline-block;float:left;"><?php echo $v['play_count'];?>&nbsp;</font>
				
				<img width="20" style="display:inline-block;margin:0;padding:0;float:left;" src="/test/helen/love_gray_button@3x.png" />
				<font style="height:20px;text-align:left;line-height:22px;display:inline-block;float:left;"><?php echo $v['love_count'];?></font>
				
				<!--?php echo strtoupper(date('M',strtotime($v['created_at'])));?--> <!--?php echo date('d',strtotime($v['created_at']));?--> <!--?php echo date('Y',strtotime($v['created_at']));?--> 
				</span>
			</div>	
		</li>
	<?php }?>	
		
	</ul>
	<div style="clear:both;height:70px;"></div>
</div>
<div class="layer_1_1" onclick="$('.layer_1_1').hide();">
		<span class="showbtn_1"><img src="/ios.png" /></span>
</div>
<div class="layer_1_2" onclick="$('.layer_1_2').hide();">
		<span class="showbtn_2"><img src="/android.png" /></span>
</div>
<div style="cursor:pointer;width:100%;position:fixed;bottom:0px;background:#000;margin-bottom:-3px;" id="downloadb">
<img width="100%" src="/test/helen/bt.jpg">
</div>
<!--div style="align:center;cursor:pointer;width:95%;font-size:45px;color:#FFF;background:#990000;border: solid red;MARGIN-RIGHT: auto; MARGIN-LEFT: auto;text-align:center;" id="download">下载</div-->
</div>
<div id="loading" style="z-index: 10000;position: fixed;top:0;width:100%;height:100%;background:#000;padding-left:25%;padding-right:25%;padding-top:46%;">   
<img class="breath size2" src="/test/helen/loading2.png"  alt="loading.." />  
</div> 
</body>

</html>
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
    		// var work_id=<?php echo $_GET['id'];?>;
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

	$("#downloadb").click(function(){
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
    		// var work_id=<?php echo $_GET['id'];?>;
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

	
});
</script>
