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
    <!--li class="submenu"><a href="#"><i class="icon icon-th"></i> <span>专题</span></a>
	  <ul>
        <li>{{ link_to_route('123xxxadmin.topic.index', '专题列表') }}</li>
        <li>{{ link_to_route('123xxxadmin.topic.create', '添加专题') }}</li>
      </ul>
	</li-->
    <li class="active submenu open"><a href="#"><i class="icon icon-pencil"></i> <span>标签</span></a>
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
    <div id="breadcrumb"> <a href="admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">人物标签</a> </div>
    <h1>人物标签</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
      			<table >
	            	<tr>
	            		<td style="text-align:center"><input type=text id="utagname" placeholder="输入人物标签名称"></td>
	            		<td style="text-align:center">
	            			<select name="utagisadmin" id="utagisadmin">
	            				<option value="0">非小编标签</option>
	            				<option value="1">是小编标签</option>
	            			</select>
	            			<!-- <input type=radio value=0 name="utagisadmin" checked=1>不是小编标签&nbsp;&nbsp;&nbsp;&nbsp;
	            			<input type=radio name="utagisadmin" id="utagisadmin" value=1>是小编标签 -->
	            		</td>
	            	</tr>
	            </table>
	            <input type="button" onclick="utagadd();" value="添加" class="btn btn-success" style="border-radius:4px;">&nbsp;&nbsp;&nbsp;&nbsp;
	            <input type="button" onclick="utagreset();" value="取消" class="btn" style="border-radius:4px;">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
            <h5>人物标签列表</h5>
          </div>
          <div class="widget-content nopadding">
          	
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>人物标签名称</th>
                  <th>是否为小编标签</th>
                  <!-- <th>操作</th> -->
                </tr>
              </thead>
              <tbody>
			  <?php
			  foreach($models as $key=>$items){
			  	//print_r($items);die;
			  ?>
                <tr>
                  <td onclick='Javascript:updatetag.call(this);' tagid='<?php echo $items->id;?>'><?php echo $items->name;?></td>
                  <td><?php echo $items->isadmin==0 ? "非小编标签" : "小编标签";?></td>
				  				<!-- <td style="text-align:center;"></td> -->
                </tr>
			  <?php
			  }
			  ?>
              </tbody>
            </table>
          </div>
         <!--  <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
            <h5>添加人物标签</h5>
          </div>
          <div>
	          	<table class="table table-bordered data-table">
	            	<tr>
	            		<td style="text-align:center">人物标签名称</td>
	            		<td style="text-align:center"><input type=text id="utagname"></td>
	            		<td style="text-align:center">是否为小编标签</td>
	            		<td style="text-align:center"><input type=radio value=0 name="utagisadmin" checked=1>否&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="utagisadmin" id="utagisadmin" value=1>是</td>
	            		<td style="text-align:center"><input type="button" onclick="utagadd();" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="utagreset();" value="取消"></td>
	            	</tr>
	            </table>
          </div>
        </div> -->
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
<script src="/js/jquery.dataTables2.min.js"></script> 
<script src="/js/matrix.js"></script> 
<script src="/js/matrix.tables.js"></script>
<script type="text/javascript">
	function utagadd(){
		var uname = $("#utagname").val();
		var isadmin = $("#utagisadmin").val();
		if($.trim(uname).length == 0){
			alert('添加的标签名称不为空！');
		}else{
			$.post("/123xxxadmin/ajaxUtagadd",{"name":uname,"isadmin":isadmin},function(data){
				if(data==1){
					utagreset();
					history.go(0);
				}
			});
		}
	}
	function utagreset(){
		$("#utagname").val("");
		$("#utagisadmin option:first").prop("selected", 'selected');
		// $("input[name=utagisadmin]:eq(0)").attr("selected",'selected');
	}
	function recommandReg(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("tagid");
		if(ismusician_text=='推荐'){
			var is_musician=0;
			var spantext="不推荐";
		}else{
			var is_musician=1;
			var spantext="推荐";
		}
		$.post("/123xxxadmin/recommandReg",{id:id,is_recommand:is_musician});
		$(this).text(spantext);
	}
	function recommandRel(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("tagid");
		if(ismusician_text=='推荐'){
			var is_musician=0;
			var spantext="不推荐";
		}else{
			var is_musician=1;
			var spantext="推荐";
		}
		$.post("/123xxxadmin/recommandRel",{id:id,is_recommand1:is_musician});
		$(this).text(spantext);
	}
	function recommandCnt(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("tagid");
		if(ismusician_text=='推荐'){
			var is_musician=0;
			var spantext="不推荐";
		}else{
			var is_musician=1;
			var spantext="推荐";
		}
		$.post("/123xxxadmin/recommandCnt",{id:id,is_recommand2:is_musician});
		$(this).text(spantext);
	}
	function updatetag(){
		var id=$(this).attr("tagid");
		var html=$(this).html();
		$(this).attr("onclick","");
		$(this).html("<input type='text' onkeypress='javascript:if (event.keyCode == 13) subtag.call(this);' tagid='"+id+"' value='"+html+"'>");
	}
	function subtag(){
		var id=$(this).attr("tagid");
		var html=$(this).val();
		$.post("/123xxxadmin/ajaxUtag",{id:id,tagname:html});
		$(this).parent().attr("onclick","Javascript:updatetag.call(this);");
		$(this).parent().html(html);
	}
</script>
</body>
</html>