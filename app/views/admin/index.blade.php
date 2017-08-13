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
<!--<link href='http://fonts.useso.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>-->
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
        <li><a href="logout"><i class="icon-key"></i> 退出</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="logout"><i class="icon icon-share-alt"></i> <span class="text">退出</span></a></li>
  </ul>
</div>

@include('left')
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
  </div>
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        
        
        <li class="bg_ly"> <a href="user"> <i class="icon-inbox"></i> 用户 </a> </li>
        <li class="bg_lo span3"> <a href="opus"> <i class="icon-th-list"></i> 作品</a> </li>
		    <!--li class="bg_lo"> <a href="topicList"> <i class="icon-th"></i> 专题</a> </li-->
        <li class="bg_lb"> <a href="tag"> <i class="icon-pencil"></i>标签</a> </li>
        <li class="bg_dy"> <a href="audio"> <i class="icon-music"></i>马上鹿</a> </li>
        <?php if($_SESSION["admin_id"]==1){?>
        <li class="bg_lb"> <a href="roleuser"> <i class="icon-pencil"></i>管理员</a> </li>
        <?php }?>
        <!-- <li class="bg_ly span3"> <a href="helps"> <i class="icon-inbox"></i> 用户意见 </a> </li> -->
        <li class="bg_dy"> <a href="scoreelse"> <i class="icon-music"></i>特殊积分</a> </li>
        <li class="bg_dy"> <a href="order"> <i class="icon-th-list"></i>订单管理</a> </li>
      </ul>
    </div>
  <hr/>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12">©2015 北京灵犀一点文化科技有限公司 - 京ICP证123456号 - 京公网安备12345678901234号</div>
</div>
<script src="/js/excanvas.min.js"></script> 
<script src="/js/jquery.min.js"></script> 
<script src="/js/jquery.ui.custom.js"></script> 
<script src="/js/bootstrap.min.js"></script> 
<script src="/js/jquery.flot.min.js"></script> 
<script src="/js/jquery.flot.resize.min.js"></script> 
<script src="/js/jquery.peity.min.js"></script> 
<script src="/js/fullcalendar.min.js"></script> 
<script src="/js/matrix.js"></script> 
<script src="/js/matrix.dashboard.js"></script> 
<script src="/js/jquery.gritter.min.js"></script> 
<script src="/js/matrix.interface.js"></script> 
<script src="/js/matrix.chat.js"></script> 
<script src="/js/jquery.validate.js"></script> 
<script src="/js/matrix.form_validation.js"></script> 
<script src="/js/jquery.wizard.js"></script> 
<script src="/js/jquery.uniform.js"></script> 
<script src="/js/select2.min.js"></script> 
<script src="/js/matrix.popover.js"></script> 
<script src="/js/jquery.dataTables.min.js"></script> 
<script src="/js/matrix.tables.js"></script> 

<script type="text/javascript">
  function goPage (newURL) {
      if (newURL != "") {
          if (newURL == "-" ) {
              resetMenu();            
          } 
          else {  
            document.location.href = newURL;
          }
      }
  }
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
