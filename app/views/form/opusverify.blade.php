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
    <li><a href="admin"><i class="icon icon-home"></i> <span>首页</span></a> </li>
    <li class="submenu"><a href="#"><i class="icon icon-inbox"></i> <span>用户</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.user.index', '用户列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.user.create', '添加用户') }}</li>
      </ul>
	</li>
    <li class="active submenu open"><a href="#"><i class="icon icon-th-list"></i> <span>作品</span></a>
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
    <div id="breadcrumb"> <a href="/123xxxadmin/admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">作品</a> </div>
    <h1>最新作品列表</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>审核作品</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="/123xxxadmin/opus/uptonewest" method="post" class="form-horizontal">
		  			<input type="hidden" name="work_id" value="<?php echo $model->id;?>" />
            <div class="control-group">
              <label class="control-label">作品名称 :</label>
              <div class="controls">
                <input type="text" name="title" class="span11" value="<?php echo $model->title;?>" readonly="readonly" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">音频地址 :</label>
              <div class="controls">
			  <audio controls="controls" src="<?php echo $host.$model->playurl;?>">您的浏览器不支持 audio 标签</audio>
				<!--div id="mediauploaddiv" class="btn1"> <span>----更换音频</span>
					<input id="mediaupload" type="file" name="file">
				</div-->
				<!--input type="hidden" id="playurl" name="playurl" value="<?php echo $model->playurl;?>" />
				<input type="hidden" id="etag" name="etag" value="<?php echo $model->etag;?>" /-->
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">所属用户 :</label>
              <div class="controls">
                <input type="text" name="username" class="span11" value="<?php echo $model->username;?>" readonly="readonly" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">文字打点 :</label>
              <div class="controls">
                <textarea class="span11" name="texts" readonly="readonly"><?php echo $texts;?></textarea>
				</div>
              </div>
			<div class="control-group">
              <label class="control-label">人物关系 :</label>
              <div class="controls">
                <textarea class="span11" name="persons" readonly="readonly"><?php echo $persons;?></textarea>
				</div>
              </div>
               <div class="control-group">
	              <label class="control-label">作品图片 :</label>
	              <div class="controls">
		              <?php
									foreach($workimage as $item){
										echo '<span class="help-block"><img src="'.$host.$item->url.'!cover"></span> ';
									}
		              ?>
								</div>
             	</div>
          
		  			<div class="control-group">
              <label class="control-label">是否显示在最新:</label>
              <div class="controls">
                是<input type="radio" name="is_verify" value="1" checked="checked"> 否<input type="radio" name="is_verify" value="2">
							</div>
              </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">提交修改</button>
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
.btn1 {
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
.btn1 input {
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
	padding:6px 10px 6px 10px;
	border:0;
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
		$('#recommendyes').change(function () {
			$('#reasondiv').css("display","block");
		});
		$('#recommendno').change(function () {
			$('#reasondiv').css("display","none");
		});
		$('#compshowyes').change(function () {
			$('#comptimediv').css("display","block");
		});
		$('#compshowno').change(function () {
			$('#comptimediv').css("display","none");
		});
		$("#username").val($('#user_id option:selected').text());
		$('#user_id').change(function () {
            $("#username").val($('#user_id option:selected').text());
        });
		
		var bar = $('.bar');
		var percent = $('.percent');
		var showimg = $('#showimg');
		var progress = $(".progress");
		var files = $(".files");
		var btn = $(".btn span");
		var btn1 = $(".btn1 span");
		$("#mediauploaddiv").wrap("<form id='myupload1' action='/123xxxadmin/upfile?type=1' method='post' enctype='multipart/form-data'></form>");
		$("#mediaupload").change(function(){  //选择文件
			$("#myupload1").ajaxSubmit({
				dataType:  'json',	//数据格式为json 
				beforeSend: function() {	//开始上传 
					btn1.html("上传中...");	//上传按钮显示上传中
				},
				success: function(data) {	//成功
					$(".btn1").empty();
					$(".btn1").html("<b>"+data.src+"</b>");
					$("#playurl").val(data.src);
					$("#etag").val(data.hash);
					//$(".btn1").html("<b>"+data+"m)</b>");
				},
				error:function(xhr){	//上传失败
					alert(xhr);//$(".btn1").html("<b>"+xhr+"</b>");
					//btn1.html("上传失败");
				}
			});
		});
		$("#fileupload").wrap("<form id='myupload' action='/123xxxadmin/upfile?type=2' method='post' enctype='multipart/form-data'></form>");
			$("#fileupload").change(function(){  //选择文件
				var tl=$("#tl").val();
				if(tl!=""){
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
							var addhtml = "<span class='help-block'><input type='hidden' name='src[]' value='"+data.src+"' /><input type='hidden' name='hash[]' value='"+data.hash+"' /><input type='hidden' name='size[]' value='"+data.size+"' /><input type='hidden' name='timeline[]' value='"+tl+"' /><b>"+tl+"秒 "+data.src+"</b></span>";
							//+tl+"秒 "
							//
							$("#addimage").append(addhtml);
							//截取图片的js
							btn.html("上传图片");	//上传按钮还原
							$("#tl").val("");
						},
						error:function(xhr){	//上传失败
							btn.html("上传失败");
							bar.width('0')
							files.html(xhr.responseText);	//返回失败信息
						}
				});
			}else{
				alert("请先填写时间，再上传图片");
			}
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
</script>
</body>
</html>
