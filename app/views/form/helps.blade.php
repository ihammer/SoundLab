<!DOCTYPE html>
<html>
<head>
<title>后台管理系统</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/css/bootstrap.min.css" />
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
    <li class="submenu"><a href="#"><i class="icon icon-th-list"></i> <span>作品</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.opus.index', '作品列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.opus.create', '上传作品') }}</li>
      </ul>
	</li>
    <!--{{--<li class="submenu"><a href="#"><i class="icon icon-th"></i> <span>专题</span></a>--}}
	  {{--<ul>--}}
        {{--<li>{{ link_to_route('123xxxadmin.topic.index', '专题列表') }}</li>--}}
        {{--<li>{{ link_to_route('123xxxadmin.topic.create', '添加专题') }}</li>--}}
      {{--</ul>--}}
	{{--</li>--}}-->
    <li class="submenu"><a href="#"><i class="icon icon-pencil"></i> <span>标签</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.tag.index', '标签列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.utag.index', '人物标签') }}</li>
        <!-- <li>{{ link_to_route('123xxxadmin.tag.create', '添加标签') }}</li> -->
      </ul>
	</li>
  <li class="active submenu open"><a href="#"><i class="icon icon-th"></i> <span>帮助</span></a>
    <ul>
        <li>{{ link_to_route('123xxxadmin.helps.index', '帮助列表') }}</li>
      </ul>
  </li>
  </ul>
</div><div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">用户意见</a> </div>
    <h1>用户意见</h1>
  </div>
  <div class="container-fluid">
      <!-- <span><a href="/123xxxadmin/roleuser/create">添加管理员</a></span> -->
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
            <h5>意见列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>用户信息</th>
                  <th width="50%">用户意见</th>
                  <th>状态</th>
                  <th>添加时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
			  <?php
			  foreach($models as $key=>$items){
			  ?>
                <tr>
                  <td><?php echo $items["attributes"]["contact"];?></td>
                  <td><?php echo $items["attributes"]["info"];?><br><font color="green"><?php echo $items["attributes"]["callinfo"];?></font></td>
                  <td><?php echo $items["attributes"]["status"]==1?'<font color="green">已处理</font>':'<font color="red">未处理</font>';?></td>
                  <td><?php echo $items["attributes"]["created_at"];?></td>
				          <td style="text-align:center;">
                    <?php if($items["attributes"]["id"]==1){?><?php }else{?><a href="helps/<?php echo $items["attributes"]["id"]; ?>/edit">编辑</a><?php }?>
                  </td>
                </tr>
			  <?php
			  }
			  ?>
              </tbody>
            </table>
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
<div id="overlay">

</div>
<div class="alertsTag">
	<div class="alert_tit">
		推送内容
	</div>
	<div class="content">
		<table>
			<tbody><tr>
				<td width="100%" align="center">
					<textarea id="tag" style="width:535px;height:200px"></textarea>
					<input type="hidden" id="tagid" value="">
				</td>
			</tr>
		</tbody></table>
	</div>
	<div class="buton" style="text-align:center;">
		<input type="button" value="提交" id="subTag">&nbsp;&nbsp;<input type="button" id="resTag" value="返回">
	</div>
</div>
<!--end-Footer-part-->
<script src="/js/jquery.min.js"></script> 
<script src="/js/jquery.ui.custom.js"></script> 
<script src="/js/bootstrap.min.js"></script> 
<script src="/js/jquery.uniform.js"></script> 
<script src="/js/select2.min.js"></script> 
<script src="/js/jquery.dataTables2.min.js"></script> 
<script src="/js/matrix.js"></script> 
<script src="/js/matrix.tables.js"></script>
<script type="text/javascript">
	function recommendBut(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("userid");
		if(ismusician_text=='取消推荐'){
			var is_musician=0;
			var spantext="推荐用户";
		}else{
			var is_musician=1;
			var spantext="取消推荐";
		}
		$.post("/123xxxadmin/recommenduser",{id:id,recommend:is_musician});
		$(this).text(spantext);
	}
	function pushBut(){
		$("#overlay").height(document.body.scrollHeight);
		$("#overlay").width(document.body.scrollWidth);
		$("#overlay").fadeTo(200, 0.5);
		$(".alertsTag").fadeTo(200,1);
		$("#resTag").click(function(){
			$("#overlay").fadeOut(200);
			$(".alertsTag").fadeOut(200);
		});
		$("#subTag").click(function(){
			$("#overlay").fadeOut(200);
			$(".alertsTag").fadeOut(200);
			var tagVal=$("#tag").val();
			if(tagVal!=""){
				$.post("/123xxxadmin/addpush",{content:tagVal},function(data){if(data==1){$("#tag").val('');return;}});
			}
			
		});
		
	}
</script>
<style type="text/css">
	#overlay {
    background: #000;
    filter: alpha(opacity=50); /* IE的透明度 */
    opacity: 0.5;  /* 透明度 */
    display: none;
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    z-index: 100; /* 此处的图层要大于页面 */
    display:none;
	}
	.alerts {
width: 550px;
display: none;
min-height: 260px;
border: 1px solid #cecece;
position: fixed;
left: 30%;
top: 30%;
z-index:150;
background: #ffffff;
}
.alerts .alert_tit {
width: 548px;
height: 40px;
background: #51a9f1;
border: 1px solid #7dbef4;
line-height: 40px;
color: #ffffff;
text-indent: 20px;
}
.alertsTag {
width: 550px;
display: none;
min-height: 260px;
border: 1px solid #cecece;
position: fixed;
left: 30%;
top: 30%;
z-index:150;
background: #ffffff;
}
.alertsTag .alert_tit {
width: 548px;
height: 40px;
background: #51a9f1;
border: 1px solid #7dbef4;
line-height: 40px;
color: #ffffff;
text-indent: 20px;
}
</style>
</body>
</html>
