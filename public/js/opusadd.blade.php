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
	<script type="text/javascript">
		function lookup(inputString) {
			if(inputString.length == 0) {
				// Hide the suggestion box.
				$('#suggestions').hide();
			} else {
				$.post("/123xxxadmin/linksopus", {queryString: ""+inputString+""}, function(data){
					if(data.length >0) {
						$('#suggestions').show();
						$('#autoSuggestionsList').html(data);
					}
				});
			}
		} // lookup

		function fill(thisValue,id) {
			$('#inputString').val(thisValue);
			$('#user_id').val(id);
			setTimeout("$('#suggestions').hide();", 200);
		}
	</script>

	<style type="text/css">


		.suggestionsBox {
			position: relative;
			left: 30px;
			margin: 10px 0px 0px 0px;
			width: 200px;
			background-color: #212427;
			-moz-border-radius: 7px;
			-webkit-border-radius: 7px;
			border: 2px solid #000;
			color: #fff;
		}

		.suggestionList {
			margin: 0px;
			padding: 0px;
		}

		.suggestionList li {

			margin: 0px 0px 3px 0px;
			padding: 3px;
			cursor: pointer;
		}

		.suggestionList li:hover {
			background-color: #659CD8;
		}
	</style>
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
    <li class="submenu"><a href="#"><i class="icon icon-th"></i> <span>专题</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.topic.index', '专题列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.topic.create', '添加专题') }}</li>
      </ul>
	</li>
    <li class="submenu"><a href="#"><i class="icon icon-pencil"></i> <span>标签</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.tag.index', '标签列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.utag.index', '人物标签') }}</li>
        <li>{{ link_to_route('123xxxadmin.tag.create', '添加标签') }}</li>
      </ul>
	</li>
  </ul>
</div><div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="/123xxxadmin/admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">作品</a> </div>
    <h1>作品</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>添加作品</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="/123xxxadmin/upmedia" method="post" id="signupForm" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">作品名称 :</label>
              <div class="controls">
                <input type="text" name="title" class="span11" id="title" placeholder="请输入作品名称"  />
              </div>
            </div>
			  
            <div class="control-group">
              <label class="control-label">添加音频 :</label>
              <div class="controls">
				<div id="mediauploaddiv" class="btn1"> <span>上传音频</span>
					<input id="mediaupload" type="file" name="file">
				</div>
				<input type="text" id="playurl" name="playurl" value="" />
				<input type="hidden" id="etag" name="etag" value="" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">选择用户 :</label>
              <div class="controls">

					  <div>
						  <input type="text" class="input-text" size="30" value="" id="inputString" name="username" onkeyup="lookup(this.value);" onblur="fill(thisValue,id);" />
					  </div>
					  <div class="suggestionsBox" id="suggestions" style="display: none;">
						  <div class="suggestionList" id="autoSuggestionsList">
							  &nbsp;
						  </div>
					  </div>

				  <input type="hidden" name="user_id" id="user_id" value="">

                <!--
                <select id="user_id" name="user_id">
				<option>请选择用户</option>
				<!--?php
				foreach($models as $key=>$items){
					if(isset($_GET["id"]) && $items->id==$_GET["id"]){
						echo "<option value='".$items->id."' selected=selected>".$items->username."</option>";
					}else{
						echo "<option value='".$items->id."'>".$items->username."</option>";
					}
				}
				?>
				</select>
				<input type="hidden" name="username" id="username" value="">
				-->
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">添加文字 :</label>
              <div class="controls">
                <textarea class="span11" name="texts"></textarea>
				<span class="help-block">*格式：秒:内容 多条内容请用";"分割<br>例子：1:当你老了;6:头发白了;13:睡意昏沉</span> </div>
              </div>
			<div class="control-group">
              <label class="control-label">添加关系 :</label>
              <div class="controls">
                <textarea class="span11" name="persons"></textarea>
				<span class="help-block"><font color="red">*人声：0 创作者：1 图像：2 吉他：3 贝司：4 鼓：5 键盘：6 管乐器：7 弦乐器：8 民族乐器：9</font><br>格式：项目编号:人名 用";"分割<br>例子：0:犀牛;1:犀牛;5:赵照</span> </div>
              </div>
            <div class="control-group">
              <label class="control-label">添加图片 :</label>
              <div class="controls">
              	<input id="tl" type="input" name="tl"> 秒
				  <input id="tl2" type="hidden" value="" />
            <div class="btn"> <span>上传图片</span>
              <input id="fileupload" type="file" name="file">
            </div>
				  <input type="button" id="saveimg" value="确认保存" class="Intercbtn" />
				  <div id="showimg" style="clear:both;margin-top:15px;margin-bottom:15px;"><img src="/images/01.jpg" /><!--初始图片--></div>
				  <input type="hidden" id="src" name="src" value="" />
				  <input type="hidden" id="aaa" name="aaa" value="1" />
				  <input type="hidden" id="x" name="x" value="0" />
				  <input type="hidden" id="y" name="y" value="0" />
				  <input type="hidden" id="w" name="w" value="240" />
				  <input type="hidden" id="h" name="h" value="240" />
            <div class="progress"> <span class="bar"></span><span class="percent">0%</span > </div>
			<div id="addimage" style="clear:both"></div>
          </div>
            </div>
            <div class="control-group">
              <label class="control-label">标签 :</label>
              <div class="controls">
                <textarea class="span11" name="tag"></textarea>
				<span class="help-block">*输入标签，以英文逗号","区隔</span>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">LabX活动 :</label>
              <div class="controls">
				<input id="compshowno" name="is_compshow" type="radio" value="0" checked="checked">否
				<input id="compshowyes" name="is_compshow" type="radio" value="1">是
				<span class="help-block"></span>
              </div>
            </div>
            <div class="control-group" style="display:none;" id="labxcompstatus">
              <label class="control-label">LabX上架 :</label>
              <div class="controls">
				<input id="ccompstatusno" name="compstatus" type="radio" value="0">否
				<input id="compstatusyes" name="compstatus" type="radio" value="1" checked="checked">是
				<span class="help-block"></span>
              </div>
            </div>
            <div class="control-group" style="display:none;" id="labxtype">
              <label class="control-label">LabX分类 :</label>
              <div class="controls">
                <select name="type_id">
	                <option value="0">暂无分类</option>
	                <?php
					  foreach($types as $key=>$val){
						  echo '<option value="'.$val->id.'">'.$val->name.'</option>';
					  }
					?>
	            </select>
              </div>
            </div>
			<div class="control-group" style="display:none;" id="comptimediv">
              <label class="control-label">LabX时间 :</label>
              <div class="controls">
                <textarea class="span11" name="comptime"></textarea>
				<span class="help-block">*填写活动时间，例：2015-06-24</span>
              </div>
            </div>

            <div class="control-group" id="labxpt">
              <label class="control-label">支付途径 :</label>
              <div class="controls">
                <select name="pricetype"><option value="0">现金交易</option><option value="1">积分兑换</option></select>
              </div>
            </div>
            <div class="control-group" id="labxprice">
              <label class="control-label">金额／积分 :</label>
              <div class="controls">
                <input name="price" type="number" value="0">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">是否推荐 :</label>
              <div class="controls">
				<input id="recommendno" name="is_recommend" type="radio" value="0" checked="checked">不推荐
				<input id="recommendyes" name="is_recommend" type="radio" value="1">推荐
				<span class="help-block"></span>
              </div>
            </div>
			<div class="control-group" style="display:none;" id="reasondiv">
              <label class="control-label">推荐理由 :</label>
              <div class="controls">
                <textarea class="span11" name="reason"></textarea>
				<span class="help-block">*请填写推荐此歌的理由</span>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">添加作品</button>
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
  <div id="footer" class="span12"> 2013 &copy; Matrix Admin. More Templates <a href="http://www.mycodes.net/" target="_blank">源码之家</a></div>
</div>
<!--end-Footer-part-->

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
<!--script src="/js/jquery.validate.min.js"></script> 
<script src="/js/messages_zh.js"></script> 
<script type="text/javascript">  
$.validator.setDefaults({
    submitHandler: function() {
      alert("提交事件!");
    }
});
$().ready(function() {
  
              $("#signupForm").validate({
			    rules: {
			      title: "required"
			     
			    },
			    messages: {
			      title: "请输入您的标题"
			    }
			});


               
               
    });  
 
  </script--> 
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
			$('#labxtype').css("display","block");
			$('#labxcompstatus').css("display","block");
		});
		$('#compshowno').change(function () {
			$('#comptimediv').css("display","none");
			$('#labxtype').css("display","none");
			$('#labxcompstatus').css("display","none");
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
		$("#saveimg").click(function(){
			$.post("/123xxxadmin/upfile?type=3", { x: $("#x").val()*$("#aaa").val(), y: $("#y").val()*$("#aaa").val(), w: $("#w").val()*$("#aaa").val(), h: $("#h").val()*$("#aaa").val(),src: $("#src").val()},function(data){
				showimg.html("<img src='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"' style='max-width:400px' />");
				$("#src").val(data.src);
				var tl=$("#tl2").val();
				//显示上传后的图片
				var addhtml = "<span class='help-block' style='margin-bottom:5px;'><input type='hidden' name='src[]' value='"+data.src+"' /><input type='hidden' name='hash[]' value='"+data.hash+"' /><input type='hidden' name='size[]' value='"+data.size+"' /><img width='30' height='30' style='display:block;float:left;padding-right:10px;' src='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"' /><b><input type='text' name='timeline[]' style='width:30px;' value='"+tl+"' />秒 <a href='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"' target='_blank'>"+data.src+"</a></b>&nbsp;&nbsp;<b style='cursor:pointer;' onclick='delimage(this);'>删除</b></span>";
				$("#addimage").append(addhtml);

			},"json");
		});
		$("#fileupload").change(function(){  //选择文件
				var tl=$("#tl").val();
				if(tl!=""){
					$('#tl2').val(tl);
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
//							//显示上传后的图片
//							var addhtml = "<span class='help-block' style='margin-bottom:5px;'><input type='hidden' name='src[]' value='"+data.src+"' /><input type='hidden' name='hash[]' value='"+data.hash+"' /><input type='hidden' name='size[]' value='"+data.size+"' /><img width='30' height='30' style='display:block;float:left;padding-right:10px;' src='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"' /><b><input type='text' name='timeline[]' style='width:30px;' value='"+tl+"' />秒 <a href='http://7xikb7.com1.z0.glb.clouddn.com/"+data.src+"' target='_blank'>"+data.src+"</a></b>&nbsp;&nbsp;<b style='cursor:pointer;' onclick='delimage(this);'>删除</b></span>";
//							//+tl+"秒 "
							//
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

//							$("#addimage").append(addhtml);
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
