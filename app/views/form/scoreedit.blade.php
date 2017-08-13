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
    <h1>特殊积分</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>添加特殊积分</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="/123xxxadmin/upsavescore" method="post" class="form-horizontal">
          	<input type="hidden" name="userid" value="<?php echo $model->id;?>">
            <div class="control-group">
              <label class="control-label">用户名 :</label>
              <div class="controls">
                <input type="text" readonly="readonly" name="username" class="span11" value="<?php echo $model->username;?>"  />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">积分 :</label>
              <div class="controls">
                <input type="text" name="num" onkeyup="value=value.replace(/[^\d]/g,'')"  value="<?php echo $model->num;?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">操作类型 :</label>
              <div class="controls">
                <select name="type">
					<option value="1"<?php echo $model->type==1 ? " selected='selected'" : " ";?>>加</option>
					<option value="2"<?php echo $model->type==2 ? " selected='selected'" : " ";?>>减</option>
					<option value="0"<?php echo $model->type==0 ? " selected='selected'" : " ";?>>无</option>
				</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">理由 :</label>
              <div class="controls">
                <textarea class="span11" name="reason"><?php echo $model->reason;?></textarea>
							</div>
              </div>
              <div class="control-group">
              <label class="control-label">状态 :</label>
              <div class="controls">
                <select name="status">
					<option value="1"<?php echo $model->status==1 ? " selected='selected'" : " ";?>>审核通过</option>
					<option value="2"<?php echo $model->status==2 ? " selected='selected'" : " ";?>>驳回</option>
					<option value="0"<?php echo $model->status==0 ? " selected='selected'" : " ";?>>未处理</option>
				</select>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">确认</button>
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
		var bar = $('.bar');
		var percent = $('.percent');
		var showimg = $('#showimg');
		var progress = $(".progress");
		var files = $(".files");
		var btn = $(".btn span");
		$("#fileupload").wrap("<form id='myupload' action='/123xxxadmin/upload?upto=1' method='post' enctype='multipart/form-data'></form>");
		$("#saveimg").click(function(){
			$.post("/123xxxadmin/upload?upto=2", { x: $("#x").val(), y: $("#y").val(), w: $("#w").val(), h: $("#h").val(),src: $("#src").val()},function(data){
				showimg.html("<img src='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"'/>");
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
					if (data.width>240 && data.height<240){
						showimg.html("<img src='"+img+"' id='cropbox' height='240' />");
					}else if(data.width<240 && data.height>240){
						showimg.html("<img src='"+img+"' id='cropbox' width='240' />");
					}else if(data.width<240 && data.height<240){
						showimg.html("<img src='"+img+"' id='cropbox' width='240' height='240' />");
					}else{
						showimg.html("<img src='"+img+"' id='cropbox' />");
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
</script>
</body>
</html>
