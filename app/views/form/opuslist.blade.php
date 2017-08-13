<!--Header-start-->
 @include('header')
<!--Header-end-->
<!---leftmenu-start-->
@include('left')
<!---leftmenu-end-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">作品</a> </div>
    <h1>作品</h1>
  </div>
  <div class="container-fluid">
  	<span><a href="/123xxxadmin/opus/newlist">最新作品列表</a>&nbsp;
  	      <a href="/123xxxadmin/opus<?php echo $labx==0 ? "?labx=1" : "";?>"><?php echo $labx==0 ? "LabX列表" : "所有作品";?></a>&nbsp;
  	      <a href="/123xxxadmin/opus?dm=1">声点作品列表</a>&nbsp;
  	      <a href="/123xxxadmin/opus?top=1">置顶作品列表</a>
        <!--- &nbsp;<a href="/123xxxadmin/opus?playcount=1">按照播放量排序</a>-->&nbsp;
        <!-- <a href="/123xxxadmin/opus?applylabx=1">LABx申请</a>-->
	 </span>
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
            <h5>作品列表</h5>&nbsp;&nbsp;&nbsp;&nbsp;<span id="bf" hight='10px'></span><audio  controls="controls" src="">您的浏览器不支持 audio 标签</audio>
			  <form style="float:right; margin-top:3px;" action="<?php echo $url ?>" method="get" class="form-horizontal" >
				  <?php foreach ($get_data as $getKey=>$getVal){?>
						<?php if(!empty($getVal)){?>
					  <input type="hidden" name="<?php echo $getKey?>" value="<?php echo $getVal; ?>"/>
				  <?php } }?>
				  <input type="text" name="create_start" style="width: 140px;" value="<?php echo $create_start?$create_start:'';?>" placeholder="开始时间：0000-00">
				  <input type="text" name="create_end" style="width: 140px;" value="<?php echo $create_end?$create_end:'';?>" placeholder="结束时间：0000-00">
				  <input type="text" name="keywords" style="width: 140px;" value="<?php echo $keywords?$keywords:'';?>"placeholder="关键字">
				  <input type="submit" value="搜索" class="btn btn-success" >
			  </form>
          </div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="width:80px;">作品名称</th>
				 <th style="width:40px;"><a <?php if($order=='play_count'){echo "style='color:#3399ff;'";}?> href="<?php echo $url_s.'&order=play_count&sort=';?><?php if($order=='play_count'){if($sort=='desc'){echo 'asc';}else{echo 'desc';}}else{echo 'desc';} ?>">播放量</a></th>
                  <th style="width:40px;">播放</th>
                  <th style="width:60px;">用户名称</th>
                  <?php echo $labx==1 ? "" : "<th style='width:80px;'>私有公开</th>";?>
                  <?php echo $labx==1 ? "<th style='width:80px;'>LabX分类</th>" : "";?>
				  <th style="width:40px;"><a <?php if($order=='love_count'){echo "style='color:#3399ff;'";}?> href="<?php echo $url_s.'&order=love_count&sort=';?><?php if($order=='love_count'){if($sort=='desc'){echo 'asc';}else{echo 'desc';}}else{echo 'desc';} ?>">点赞量</a></th>
				  <th style="width:40px;"><a <?php if($order=='comments_count'){echo "style='color:#3399ff;'";}?> href="<?php echo $url_s.'&order=comments_count&sort=';?><?php if($order=='comments_count'){if($sort=='desc'){echo 'asc';}else{echo 'desc';}}else{echo 'desc';} ?>">弹幕量</a></th>
                  <th style="width:60px;"><a <?php if($order=='created_at'){echo "style='color:#3399ff;'";}?> href="<?php echo $url_s.'&order=created_at&sort=';?><?php if($order=='created_at'){if($sort=='desc'){echo 'asc';}else{echo 'desc';}}else{echo 'desc';} ?>">上传时间</a></th>
                  <th style="width:80px;">首页推荐</th>
                  <th style="width:80px;">LabX分类推荐</th>
                  <!--<th style="width:80px;">Labx推荐</th>-->
                  <th style="width:80px;">声点推荐</th>
                  <th style="width:120px;">操作</th>
                </tr>
              </thead>
              <tbody>
			  <?php
			  
			  foreach($models as $key=>$items){
			  ?>
                <tr>
                  <td>
                  <?php echo $items->title;?>
   					<a target="_blank" style="color:green;text-decoration:underline;"  href="http://v.t.sina.com.cn/share/share.php?url=<?php echo 'http://pillele.cn/play.php?id='.$items->id; ?>&amp;title='<?php echo $items->title;?>'&amp;pic=<?php echo 'http://7xikb7.com1.z0.glb.clouddn.com/'.$items->cover;?>"><br/>分享到新浪微博</a>
                  </td>
                  <td style="text-align:center;"><?php echo  $items->play_count; ?></td>
                  <td style="text-align:center;"> <a href="javascript:void (0);" onclick="audioPlay('<?php echo $host.$items->playurl;?>','<?php echo $items->title;?>')"> 播放</a> </td>
                  <td style="text-align:center;"><?php echo $items->uname;?></td>
                  <?php if($labx!=1){?><td><?php echo $items->is_private==0 ? "公开" : "私有";?></td><?php } ?>
                  <?php echo $labx==1 ? "<td>".($items->type_id==0 ? 0 : $labtype[$items->type_id])."</td>" : "";?>
				  <td style="text-align:center;"><?php echo $items->love_count;?></td>
				  <td style="text-align:center;"><?php echo $items->comments_count;?></td>
				  <td style="text-align:center;"><?php echo $items->created_at;?></td>
				  <td style="text-align:center;">
					<?php if($items->top_sort==1){echo "<span class='isrecommend' id='".$items->id."' onclick='Javascript:return recommendtop_sort.call(this);' style='cursor:pointer;'>取消推荐</span>";}else{echo "<span class='isrecommend' id='".$items->id."'  onclick='Javascript:recommendtop_sort.call(this);' style='cursor:pointer;'>推荐</span>";}?>
				  </td>
					<td style="text-align:center;"><?php if($items->is_compshowtype==1){
                            echo "<span onclick='Javascript:compaigntypeBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>取消分类</span>";
                        }else{
                            echo "<span onclick='Javascript:compaigntypeBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>推荐分类</span>";
                        };?></td>
				  <!--
				  <td style="text-align:center;">
					<?php if($items->is_compshow==1){
				  		echo "<span onclick='Javascript:compaignBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>取消banner</span><br><br>"; 
				  		if($items->is_compshowtype==1){
				  			echo "<span onclick='Javascript:compaigntypeBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>取消分类</span>";
				  		}else{
				  			echo "<span onclick='Javascript:compaigntypeBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>推荐分类</span>";
				  		}
				  	}else{
				  		echo "<span onclick='Javascript:compaignBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>推荐banner";
				  	}?>
				  </td>
				  -->
				  <td style="text-align:center;">
					 <?php if($items->is_recommend==1){echo "<span class='isrecommend' id='".$items->id."' onclick='Javascript:return recommendBut.call(this);' style='cursor:pointer;'>取消推荐</span>";}else{echo "<span class='isrecommend' id='".$items->id."' onclick='Javascript:recommendBut.call(this);' style='cursor:pointer;'>推荐</span>";}?>
				  </td>
				  <td style="text-align:center;">					 
				  	<!--<?php if($items->is_contshow==1){echo "<span onclick='Javascript:contentBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>内容推荐(OUT)</span>";}else{echo "<span onclick='Javascript:contentBut.call(this);' workid='".$items->id."' style='cursor:pointer;'>内容推荐(IN)</span>";}?>&nbsp;&nbsp;-->
				  <span onclick='Javascript:tagBut.call(this);' workid='<?php echo $items->id;?>' style='cursor:pointer;'>编辑标签</span>&nbsp;&nbsp;<span onclick='Javascript:pushBut.call(this);' workid='<?php echo $items->id;?>' style='cursor:pointer;'>推送曲目</span>
				  	&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="del_confirm(<?php echo $items->id; ?>);">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<!-- <a href="/123xxxadmin/opus/<?php echo $items->id; ?>/edit">编辑</a> -->
				  	 <?php  if($applylabx==1){ ?>
                          <a href="/123xxxadmin/opus/<?php echo $items->id; ?>/edit">LABx审核</a>
                       <?php }else{ ?>
                          <a href="/123xxxadmin/opus/<?php echo $items->id; ?>/edit">编辑</a>
                      <?php }?>

				  	</td>
                </tr>
			  <?php
			  }
			  ?>
              </tbody>
            </table>
          </div>
          <?php echo $models->appends(['top'=>$top,"labx"=>$labx,"applylabx"=>$applylabx,"dm"=>$dm,"keywords"=>$keywords])->links();?>
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
		编辑标签
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
<div class="alertsComp">
	<div class="alert_tit">
		LabX信息
	</div>
	<div class="content">
		<table>
			<tbody><tr>
				<td width="100%" align="center">
					LabX截止时间<input id="comptime" type="text">
				</td>
			</tr><tr>
				<td width="100%" align="center">
					LabX销售价格<input id="price" type="text">
					<input type="hidden" id="compid" value="">
				</td>
			</tr>
		</tbody></table>
	</div>
	<div class="buton" style="text-align:center;">
		<input type="button" value="提交" id="subComp">
	</div>
</div>
<div class="alertPush">
	<div class="alert_tit">
		推送曲目
	</div>
	<div class="content">
		<table>
			<tbody><tr>
				<td width="100%" align="center">
					<textarea id="pushcontent" style="width:535px;height:200px"></textarea>
					<input type="hidden" id="pushid" value="">
				</td>
			</tr>
		</tbody></table>
	</div>
	<div class="buton" style="text-align:center;">
		<input type="button" value="提交" id="subPush">&nbsp;&nbsp;<input type="button" id="resPush" value="返回">
	</div>
</div>
<div class="alerts">
	<div class="alert_tit">
		编辑推荐理由
	</div>
	<div class="content">
		<table>
			<tbody><tr>
				<td width="100%" align="center">
					<textarea id="reason" style="width:535px;height:200px"></textarea>
					<input type="hidden" id="resid" value="">
				</td>
			</tr>
		</tbody></table>
	</div>
	<div class="buton" style="text-align:center;">
		<input type="button" value="提交" id="subButon">&nbsp;&nbsp;<input type="button" id="resButon" value="返回">
	</div>
</div>
<!--end-Footer-part-->
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
.alertsComp {
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
.alertsComp .alert_tit {
width: 548px;
height: 40px;
background: #51a9f1;
border: 1px solid #7dbef4;
line-height: 40px;
color: #ffffff;
text-indent: 20px;
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
.alertPush {
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
.alertPush .alert_tit {
width: 548px;
height: 40px;
background: #51a9f1;
border: 1px solid #7dbef4;
line-height: 40px;
color: #ffffff;
text-indent: 20px;
}
</style>
<script src="/js/jquery.min.js"></script> 
<script src="/js/jquery.ui.custom.js"></script> 
<script src="/js/bootstrap.min.js"></script> 
<script src="/js/jquery.uniform.js"></script> 
<script src="/js/select2.min.js"></script> 
<script src="/js/jquery.dataTables2.min.js"></script> 
<script src="/js/matrix.js"></script> 
<script src="/js/matrix.tables.js"></script>
<script type="text/javascript">
	 function audioPlay (src,title) {

	    var audio = document.getElementsByTagName('audio')[0];
	    var bf = $('#bf');
	    bf.html(title);
	
	    audio.src = src ;
	    audio.play();
	
	}
	
	 function playurlBut(){
      var id=$(this).attr("workid");

    $.post("/123xxxadmin/getplayurl",{id:id});
   }

        function recommendtop_sort(){
        var ismusician_text = $(this).text();
        var id=$(this).attr("id");
        if(ismusician_text=='取消推荐'){
            var top_sort=0;
            var spantext="推荐";
        }else{
            var top_sort=1;
            var spantext="取消推荐";
        }
        $.post("/123xxxadmin/top_sort",{id:id,top_sort:top_sort});
        $(this).text(spantext);
    }
    

	function tagBut(){
		var id=$(this).attr("workid");
		$("#tagid").val($(this).attr("workid"));
		$.get("/123xxxadmin/getWorkTag?id="+id,function(data){
			$("#tag").val(data);
		});
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
			$.post("/123xxxadmin/uptag",{id:$("#tagid").val(),tag:tagVal});
		});
		$("#tag").val('');
	}
	
	function compaignBut(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("workid");
		if(ismusician_text=='取消banner'){
			var is_musician=0;
			var spantext="推荐banner";
		}else{
			var is_musician=1;
			var spantext="取消banner";
/*
			$("#compid").val($(this).attr("workid"));
			$("#overlay").height(document.body.scrollHeight);
			$("#overlay").width(document.body.scrollWidth);
			$("#overlay").fadeTo(200, 0.5);
			$(".alertsComp").fadeTo(200,1);
			$("#subComp").click(function(){
				$("#overlay").fadeOut(200);
				$(".alertsComp").fadeOut(200);
				var comptime=$("#comptime").val();
				var price=$("#price").val();
				$.post("/123xxxadmin/iscompshow",{id:$("#compid").val(),is_compshow:1,comptime:comptime,price:price},function(data){if(data==1){$("#comptime").val('');$("#price").val('');return;}});
			});
			$(this).text(spantext);
*/
		}
		$.post("/123xxxadmin/iscompshow",{id:id,is_compshow:is_musician});
		$(this).text(spantext);
		
		window.location.reload();
		
	}

	
	function compaigntypeBut(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("workid");
		if(ismusician_text=='取消分类'){
			var is_musician=0;
			var spantext="推荐分类";
			$.post("/123xxxadmin/iscompshowtype",{id:id,is_compshowtype:is_musician});
			$(this).text(spantext);
		}else{
			var is_musician=1;
			var spantext="取消分类";
			$.post("/123xxxadmin/iscompshowtype",{id:id,is_compshowtype:1});
			
			// $("#compid").val($(this).attr("workid"));
			// $("#overlay").height(document.body.scrollHeight);
			// $("#overlay").width(document.body.scrollWidth);
			// $("#overlay").fadeTo(200, 0.5);
			// $(".alertsComp").fadeTo(200,1);
			// $("#subComp").click(function(){
			// 	$("#overlay").fadeOut(200);
			// 	$(".alertsComp").fadeOut(200);
			// 	$.post("/123xxxadmin/iscompshowtype",{id:$("#compid").val(),is_compshowtype:1},function(data){if(data==1){$("#comptime").val('');$("#price").val('');return;}});
			// });
			$(this).text(spantext);
		}
		
	}

	function pushBut(){
		var id=$(this).attr("workid");
		$("#pushid").val($(this).attr("workid"));
		$("#overlay").height(document.body.scrollHeight);
		$("#overlay").width(document.body.scrollWidth);
		$("#overlay").fadeTo(200, 0.5);
		$(".alertPush").fadeTo(200,1);
		$("#resPush").click(function(){
			$("#overlay").fadeOut(200);
			$(".alertPush").fadeOut(200);
		});
		$("#subPush").click(function(){
			$("#overlay").fadeOut(200);
			$(".alertPush").fadeOut(200);
			var pushcontent=$("#pushcontent").val();
			if(pushcontent!=""){
				$.post("/123xxxadmin/workpush",{id:$("#pushid").val(),content:pushcontent},function(data){if(data==1){$("#pushcontent").val('');return;}});
			}
		});
	}
	
	function del_confirm(i)
	{
		var r=confirm('你确定要删除这个作品吗？');
		if (r==true)
	  {
	  	location.href="/123xxxadmin/delopus?id="+i;
	  }
	}
	function recommendBut(){
		var isrecommend_text = $(this).text();
		$.get("/123xxxadmin/getreason?id="+$(this).attr("id"),function(reason){$("#reason").val(reason);});
		if(isrecommend_text=='取消推荐'){
			reason=$("#reason").val();
			var id=$(this).attr("id");
			var is_recommend=0;
			var spantext="推荐";
			//$(this).recommendFun(id,is_recommend,reason);$(this).text(spantext);
			$.post("/123xxxadmin/isrecommend",{id:id,is_recommend:is_recommend,reason:reason});
			$("#"+id).text(spantext);
			window.location.reload();
		}else {
			var is_recommend=1;
			
			$("#overlay").height(document.body.scrollHeight);
			$("#overlay").width(document.body.scrollWidth);
			
			$("#resid").val($(this).attr("id"));
			$("#overlay").fadeTo(200, 0.5);
			$(".alerts").fadeTo(200,1);

			$("#resButon").click(function(){$("#overlay").fadeOut(200);$(".alerts").fadeOut(200);});
			$("#subButon").click(function(){
				var resid=$("#resid").val();
				var reason=$("#reason").val();
				//$("#"+id).recommendFun(id,is_recommend,reason);
				$.post("/123xxxadmin/isrecommend",{id:resid,is_recommend:is_recommend,reason:reason});
				$("#"+resid).text("取消推荐");
				$("#overlay").fadeOut(200);
				$(".alerts").fadeOut(200);
				window.location.reload();
			});
		}
		
	}
	function musicianBut(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("workid");
		if(ismusician_text=='音乐人曲目(OUT)'){
			var is_musician=0;
			var spantext="音乐人曲目(IN)";
		}else{
			var is_musician=1;
			var spantext="音乐人曲目(OUT)";
		}
		$.post("/123xxxadmin/ismusician",{id:id,is_musician:is_musician});
		$(this).text(spantext);
	}
	function contentBut(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("workid");
		if(ismusician_text=='内容推荐(OUT)'){
			var is_musician=0;
			var spantext="内容推荐(IN)";
		}else{
			var is_musician=1;
			var spantext="内容推荐(OUT)";
		}
		$.post("/123xxxadmin/iscontshow",{id:id,is_contshow:is_musician});
		$(this).text(spantext);
	}
	
</script>
</body>
</html>
