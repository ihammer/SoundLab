<!DOCTYPE html>    
<html>
<head>
<title>意见反馈 | 声音实验室</title>
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
input[placeholder], [placeholder], *[placeholder] { 
color:#000000 !important; 
font-size: 14px;
} 
ul,li{list-style-type:none;}
textarea{box-shadow:0px 0px 0px #fff;-webkit-appearance: none;border-radius:5px;overflow-x:hidden;resize:none;border:none;width:85%;height:200px;border:1px solid #c6c6c6;padding:7px;font-size: 14px;font-weight: 100;background-color:#f2f2f0; margin-bottom: 5px;}
input{box-shadow:0px 0px 0px #fff;-webkit-appearance: none;border-radius:5px;border:none;width:85%;height:20px;border:1px solid #c6c6c6;padding:7px;font-size: 14px;font-weight: 100;background-color:#f2f2f0;}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
  color: #636363;
}
input:-moz-placeholder, textarea:-moz-placeholder {
  color: #636363;
}
.button{margin:auto;border:none;border-radius:0px;text-align:center;height:40px;line-height:40px;width: 65%;border:3px solid #000000;margin-top: 40px;font-size: 20px;background:#ffffff;color:#000000;}
</style>
</head>
<body>
<div style="display:none;">
	<dl>
		<dt>Q:SounLad的使用说明</dt>
		<dd>A:声音实验室，发布声音，参与话题，关注用户，发私信，明星参与，说你所想！</dd>
	</dl>
</div>
<div style="width:100%;margin:0 auto;text-align:center;margin-top:20px;">
	<form method="post" id="form" action="/helppost">
		<textarea placeholder="输入你的意见想法，Lab的科学怪人们一直在努力！" name="advice" id="advice"><?php echo !empty($_GET['advice'])?$_GET['advice']:'';?></textarea>
		<input type="text"  placeholder="输入你的微信或邮箱" name="contact" id="contact" value="<?php echo !empty($_GET['contact'])?$_GET['contact']:'';?>" />
		<div class="button" onClick="submitform()" href="">提交</div>
	</form>
</div>
<div style="width:70%;margin:0 auto;text-align:center;">
	<ul style="margin:0;padding:0;text-align:center;">
		<li style="clear:both;height:30px;margin-top:30px;color:#595757;">
			<!-- <span style="float:left;"><img width="30" src="test/helen/13.png" /></span> -->
			官方QQ群：&nbsp;236338620
		</li>
		<li style="clear:both;height:30px;color:#595757;">
			
			<!-- <span style="float:left;"><img width="30" src="test/helen/14.png" /></span> -->
			微信公众号：&nbsp;Sound_lab
		</li>
		<li style="clear:both;height:30px;color:#595757;">
			<!-- <span style="float:left;"><img width="30" src="test/helen/12.png" /></span> -->
			官方微博号：&nbsp;声音实验室Soundlab
		</li>
		<li style="clear:both;height:40px;padding-top:10px;">
			<span style="font-size:14px;color:#aaaaaa;">* 长按 QQ号／微信号／微博名称 复制</span>
		</li>
	</ul>
</div>
<div id="tc" style="display:none;">123</div>
<script type="text/javascript">
// 	function submitform(){
// 		var a = $('#advice').val();
// 		var c = $('#contact').val();
// 		$.post('/helppost',{advice:a,contact:c},function(msg){
// 				// alert(msg);
// 				if(msg==1){
// 					alert("发送成功了！");
// 				}else if(msg==2){
// 					alert('谢谢参与，您已经发过相同的意见了哦！');
// 				}else{
// 					alert("请填写您的 宝贵意见 以及 联系方式！");
// 				}
// 		});
// 	}

	
</script>
<script type="text/javascript">
	function submitform(){
		// var a = $('#advice').val();
		// var c = $('#contact').val();
		$("#form").submit();
		
		
	}

	
</script>
</body>

</html>