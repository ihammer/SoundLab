<!DOCTYPE html>
<html>
<head>
<title>后台管理系统</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/css/bootstrap.css" />
<link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/css/uniform.css" />
<link rel="stylesheet" href="/css/select2.css" />
<link rel="stylesheet" href="/css/matrix-style.css" />
<link rel="stylesheet" href="/css/matrix-media.css" />
<link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.useso.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1>后台管理系统</h1>
</div>
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">管理员<?php echo $_SESSION["admin"]; ?>,您好</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="password"><i class="icon-user"></i> 修改密码</a></li>
        <li class="divider"></li>
        <li class="divider"></li>
        <li><a href="logout"><i class="icon-key"></i> 退出</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="logout"><i class="icon icon-share-alt"></i> <span class="text">退出</span></a></li>
  </ul>
</div>
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li><a href="/123xxxadmin/admin"><i class="icon icon-home"></i> <span>首页</span></a> </li>
    <li class="active submenu open"><a href="#"><i class="icon icon-inbox"></i> <span>用户</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.user.index', '用户列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.user.create', '添加用户') }}</li>
      </ul>
	</li>
    <li class="submenu"><a href="#"><i class="icon icon-th-list"></i> <span>作品</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.opus.index', '作品列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.opus.create', '上传作品') }}</li>
      </ul>
	</li>
    <!--li class="submenu"><a href="#"><i class="icon icon-th"></i> <span>专题</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.topic.index', '专题列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.topic.create', '添加专题') }}</li>
      </ul>
	</li-->
    <li class="submenu"><a href="#"><i class="icon icon-pencil"></i> <span>标签</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.tag.index', '标签列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.utag.index', '人物标签') }}</li>
        <!-- <li>{{ link_to_route('123xxxadmin.tag.create', '添加标签') }}</li> -->
      </ul>
	</li>
	<li class="submenu"><a href="#"><i class="icon icon-th"></i> <span>帮助</span></a>
    <ul>
        <li>{{ link_to_route('123xxxadmin.helps.index', '帮助列表') }}</li>
      </ul>
  </li>
  </ul>
</div><div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/123xxxadmin/admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">用户</a> </div>
    <h1>用户</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>添加用户</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="/123xxxadmin/saveuser" method="get" id="subform" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">用户名 :</label>
              <div class="controls">
                <input type="text" name="username" id="username" class="span11" placeholder="请输入用户名" />
                <span id="usernameb" style="display:none;"><font color="red">＊必填</font></span>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">手机号 :</label>
              <div class="controls">
                <input type="text" name="mobile" id="mobile" class="span11" id="mobile" placeholder="请输入手机号" />
                <span id="mobileb" style="display:none;"><font color="red">＊必填</font></span>
              </div>
            </div>
			  <div class="control-group">
				  <label class="control-label">密码 :</label>
				  <div class="controls">
					  <input type="text" name="password" id="password" class="span11" placeholder="请输入密码" />
					  <span id="passwordb" style="display:none;"><font color="red">＊必填</font></span>
				  </div>
			  </div>
            <div class="control-group">
              <label class="control-label">地址 :</label>
              <div class="controls">
                <input type="text" name="city" id="city" placeholder="请输入城市" />
                <span id="cityb" style="display:none;"><font color="red">＊必填</font></span>
                 <input type="text" name="area" id="area" placeholder="请输入区域" />
                 <span id="areab" style="display:none;"><font color="red">＊必填</font></span>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">性别 :</label>
              <div class="controls">
                <select name="sex">
					<option value="1">男</option>
					<option value="2">女</option>
					<option value="0">外星人</option>
				</select>
              </div>
            </div>
            <div class="control-group">
				  <label class="control-label">用户分类 :</label>
				  <div class="controls">
					  <select name="utype_id">
						  <option value="0">暂无分类</option>
						  <?php
						  foreach($types as $key=>$val){
							  echo '<option value="'.$val->id.'">'.$val->name.'</option>';
						  }
						  ?>
					  </select>
				</div>
				  </div>
            <div class="control-group">
              <label class="control-label"><span id="srcb" style="display:none;"><font color="red">＊必填</font></span>头像 :</label>
              <div class="controls">
            <div class="btn"> <span>上传图片</span>
              <input id="fileupload" type="file" name="avatar">
            </div>
            <input type="button" id="saveimg" value="确认保存" class="Intercbtn" />
            <div class="progress"> <span class="bar"></span><span class="percent">0%</span > </div>

            <div class="files"></div>
            <div id="showimg"><img src="/images/01.jpg" /><!--初始图片--></div>
          </div>
          <input type="hidden" id="src" name="src" value="" />
          <input type="hidden" id="aaa" name="aaa" value="1" />
          <input type="hidden" id="x" name="x" value="0" />
          <input type="hidden" id="y" name="y" value="0" />
          <input type="hidden" id="w" name="w" value="240" />
          <input type="hidden" id="h" name="h" value="240" />
				
            </div>
            <div class="control-group">
              <label class="control-label">自我介绍 :</label>
              <div class="controls">
                <textarea class="span11" id="introduce" name="introduce"></textarea><span id="introduceb" style="display:none;"><font color="red">＊必填</font></span>
							</div>
							
              </div>
            <div class="control-group">
              <label class="control-label">标签 :</label>
              <div class="controls">
                <textarea class="span11" name="tag"></textarea>
				<span class="help-block">*输入标签，以英文逗号","区隔</span> </div>
              </div>
            <div class="form-actions">
              <button type="button" onclick="subform()" class="btn btn-success">添加用户</button>
            </div>
          </form>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12">©2015 北京灵犀一点文化科技有限公司 - 京ICP证123456号 - 京公网安备12345678901234号</div>
</div>
<!--end-Footer-part-->
<script src="/js/jquery.min.js"></script> 
<script src="/js/jquery.ui.custom.js"></script> 
<script src="/js/bootstrap.min.js"></script> 
<script src="/js/jquery.uniform.js"></script> 
<script src="/js/select2.min.js"></script> 
<script src="/js/jquery.dataTables.min.js"></script> 
<script src="/js/matrix.js"></script> 
<script src="/js/matrix.tables.js"></script>
<script src="/js/jquery.Jcrop.min.js"></script>
<link href="/css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery.form.js"></script>
<style type="text/css">
/*上传文件的css*/
.btn {
	float:left;
	position: relative;
	overflow:hidden;
	margin-right:4px;
	display:inline-block;
*display:inline;
	padding:4px 10px 4px;
	font-size:14px;
	line-height:18px;
*line-height:20px;
	color:#fff;
	text-align:center;
	vertical-align:middle;
	cursor:pointer;
	background-color:#5bb75b;
	border:1px solid #cccccc;
	border-color:#e6e6e6 #e6e6e6 #bfbfbf;
	border-bottom-color:#b3b3b3;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
}
.btn input {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	border: solid transparent;
	opacity:0;
	filter:alpha(opacity=0);
	cursor: pointer;
}
.Intercbtn {
	float:left;
	background-color:#e38102;
	color:#FFF;
	padding:4px 10px 4px 10px;
	border:0;
	border-radius: 5px;
}
.progress {
	position:relative;
	margin-left:100px;
	margin-top:-24px;
	width:200px;
	padding: 1px;
	border-radius:3px;
	display:none
}
.bar {
	background-color: green;
	display:block;
	width:0%;
	height:20px;
	border-radius: 3px;
}
.percent {
	position:absolute;
	height:20px;
	display:inline-block;
	top:3px;
	left:2%;
	color:#fff
}
.files {
	height:22px;
	line-height:22px;
	margin:10px 0
}
.delimg {
	margin-left:20px;
	color:#090;
	cursor:pointer
}
</style>
<script>
	$(document).ready(function(){
		var bar = $('.bar');
		var percent = $('.percent');
		var showimg = $('#showimg');
		var progress = $(".progress");
		var files = $(".files");
		var btn = $(".btn span");
		$("#fileupload").wrap("<form id='myupload' action='/123xxxadmin/upload?upto=1' method='post' enctype='multipart/form-data'></form>");
		$("#saveimg").click(function(){
			$.post("/123xxxadmin/upload?upto=2", { x: $("#x").val()*$("#aaa").val(), y: $("#y").val()*$("#aaa").val(), w: $("#w").val()*$("#aaa").val(), h: $("#h").val()*$("#aaa").val(),src: $("#src").val()},function(data){
				showimg.html("<img src='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"' style='max-width:400px' />");
				$("#src").val(data.src);
			},"json");
		});
		$("#fileupload").change(function(){  //选择文件
			$("#myupload").ajaxSubmit({
				dataType:  'json',	//数据格式为json 
				beforeSend: function() {	//开始上传 
					showimg.empty();	//清空显示的图片
					btn.html("上传中...");	//上传按钮显示上传中
				},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';	//获得进度
					bar.width(percentVal);	//上传进度条宽度变宽
					percent.html(percentVal);	//显示上传进度百分比
				},
				success: function(data) {	//成功
					//显示上传后的图片
					var img = "/tmpfile/"+data.pic;
					//判断上传图片的大小 然后设置图片的高与宽的固定宽
					/*if (data.width>240 && data.height<240){
						showimg.html("<img src='"+img+"' id='cropbox' height='240' />");
					}else if(data.width<240 && data.height>240){
						showimg.html("<img src='"+img+"' id='cropbox' width='240' />");
					}else if(data.width<240 && data.height<240){
						showimg.html("<img src='"+img+"' id='cropbox' width='240' height='240' />");*/
						
					if(data.width>400){
						showimg.html("<img src='"+img+"' id='cropbox' style='max-width:400px' />");
						$("#aaa").val(data.width/400);
					}else{
						showimg.html("<img src='"+img+"' id='cropbox' />");
						$("#aaa").val(1);
					}
					//传给php页面，进行保存的图片值
					$("#src").val(img);
					//截取图片的js
					$('#cropbox').Jcrop({
						aspectRatio: 1,
						onSelect: updateCoords,
						minSize:[0,0],
						maxSize:[data.width,data.height],
						allowSelect:true, //允许选择
						allowResize:true, //是否允许调整大小
						setSelect: [ 0, 0, 240, 240 ]
					});
					btn.html("上传图片");	//上传按钮还原
				},
				error:function(xhr){	//上传失败
					btn.html("上传失败");
					bar.width('0')
					files.html(xhr.responseText);	//返回失败信息
				}
			});
		});		
	});
	
	function updateCoords(c){
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	
	function checkCoords(){
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press submit.');
		return false;
	};

	function subform(){
		var usernamecheck = false;
		var mobilecheck = false;
		var passwordcheck = false;
		var citycheck = false;
		var areacheck = false;
		var introducecheck = false;
		var srccheck = false;
		var m = $('#mobile').val();
		var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;

		if($.trim($("#username").val()).length == 0){
			$("#username").focus();
			$("#usernameb").show();
			// alert("作品名称不可为空！");
		}else{
			$("#usernameb").hide();
			if($.trim($("#mobile").val()).length == 0){
				$("#mobile").focus();
				$("#mobileb").show();
				// alert("作品名称不可为空！");
			}else{
				$("#mobileb").hide();
				if($.trim($("#password").val()).length == 0){
					$("#password").focus();
					$("#passwordb").show();
					// alert("作品名称不可为空！");
				}else{
					$("#passwordb").hide();
					if($.trim($("#city").val()).length == 0){
						$("#city").focus();
						$("#cityb").show();
						// alert("作品名称不可为空！");
					}else{
						$("#cityb").hide();
						if($.trim($("#area").val()).length == 0){
							$("#area").focus();
							$("#areab").show();
							// alert("作品名称不可为空！");
						}else{
							$("#areab").hide();
							if($.trim($("#introduce").val()).length == 0){
								$("#introduce").focus();
								$("#introduceb").show();
								// alert("作品名称不可为空！");
							}else{
								if($.trim($("#src").val()).length == 0){
									$("#src").focus();
									$("#srcb").show();
									// alert("作品名称不可为空！");
								}else{
									$("#srcb").hide();
									if (reg.test(m)) {
									      $.post('/123xxxadmin/checkmobile',{mobile:m},function(msg){
									      		if(msg>0){
									      			$("#mobile").focus();
												    $("#mobileb").html('号码已注册！');
													$("#mobileb").show();
									      		}else{
									      			$("#mobileb").hide();
									      			$('#subform').submit();
									      		}
									      });
									 }else{
									      $("#mobile").focus();
									      $("#mobileb").html('号码有误！');
										  $("#mobileb").show();
									 }
								 }
								
							}

						}
					}
				}
			}

		}

		
		 
	}
</script>
</body>
</html>
