


<!--Header-start-->
 @include('header')
<!--Header-end-->
<!---leftmenu-start-->
@include('left')
<!---leftmenu-end-->
  
    
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="admin" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">标签</a> </div>
    <h1>标签</h1>
  </div>
  <div class="container-fluid">
  <span><a href="/123xxxadmin/tag?recommand=0" style="<?php echo $recommand==0?'color:#28b779':'';?>">全部</a></span>
  <span><a href="/123xxxadmin/tag?recommand=1" style="<?php echo $recommand==1?'color:#28b779':'';?>">发布话题</a></span>
  <span><a href="/123xxxadmin/tag?recommand=2" style="<?php echo $recommand==2?'color:#28b779':'';?>">发现星标话题</a></span>
  <span><a href="/123xxxadmin/tag?recommand=3" style="<?php echo $recommand==3?'color:#28b779':'';?>">发现可参与话题</a></span>
    <hr>
    <div class="row-fluid">
      <div class="span12">
      			<table >
	            	<tr>
	            		<td style="text-align:center"><input type=text id="utagname" placeholder="输入标签名称"></td>
	            	</tr>
	            </table>
	            <input type="button" onclick="utagadd();" value="添加" class="btn btn-success" style="border-radius:4px;">&nbsp;&nbsp;&nbsp;&nbsp;
	            <input type="button" onclick="utagreset();" value="取消" class="btn" style="border-radius:4px;">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
            <h5>标签列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>标签名称</th>
                  <th>作品数量</th>
                  <th>注册推荐</th>
                  <th>发布话题推荐</th>
                  <th>发现内容推荐</th>
                  <th>发布时推荐</th>
                </tr>
              </thead>
              <tbody>
			  <?php
			  foreach($models as $key=>$items){
			  ?>
                <tr>
                  <td onclick='Javascript:updatetag.call(this);' tagid='<?php echo $items->id;?>'><?php echo $items["attributes"]["name"];?></td>
                  <td style="text-align:center;"> <a href="/123xxxadmin/tag/<?php echo $items->id;?>/tagop"><?php echo $items["attributes"]["count"];?></a></td>
                  <td style="text-align:center;"> <span onclick='Javascript:recommandReg.call(this);' tagid='<?php echo $items->id;?>' style='cursor:pointer;'><?php echo $items["attributes"]["is_recommand3"]==1?"推荐":"不推荐";?></span></td>
                  <td style="text-align:center;"> 
                  <span onclick='Javascript:recommandRel.call(this);' tagid='<?php echo $items->id;?>' style='cursor:pointer;'><?php echo $items["attributes"]["is_recommand1"]==1?"推荐":"不推荐";?></span> ／ 
                  <span onclick='Javascript:recommandRelr.call(this);' tagidr='<?php echo $items->id;?>' style='cursor:pointer;'><?php echo !empty($items->topicDetail)?'有':'没';?>理由<input type="hidden" id="topicDetail_<?php echo $items->id;?>" value="<?php echo $items->topicDetail;?>" /></span>
                  </td>
                  <td style="text-align:center;"> <span onclick='Javascript:recommandCnt.call(this);' tagid='<?php echo $items->id;?>' style='cursor:pointer;'><?php echo $items["attributes"]["is_recommand2"]==1?"推荐":"不推荐";?></span></td>
				  <td style="text-align:center;"> <span onclick='Javascript:recommandFb.call(this);' tagid='<?php echo $items->id;?>' style='cursor:pointer;'><?php echo $items["attributes"]["is_recommand"]==1?"推荐":"不推荐";?></span></td>
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
<div id="overlay">

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
		<input type="button" value="提交" id="subButon">
		<input type="button" value="取消" onclick="delButon()" id="delButon">
	</div>
</div>
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
</style>

<!--Footer-part-->
@include('footer')
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
		if($.trim(uname).length == 0){
			alert('添加的标签名称不为空！');
		}else{
			$.post("/123xxxadmin/tagajaxUtagadd",{"name":uname},function(data){
				if(data==1){
					utagreset();
					history.go(0);
				}
			});
		}
	}
	function utagreset(){
		$("#utagname").val("");
	}
	function recommandFb(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("tagid");
		if(ismusician_text=='推荐'){
			var is_musician=0;
			var spantext="不推荐";
		}else{
			var is_musician=1;
			var spantext="推荐";
		}
		$.post("/123xxxadmin/recommandFb",{id:id,is_recommand:is_musician});
		$(this).text(spantext);
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
	function recommandRelr(){
		var ismusician_text = $(this).text();
		var id=$(this).attr("tagidr");
		var r = $('#topicDetail_'+id).val();
		$('#resid').val(id);
		
			$("#overlay").height(document.body.scrollHeight);
			$("#overlay").width(document.body.scrollWidth);
			$("#reason").html(r);
			$("#overlay").fadeTo(200, 0.5);
			$(".alerts").fadeTo(200,1);
			$("#subButon").click(function(){
				// var is_musician=1;
				// var spantext="推荐";
				var ids = $('#resid').val();
				reason=$("#reason").val();//alert(id);//exit;
				$.post("/123xxxadmin/recommandRelr",{id:ids,reason:reason});
				$("#overlay").fadeOut(200);
				$(".alerts").fadeOut(200);
				history.go(0);exit;
			});
			
		// }
		
	}
	function delButon(){
		$("#overlay").fadeOut(200);
		$(".alerts").fadeOut(200);
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
		$.post("/123xxxadmin/ajaxTag",{id:id,tagname:html});
		$(this).parent().attr("onclick","Javascript:updatetag.call(this);");
		$(this).parent().html(html);
	}
</script>
</body>
</html>