<?php
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false ) {
?>
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
#main_b input{width:100%;height:45px;background:#98999b;border:0;border-radius:0;font-size:18px;padding-left:10px;padding-top:0px;}
.layer_1_1 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_1 .showbtn_1{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_2 .showbtn_2 img{max-width: 100%; height: auto;}
.layer_1_2 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_2 .showbtn_2{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_1 .showbtn_1 img{max-width: 100%; height: auto;}
#main{position:relative;}
#main_a{position:relative;margin-bottom:75px;}
#main_a .layer_1{position:relative;width:100%;overflow: hidden;}
#main_a .layer_1 .showbtn{position:absolute;left:0;top:0;z-index:9996;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=60); -moz-opacity:0.6; -khtml-opacity: 0.6; opacity: 0.6; }
#main_a .layer_1 .showbtn img{margin-top:100px;}
#main_a .layer_1 .zhezhao {position:absolute;left:0;top:0;text-align:center;width:100%;overflow: hidden;height: 100%;}
#main_a .layer_2{position:absolute;left:0;top:0;z-index:9;width:100%;}
#main_a .layer_2 .keyws{padding:5px;}
#main_a .layer_2 .keyws a{display:block;font-size:14px;line-height:13px;text-decoration:none;padding:2px 5px;border:1px solid #fff;color:#fff;float:left;margin-left:5px;}
#main_a .layer_2 .scroll{width:100%;height:100px;padding-top:20px;}
#main_a .layer_2 .scroll .scr_1{height:30px;background:#000000;color:#fff;clear:both;}
#main_a .layer_2 .scroll .scr_1 span{font-size:14px;float:left;line-height:30px;}
#main_a .layer_3{position:absolute;left:0;bottom:-78px;z-index:9;}
#main_a .layer_3 .tit_bg{position:relative;}
#main_a .layer_3 .tit_bg .tit_info{position:absolute;left:0;bottom:90px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_info span{display:block;background:#000;color:#fff;font-size:16px;width:150px;padding:5px 8px;}
#main_a .layer_3 .tit_bg .tit_time{position:absolute;right:10px;bottom:60px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_time span{font-size:12px;}
#main_a .layer_3 .tit_bg .tit_intro{position:absolute;left:0;z-index:9;bottom:10px;}
#main_a .layer_3 .tit_bg .tit_intro span{dispaly:inline-block;float:left;height:29px;line-height:29px;background:#98999b;padding:0px 5px;font-size:12px;color:#fff;margin-right: 5px;margin-bottom: 3px;}
#main_a .layer_3 .tit_bg .tit_muis{min-weight:500px;width:100%;height:55px;clear:both;}
#author{margin-top:130px;
	margin-bottom: 10px;
	/*height:100px;*/
	/*height:101px;*/
	overflow:hidden;}
#author .author_n{float:left;padding-left:5px;}
#author .author_pl{float:right;padding-right:10px;padding-top:10px;}
#author .author_n span{float:left;font-size:16px;line-height:40px;}
#author .author_n img{display:block;overflow:hidden;}
#author .author_pl span{float:left;font-size:16px;line-height:20px;}
#author .author_pl .num{padding-right:8px;}
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
/*height: 497px;*/
height: 512px;
background-color: #FFFFFF;
/*margin-top: 95px;*/
margin-top: 80px;
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
margin-top:8%;
}
.jinruon{
	cursor: pointer;
	color:#fff;background:#df4c42;border:3px solid #df4c42;display:inline-block;width:307px;height:57px;margin-top:50px;line-height:53px;font-size:24px;text-decoration: none;
}
.jinruon:hover{
	text-decoration: none;
	color: #000000;
	background:#fff;
	border:3px solid #000000;
}
</style>
<script src="/js/jquery.min.js"></script> 
<script  src="/js/jquery.danmu.js"></script>
<script type="text/javascript">
$(function(){
	$('#jinruon').click(function(){
		$('#loginalert').show();
	});
});
</script>
<script type="text/javascript">
    function nokong(m){
        if ($.trim(m)=='') {
            return false;
        }else{
            return true;
        }
    }
    function moblie(n){
        var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
        if (reg.test(n)) {
            return true;
        }else{
            return false;
        }
    }
    function sublogin(){
        var mobile = $("#mobile").val();
        var pasw = $("#pasw").val();
        var mcheck = false;
        var mobilecheck = false;
        var paswcheck = false;
        mcheck = moblie(mobile);
        mobilecheck = nokong(mobile);
        paswcheck = nokong(pasw);
        


        if (mobilecheck==true && paswcheck==true && mcheck==true) {
            $.post('/sublogin',{m:mobile,n:pasw},function(msg){
                // alert(msg);
                if(msg>0){
                	$("#paswmsg").hide();
                    window.location.href="/home";
                }else{
                    $("#paswmsg td").html('<img width="12" height="12" src="zpc/images/3jiao.png" /> 密码与手机号不匹配！');
                }
            });
        }else{
        	$("#paswmsg td").html('<img width="12" height="12" src="zpc/images/3jiao.png" /> 密码与手机号不匹配！');
        }
        

        // if ($.trim(mobile)=='') {
        //     $("#mobilemsg").show();
        // }else{
        //     if (reg.test(mobile)) {
        //         $("#mobilemsg").hide();
        //         if($.trim(pasw)==''){
        //             $("#paswmsg").show();
        //         }else{
        //             $("#paswmsg").hide();
        //             $('#sublogin').submit();
        //         }
        //     }else{
        //         $("#mobilemsg").show();
        //     }
            
        // }
        
    }
    </script>

<link rel="stylesheet" href="zpc/css/bootstrap.css">
    <link rel="stylesheet" href="zpc/css/common_helen.css">
    <link rel="stylesheet" href="zpc/css/upload.css">
    <link rel="stylesheet" href="zpc/css/myself_helen.css">
</head>
<body>
<!-- 导航条 -->
   <!--  <nav class="navbar navbar-fixed-top" role="navigation" style="background:#fff;">
        <div class="container" >
            <div class="navbar-header" style="">
                <a class="navbar-brand" href="/home">
                    <img src="zpc/images/logo.png" alt="Brand">
                    <img class="logo_font" src="zpc/images/logo_font.png" alt="Brand">
                </a>
            </div>
            <div class="navbar-header" style="float:right;text-align:right;padding-top:15px;">
                <a href="/plogin">
                    <img src="zpc/images/pic10.png" width="50%">
                </a>
            </div>

        </div>

    </nav> -->
    <!-- /导航条 -->
<div style="display:none;"><img width="257px" height="257px" src="<?php echo $works["data"]["cover"];?>" /></div>
<div style="display:none;">
	<audio src="<?php echo $tmpfile["tmpfile"];?>" preload="true" id="video1" hidden></audio>
</div>
<!-- <div style="height:100px;clear:both;"></div> -->
<div id="loginalert" style="display:none;">
	<div style="position:fixed;top:20%;left:30%;width:40%;height:350px;background:#fff;border:2px solid #b5b5b5;z-index:9999;">
		<form method="post" action="/sublogin" id="sublogin">
            <table width="400" align="center">
                <tr>
                    <td width="400" align="left"><input style="border:none;border-bottom:1px solid #000000;padding:5px 20px;padding-left:40px;width:400px;margin-top:80px;background:url(zpc/images/mobile.png) no-repeat 20px 5px;background-size:15px;" name="mobile" id="mobile" type="text" value="" placeholder="输入手机号码"  ></td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td align="left"><input style="border:none;border-bottom:1px solid #000000;padding:5px 20px;padding-left:40px;width:400px;background:url(zpc/images/pasw.png) no-repeat 20px 5px;background-size:15px;" name="pasw" id="pasw" type="text" onfocus="this.type='password'" value="" placeholder="输入密码"  ></td>
                </tr>
                <tr style="height:15px;"></tr>
                <tr id="paswmsg">
                    <td class="bnone"  style="height:10px;font-size:12px;line-height:10px;color:#555555;" align="left"></td>
                </tr>
                <tr style="height:60px;"></tr>
                <tr>
                    <td align="center" class="sublogin">
                    <input type="button" style="border:none;background:#ffffff;width:186px;height:50px;font-size:20px;line-height:50px;color:#000000;margin-top:15px;border:2px solid #000000;" onclick="$('#loginalert').hide();"  value="取消">
                    <input type="button" style="border:none;background:#000000;width:186px;height:50px;font-size:20px;line-height:50px;color:#ffffff;margin-top:15px;margin-left:15px;border:2px solid #000000;" onclick="sublogin()" value="登录">
                    </td>
                </tr>
                <tr style="height:5px;"></tr>
                <tr>
                    <td width="40" align="left" class="bnone">
                        <!-- <a href="/pregist" class="forget">注册</a> -->
                    </td>
                    <td colspan="2" align="right" class="bnone">
                        <!-- <a href="/findmm" class="forget">忘记密码？</a> -->
                    </td>
                </tr>
            </table>
        </form>
	</div>
</div>
<div id="qr" style="float:left;text-align:center;">
	<div style="text-align:center;"><font style="font-size:40px">Welcome To SoundLab</font><br><font style="font-size:40px">欢迎来到声音实验室</font><br><font style="font-size:40px">ようこそ声実験室</font><br><br></div>
	<div id="qrios" style="float:left;text-align:center;">
		<img src="test/ios2.png" width="200px">
		<br><font style="font-size:18px">iPhone下载地址</font>
	</div>
	<div id="qrandroid" style="float:right;text-align:center;">
		<img src="test/android.png" width="200px">
		<br><font style="font-size:18px">Android下载地址</font>
	</div>
	<?php if (isset($_SESSION['mobile']) && !empty($_SESSION['mobile'])) {?>
	<div><a class="jinruon" href="http://pillele.cn/home" >进入作品管理中心</a></div>
	<?php }else{?>
	<div><a class="jinruon" id="jinruon" >进入作品管理中心</a></div>
	<?php }?>
</div>
<div id="iSlider-effect-wrapper" style="float:left;">
    <div id="animation-effect" class="iSlider-effect">
		<div id="main">
			<div id="main_a">
				<div class="layer_1">
					<span class="showbtn" id="playButton"><img width="100" id="buttonPlay" height="100" src="/test/helen/6.png" /></span>
					<img width="100%" height="100%" style="display:block;margin:0;padding:0;" id="bgImg" src="<?php echo $works["data"]["cover"];?>" />
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
							default:
								break;
						}
						echo '<a style="cursor:pointer;margin-top:5px;">'.$item.'</a>';
					}
				?>
			</div>
			<div style="clear:both;"></div>
			<div id="danmu" style="z-index:9999;">
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
			<div class="tit_muis" style="position:absolute;bottom:-252px;position:relative;width:50%;height:120px;margin-right:50%;overflow:hidden;">
				<div id="boxingdown" style="position:absolute;left:100%;height:42px;clear:both;top:31px;white-space:nowrap; overflow:hidden;">
					<?php foreach ($peaks['peaks'] as $k => $v) {?>
					<div style="float:left;height:42px;display: inline-block;white-space:nowrap; ">
						<img style="display: inline-block;float:left;margin-left:3px;white-space:nowrap; " width="3" height="<?php echo $v*0.6;?>" src="/test/helen/bo.png" />
					</div>
					<?php }?>
				</div>
			</div>
			<div class="tit_muis" style="position:absolute;bottom:-108px;position:relative;width:50%;height:120px;margin-left:50%;overflow:hidden;">
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
			<div style="position:absolute;bottom:-27px;position:relative;width:100%;height:120px;overflow:hidden;">
				<div id="positionc" style="position:absolute;left:-0%;height:9px;overflow:hidden;top:10px;margin-left:50%;">
					<?php $aaa=count($peaks['peaks'])/$works["data"]["duration"]*6;
					foreach ($works["data"]["texts"] as $kw => $vw) {
						if($kw>0){
							$he = $vw['timeline']*$aaa-$hehe;
							$hehe = $vw['timeline']*$aaa+5;
						}else{ 
							$he = ($vw['timeline'])*$aaa;
							$hehe = $he+5;
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
					}
					?>
				</div>
			</div>
			<div class="tit_info" id="texts"></div>
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
			</div><div>
	<div style="clear:both;"></div>
	<div id="author">
		<div class="author_n" style="float:left;">
			<span><img width="40" height="40" src="<?php echo $works["data"]["user"]["avatar"];?>" /></span>
			<span class="name" style="height:40px;overflow:hidden;">&nbsp;<?php echo mb_substr($works["data"]["user"]["username"],0,5);?><?php echo !empty(mb_substr($works["data"]["user"]["username"],5,1))?'...':'';?></span>
		</div>
		<div class="author_pl" style="float:right;">
			<?php if(!empty($works["data"]["price"])!=0){?>
			<span style="height:16px;border:2px solid #000;padding:0px 5px;font-size:16px;line-height:18px;"><b>¥<?php echo $works["data"]["price"];?></b></span>
			<?php }?>
			<span style="margin-left:4px;"><img width="15" height="15" src="/test/helen/3.png" /></span>
			<span class="num">&nbsp;<?php echo $works["data"]["play_count"];?></span>
			<span><img width="15" height="15" src="/test/helen/4.jpg" /></span>
			<span>&nbsp;<?php echo $comment["meta"]["count"];?></span>
		</div>
	</div>
	<div id="main_b">
		<input type="text" placeholder="输入弹幕..." readonly />
	</div>
</div>

<script>
$(function(){

	var lay1w=$('#main_a .layer_1').innerWidth()+"px";
	$('#main_a .layer_1').css('height',lay1w);
	
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
	var comment=<?php echo json_encode($comment);?>;
	$("#buttonPlay").click(function(){
		document.getElementById('video1').play();
		if(comment!=null){
			if(start==0){
				for (iii = 0; iii < comment.length; iii++) {
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
	$("#bgImg").click(function(){
		$('#danmu').danmu('danmu_pause');
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
		boxingstop();
	});
	$("#danmu").click(function(){
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
		boxingstop();
	});
$("#layer_3").click(function(){
		document.getElementById('video1').pause();
		for (iii = 0; iii < si.length; iii++) {
			 clearInterval(si[iii]);
		}
		$("#playButton").show();
		boxingstop();
	});
	
	
	var si=new Array();
	var x=new Array();
	function tangmu(text,j){
		var textStyle="<span id=\"textStyle"+j+"\" style='display:inline-block;position:relative;margin-left:10px;width:1000px;width:auto;word-break:keep-all; white-space:nowrap'>"+text+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
		var mathHeight = '5px';
		var jj = 1;
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
clearTimeout(t);
}
</script>
</body>
</html>
<?php
}else{
	header("location:http://pillele.cn/play.php?id=".$_GET["id"]);
}
?>