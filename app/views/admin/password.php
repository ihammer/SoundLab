<!DOCTYPE html>
<html lang="en">
<head>
  <title>Matrix Admin</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="/css/fullcalendar.css" />
  <link rel="stylesheet" href="/css/matrix-style.css" />
  <link rel="stylesheet" href="/css/matrix-media.css" />
  <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/jquery.gritter.css" />
  <link href='http://fonts.useso.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

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
        <li><a href="logout" id="logout"><i class="icon-key"></i> 退出</a></li>
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
        <li>{{ link_to_route('user.index', '用户列表') }}</li>
        <li>{{ link_to_route('user.create', '添加用户') }}</li>
      </ul>
	</li>
    <li class="submenu"><a href="#"><i class="icon icon-th-list"></i> <span>作品</span></a>
	  <ul>
        <li>{{ link_to_route('opus.index', '作品列表') }}</li>
        <li>{{ link_to_route('opus.create', '上传作品') }}</li>
      </ul>
	</li>
    <li class="submenu"><a href="#"><i class="icon icon-th"></i> <span>专题</span></a>
	  <ul>
        <li>{{ link_to_route('topic.index', '专题列表') }}</li>
        <li>{{ link_to_route('topic.create', '添加专题') }}</li>
      </ul>
	</li>
    <li class="submenu"><a href="#"><i class="icon icon-pencil"></i> <span>标签</span></a>
	  <ul>
        <li>{{ link_to_route('tag.index', '标签列表') }}</li>
        <li>{{ link_to_route('tag.create', '添加标签') }}</li>
      </ul>
	</li>
  </ul>
</div><div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="admin" title="回到首页" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#">管理员</a> <a href="#" class="current">修改密码</a> </div>
    <h1>管理员</h1>
  </div>
  <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>修改密码</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="dopassword" name="password_validate" id="password_validate" novalidate="novalidate">
                <input type="hidden" value="<?php echo $_SESSION["admin_id"]?>" id="adminid" />
                <div class="control-group">
                  <label class="control-label">旧密码</label>
                  <div class="controls">
                    <input type="password" name="pwd" id="pwd" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">新密码</label>
                  <div class="controls">
                    <input type="password" name="pwd1" id="pwd1" />
                  </div>
                </div>
				<div class="control-group">
                  <label class="control-label">确认新密码</label>
                  <div class="controls">
                    <input type="password" name="pwd2" id="pwd2" />
                  </div>
                </div>
                <div class="form-actions">
                  <input type="button" onclick="subpass()"  value="修改" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function subpass(){
    var id=$("#adminid").val();
    var pwd=$("#pwd").val();
    var pwd1=$('#pwd1').val();
    var pwd2=$('#pwd2').val();
    if(pwd.replace(/(^s*)|(s*$)/g, "").length==0 || pwd1.replace(/(^s*)|(s*$)/g, "").length==0 || pwd2.replace(/(^s*)|(s*$)/g, "").length==0){
      alert('请填写完整不可为空！');
    }else{
      if(pwd1==pwd2){
        $.post('checkpassword',{pwd1:pwd1,pwd:pwd,id:id},function(msg){
          if(msg==0){
            alert('原密码错了！');
          }
          if(msg==1){
            alert('更改成功了！');
            window.location.href='logout';
          }
        });
      }else{
        alert('确认密码不一致！');
      }
    }
  }
</script>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2013 &copy; Matrix Admin. More Templates <a href="http://www.mycodes.net/" target="_blank">源码之家</a></div>
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
</body>
</html>
