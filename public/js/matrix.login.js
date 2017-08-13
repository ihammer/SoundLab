
$(document).ready(function(){
	$('#loginButton').click(function(){
		if($('#userName').val()!="" && $('#userPwd').val()!=""){
			$.get("dologin",{ admin: $('#userName').val(), pass: $('#userPwd').val() }, function(data){
				if(data=="1"){
					$(window.location).attr('href', 'admin');
				}else if(data=="1001"){
					$('#errMsg').html("用户名错误");
				}else if(data=="1002"){
					$('#errMsg').html("密码错误");
				}
			});
		}else{
			$('#errMsg').html("用户名密码不能为空");
		}
	});
	$('#userName').focus(function(){
		$('#errMsg').html("");
	});
	$('#userPwd').focus(function(){
		$('#errMsg').html("");
	});
});