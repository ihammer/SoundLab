<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="zh-CN"></meta>
    <meta content="telephone=no" name="format-detection">
    <meta name='apple-itunes-app' content='app-id=id991508808'>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" name="viewport">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>SoundLab | 声音实验室</title>
    <link rel="stylesheet" href="zpc/css/bootstrap.css">
    <link rel="stylesheet" href="zpc/css/common_helen.css">
    <link rel="stylesheet" href="zpc/css/upload.css">
    <link rel="stylesheet" href="zpc/css/myself_helen.css">
    <!-- HTML5 shim 让IE9或者更低版本的 IE 浏览器支持 HTML5和媒体查询 -->
    <!-- 主意: 使用file://浏览页面时 Respond.js 无法正常运行  -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.js"></script>
    <![endif]-->
    <script type="text/javascript" src="zpc/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="zpc/js/jquery.easing.1.3.min.js"></script>
    <script type="text/javascript" src="zpc/js/bootstrap.js"></script>
    <script type="text/javascript" src="zpc/js/webuploader.js"></script>
    <script type="text/javascript" src="zpc/js/wavesurfer.min.js"></script><!-- 波形图 -->

    <script type="text/javascript" src="zpc/js/draw.canvas.mycanvas.js"></script>
    <script type="text/javascript" src="zpc/js/myplayer.js"></script>
    <script type="text/javascript" src="zpc/js/imageAnimate.js"></script>
    <script type="text/javascript" src="zpc/js/StackBlur.js"></script>

    <script language="javascript" type="text/javascript">
        $(function(){
            var $ro=$('.right_opus');
            getMoreOpus($ro);
        });
    </script>


    <style>
@charset "utf-8";
body,div,a,span,img,input,form{margin:0;padding:0;}
body{font-family:'Microsoft YaHei';background:#ffffff;background-size:100%;}
a,a:visited{color:#fff;}
a:hover,a:visited{text-decoration:none;}
#main #main_b{width:100%;position:absolute;margin-bottom:1px;z-index:99;}
#main_b input{width:100%;height:45px;background:#98999b;border:0;border-radius:0;font-size:18px;padding-left:10px;padding-top:0px;}
.layer_1_1 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_1 .showbtn_1{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_2 .showbtn_2 img{max-width: 100%; height: auto;}
.layer_1_2 {display:none;z-index:99999;position: fixed; left:0; top:0; bottom:0;width:100%;}
.layer_1_2 .showbtn_2{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=90); -moz-opacity:0.9; -khtml-opacity: 0.9; opacity: 0.9; }
.layer_1_1 .showbtn_1 img{max-width: 100%; height: auto;}
#main{position:relative;}
#main_a{position:relative;margin-bottom:75px;}
#main_a .layer_1{position:relative;width:100%;}
#main_a .layer_1 .showbtn{position:absolute;left:0;top:0;z-index:9999;text-align:center;background:#000;width:100%;height:100%; filter:alpha(opacity=60); -moz-opacity:0.6; -khtml-opacity: 0.6; opacity: 0.6; }
#main_a .layer_1 .showbtn img{margin-top:100px;}
#main_a .layer_1 .zhezhao {position:absolute;left:0;top:0;text-align:center;width:100%;overflow: hidden;height: 100%;}
#main_a .layer_2{position:absolute;left:0;top:0;z-index:9;width:100%;}
#main_a .layer_2 .keyws{padding:5px;}
#main_a .layer_2 .keyws a{display:block;font-size:14px;line-height:13px;text-decoration:none;padding:2px 5px;border:1px solid #fff;color:#fff;float:left;margin-left:5px;}
#main_a .layer_2 .scroll{width:100%;height:100px;padding-top:20px;}
#main_a .layer_2 .scroll .scr_1{height:30px;background:#000000;color:#fff;clear:both;}
#main_a .layer_2 .scroll .scr_1 span{font-size:14px;float:left;line-height:30px;}
#main_a .layer_3{position:absolute;left:0;bottom:-78px;z-index:9;}
#main_a .layer_3 .tit_bg{position:relative;}
#main_a .layer_3 .tit_bg .tit_info{position:absolute;left:0;bottom:90px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_info span{display:block;background:#000;color:#fff;font-size:16px;width:150px;padding:5px 8px;}
#main_a .layer_3 .tit_bg .tit_time{position:absolute;right:10px;bottom:60px;z-index:9;}
#main_a .layer_3 .tit_bg .tit_time span{font-size:12px;}
#main_a .layer_3 .tit_bg .tit_intro{position:absolute;left:0;z-index:9;bottom:10px;}
#main_a .layer_3 .tit_bg .tit_intro span{dispaly:inline-block;float:left;height:29px;line-height:29px;background:#98999b;padding:0px 5px;font-size:12px;color:#fff;margin-right: 5px;margin-bottom: 3px;}
#main_a .layer_3 .tit_bg .tit_muis{min-weight:500px;width:100%;height:55px;clear:both;}
#author{margin-top:0px;
    /*height:100px;*/
    height:101px;
    overflow:hidden;}
#author .author_n{float:left;padding-left:5px;}
#author .author_pl{float:right;padding-right:10px;padding-top:10px;}
#author .author_n span{float:left;font-size:16px;line-height:40px;}
#author .author_n img{display:block;overflow:hidden;}
#author .author_pl span{float:left;font-size:16px;line-height:20px;}
#author .author_pl .num{padding-right:8px;}
#danmu{
    width:100%;
    background-color:#fff;
    z-index:9999;
    background-color: rgba(000, 000, 000, 0);
    overflow:hidden; 
}
#danmu span{
    position:relative;
    font-size:18px;
    background-color:#000;
    color:#fff;
    display:inline-block;
    min-height:20px;height: auto;
    line-height: 20px;

}
#danmu span img{
    width: 20px;height:20px;
   margin:0;padding:0;overflow: hidden; 
}
#iSlider-effect-wrapper {
height: 720px;
width: 540px;
margin: 0;
margin-top:1%;
background: url('test/bg_1.png') no-repeat top center;
background-size: 100%;
overflow: hidden;
position: relative;
}
#animation-effect {
border: 0;
width: 289px;
/*height: 497px;*/
height: 512px;
background-color: #FFFFFF;
/*margin-top: 95px;*/
margin-top: 80px;
}
.iSlider-effect {
overflow: hidden;
position: relative;
margin: 0;
margin-left:126px;
border: 1px solid #FFFFFF;
}
#qr {
text-align:center;
margin:0;
margin-left:20%;
margin-top:12%;
}

.left_warp_player img{padding: 0;}
</style>
<script src="/js/jquery.min.js"></script> 
<script  src="/js/jquery.danmu.js"></script>
</head>

<body>
    <div id="half-background" class="half-background"></div>

    <!-- 导航条 -->
    <nav class="navbar navbar-fixed-top" role="navigation" style="background:#fff;" >
        <div class="container" >
            <div class="navbar-header" style="">
                <a class="navbar-brand" href="/">
                    <img src="zpc/images/logo.png" alt="Brand">
                    <img class="logo_font" src="zpc/images/logo_font.png" alt="Brand">
                </a>

            </div>
            <div class="navbar-header" style="float:right;text-align:right;padding-top:15px;">
                <img class="user_face_img" width="40" height="40" src="http://7xikb7.com1.z0.glb.clouddn.com/<?php echo $users[0]->avatar;?>" />&nbsp;
                 <?php echo $users[0]->username;?>
                 &nbsp;&nbsp;|&nbsp;&nbsp;
                 <a href="/ploginout"><font color="#000">退出</font></a>
                <!-- <a href="plogin">
                    <img src="zpc/images/pic10.png" width="50%">
                </a> -->
            
            </div>

        </div>

    </nav>
    <!-- /导航条 -->
<div style="display:none;"><img width="257px" height="257px" src="<?php echo $works["data"]["cover"];?>" /></div>
<div style="display:none;">
    <audio src="<?php echo $tmpfile["tmpfile"];?>" preload="true" id="video1" hidden></audio>
</div>
    <div class="main_myhome">
        <div class="main_warp_user">
            <div class="user_left" style="width:50%;">
                <div class="user_face">
                    <img class="user_face_img" src="http://7xikb7.com1.z0.glb.clouddn.com/<?php echo $users[0]->avatar;?>" />
                </div>
                <div class="user_info" style="width:390px;">
                    <div class="user_name" id="user_name">
                        <?php echo $users[0]->username;?>
                        <span>
                        <?php echo $users[0]->sex==1?'男':'';?>
                        <?php echo $users[0]->sex==2?'女':'';?>
                        <?php echo $users[0]->sex==0?'外星人':'';?>
                         <?php echo $users[0]->location;?></span>
                    </div>
                    <div class="user_intro" id="user_intro" style="height:20px;overflow:hidden;"><?php echo $users[0]->introduce;?></div>
                    <div class="user_counts">
                        <div class="count_box">
                            <p><?php echo $guanzhu;?></p>
                            <p>关注</p>
                        </div>
                        <div class="count_line"></div>
                        <div class="count_box">
                            <p><?php echo $fensi;?></p>
                            <p>粉丝</p>
                        </div>
                        <div class="count_line"></div>
                        <div class="count_box">
                            <p><?php echo $totalNumber;?></p>
                            <p>作品</p>
                        </div>
                        <!-- <div class="count_line"></div> -->
                        <!-- <div class="count_box">
                            <p></p>
                            <p style="line-height:45px;"><a href="/ploginout"><font color="#000">退出</font></a></p>
                        </div> -->
                        
                    </div>
                </div>
            </div>
            <div class="user_right" style="width:50%;">
                <a style="display:block;width:190px;height:30px;line-height:30px;margin-left:40px;text-align:center;float:left;background:#000;border:none;font-size:14px;" href="/homeupload">编辑作品集</a>
                <a style="display:block;width:190px;height:30px;line-height:30px;margin-left:30px;text-align:center;float:left;border:none;font-size:14px;" href="/homeupload">发布新作品</a>
            </div>
        </div>
        <div class="main_warp ismy">
            <!-- 左侧播放器 -->
            <div class="left_warp_player" style="padding:0 20px;">
            <!-- <img src="zpc/images/bofang.png" width="100%" /> -->


            <div id="main" style="margin-top:20px;overflow:hidden;">
            <div id="main_a">
                <div class="layer_1"  >
                    <span class="showbtn" id="playButton" ><img width="200" id="buttonPlay" onclick='bplay()' height="200" src="/test/helen/6_1.png" /></span>
                    <img width="100%" height="437" style="display:block;margin:0;padding:0;" id="bgImg" src="<?php echo $works["data"]["cover"];?>" />
                    <span class="zhezhao" id="zhezhao"><img width="100%" height="100%" src="zhezhao.png" /></span>
                </div>
                <div class="layer_2">
                        <div class="keyws">
                        <?php
	                        if(count($works["data"]["tags"])!=0){
                            foreach($works["data"]["tags"] as $key=>$item){
                                switch ($item) {
                                    case "音#乐":
                                        $item="音乐";
                                        break;
                                    case "话#题":
                                        $item="话题";
                                        break;
                                    case "谈#话":
                                        $item="谈话";
                                        break;
                                    case "点#评":
                                        $item="点评";
                                        break;
                                    case "读#书":
                                        $item="读书";
                                        break;
                                    case "记#录":
                                        $item="记录";
                                        break;
                                    case "买#卖":
                                        $item="买卖";
                                        break;
                                    default:
                                        break;
                                }
                                echo '<a style="cursor:pointer;margin-top:5px;">'.$item.'</a>';
                            }
                            }
                        ?>
                        </div>
                        <div style="clear:both;"></div>
                        <div id="danmu" style="z-index:9999;">
                            <div id="danmu_1" style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_2"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_3"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_4"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_5"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_6"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_7"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                            <div id="danmu_8"  style="white-space:nowrap;width:100%;width:auto;height:30px;"></div>
                    </div>
                </div>
                <div class="layer_3" id="layer_3" style="width:100%;clear:both;">
                    <div class="tit_bg" style="width:100%;">
                        <div class="tit_muis" style="position:relative;"><img style="display:none;" width="100%" height="100%" src="/test/helen/5.png"></div>
                        <div class="tit_muis" style="position:absolute;bottom:-252px;position:relative;width:50%;height:120px;margin-right:50%;overflow:hidden;">
                            <div id="boxingdown" style="position:absolute;left:100%;height:42px;clear:both;top:31px;white-space:nowrap; overflow:hidden;">
                                <?php if(count($peaks['peaks'])!=0){foreach ($peaks['peaks'] as $k => $v) {?>
                                <div style="float:left;height:42px;display: inline-block;white-space:nowrap; ">
                                    <img style="display: inline-block;margin:0;padding:0;float:left;margin-left:3px;white-space:nowrap; " width="3" height="<?php echo $v*0.6;?>" src="/test/helen/bo.png" />
                                </div>
                                <?php }}?>
                            </div>
                        </div>
                        <div class="tit_muis" style="position:absolute;bottom:-108px;position:relative;width:50%;height:120px;margin-left:50%;overflow:hidden;">
                            <div id="boxingup" style="position:absolute;left:-0%;height:84px;overflow:hidden;top:10px;">
                                <?php if(count($peaks['peaks'])!=0){foreach ($peaks['peaks'] as $k => $v) {?>
                                <div style="float:left;height:84px;line-height:84px;vertical-align:middle;">
                                    <img style="margin:0;padding:0;margin-left:3px;vertical-align:middle;" width="3" height="<?php echo $v*2*0.6;?>" src="/test/helen/bo2.png" />
                                </div>
                                <?php }}?>
                            </div>
                        </div>
                        <div id="positiona" style="position:absolute;position:relative;bottom:-53px;margin-left:52%;left:0%;">
                            <div  class="breathb sizeb2" style="position:absolute;width:8px;height:8px;border:1px solid #ffffff;background:blue;border-radius:5px;float:left;"></div>
                        </div>
                        <div style="position:absolute;bottom:-27px;position:relative;width:100%;height:120px;overflow:hidden;">
                            <div id="positionc" style="position:absolute;left:-0%;height:9px;overflow:hidden;top:10px;margin-left:50%;">
                                <?php $aaa=count($peaks['peaks'])/$works["data"]["duration"]*6;
                                if(count($works["data"]["texts"])!=0){
	                            foreach ($works["data"]["texts"] as $kw => $vw) {
                                    if($kw>0){
                                        $he = $vw['timeline']*$aaa-$hehe;
                                        $hehe = $vw['timeline']*$aaa+5;
                                    }else{ 
                                        $he = ($vw['timeline'])*$aaa;
                                        $hehe = $he+5;
                                    }
                                ?>
                                <div  class="breathb sizeb2" style="float:left;height:8px;height:8px;display:block;">
                                    <img  style="padding:0;margin:0;display:block;margin-left:<?php echo $he;?>px;border:1px solid #ffffff;border-radius:5px;" width="8" height="8" src="/test/helen/bo3.png" />
                                </div>
                                <?php }}?>
                            </div>
                            <div id="positiond" style="position:absolute;left:-0%;height:9px;overflow:hidden;top:23px;margin-left:50%;">
                                <?php $aaat=count($peaks['peaks'])/$works["data"]["duration"]*6;
                                foreach ($works["data"]['timeline'] as $kwt => $vwt) {
                                    if($kwt>0){
                                        $het = $vwt*$aaat-$hehet;
                                        $hehet = $vwt*$aaat;
                                ?>
                                <div  class="breathb sizeb2" style="float:left;height:8px;height:8px;display:block;">
                                    <img  style="padding:0;margin:0;display:block;margin-left:<?php echo $het;?>px;border:1px solid #ffffff;border-radius:5px;" width="8" height="8" src="/test/helen/bo4.png" />
                                </div>
                                <?php
                                    }else{ 
                                        $het = $vwt*$aaat;
                                        $hehet = $het;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tit_info" id="texts"></div>
                        <div class="tit_time">
                            <span><font id="show_time">00'00'</font> | <?php echo $duration;?></span>
                        </div>
                        <?php if(!empty($works["data"]["location"])){?>
                        <div id="positionb" class="tit_intro" style="position:absolute;bottom:32px;background:#98999b;font-size:14px;height:22px;line-height:22px;width:auto;color:#fff;padding:0 5px;margin-left:50%;">
                            位置：<?php echo $works["data"]["location"];?>
                            <!--?php
                                for ($i = 0; $i < count($works['data']['persons']); $i++) {
                                    echo "<span>".$works['data']['persons'][$i]["key"].":".$works['data']['persons'][$i]["name"]."</span>";
                                }
                            ?-->
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            </div>
        
            </div>
            <!-- /左侧播放器 -->
            <!-- 右侧下载信息 -->
            <div class="right_warp_info">
                <div class="right_warp">
                    <div class="right_opus" id="right_opus">
                        <span style="padding-left:10px;font-size:12px;"><b>|</b> 我的作品</span>
                        <div style="height:450px;overflow:hidden;overflow-x:hidden;overflow-y:hidden;">
                        <?php foreach ($worksa as $k => $v) { if($k>=$startCount && $k<$startCount+$perNumber ){?>
                            <div class="durationr" onclick="window.location.href='/homeid?id=<?php echo $v->id;?>&page=<?php echo $page;?>'">
                            <img title="<?php echo $v->title;?>" src="http://7xikb7.com1.z0.glb.clouddn.com/<?php echo $v->cover;?>" >
                            <span class="duration"><font style="float:left;padding-left:5px;"><?php echo mb_substr($v->title, 0 , 5);?><?php if(!empty(mb_substr($v->title, 5 , 1))){echo "...";}?></font><font style="float:right;padding-right:5px;"><?php echo gmstrftime("%M'%S''",$v->duration);?></font></span>
                            <div style="font-size:12px;position: absolute;bottom:5px;left:15px;height:16px;">
                            <img style="display:block;width:13px;height:13px;float:left;margin-left:0;margin-top:1px;margin-right:2px;margin-bottom:0;" src="/test/helen/3.jpg">
                            <span style="display:block;float:left;"><?php echo $v->love_count;?></span>
                            <img style="display:block;width:14px;height:14px;float:left;margin-left:5px;margin-bottom:0;" src="/test/helen/3.png">
                            <span style="display:block;float:left;"><?php echo $v->play_count;?></span>
                            </div>
                            </div>

                        <?php }}?>
                        </div>
                        <?php if(($page)<$totalPage){?>
                        <a class="more" href="/homeid?id=<?php echo !isset($_GET['id'])?1:$_GET['id'];?>&page=<?php echo $page+1;?>" style="margin-right: 25px;">下一页</a>
                        <?php }?>
                        <?php if($page+2<$totalPage+1){?>
                        <a class="more"  style="margin-right:10px;">...</a>
                        <?php }?>
                        <?php if($page+1<$totalPage+1){?>
                        <a class="more" href="/homeid?id=<?php echo !isset($_GET['id'])?1:$_GET['id'];?>&page=<?php echo $page+1;?>" style="margin-right:10px;"><?php echo $page+1;?></a>
                        <?php }?>
                        <a class="more" href="/homeid?id=<?php echo !isset($_GET['id'])?1:$_GET['id'];?>&page=<?php echo $page;?>" style="margin-right:10px;"><font style="font-size:16px;font-weight:900;"><?php echo $page;?></font></a>
                        <?php if($page-1>0){?>
                        <a class="more" href="/homeid?id=<?php echo !isset($_GET['id'])?1:$_GET['id'];?>&page=<?php echo $page-1;?>" style="margin-right:10px;"><?php echo $page-1;?></a>
                        <?php }?>
                        <?php if(($page-1)>0){?>
                        <a class="more" href="/homeid?id=<?php echo !isset($_GET['id'])?1:$_GET['id'];?>&page=<?php echo $page-1;?>" style="margin-right:10px;">上一页</a>
                        <?php }?>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="footer text-center">
        <p>©2015 北京灵犀一点文化科技有限公司 - 京ICP证123456号 - 京公网安备12345678901234号</p>
    </footer>
    <script>
$(function(){
    function formatTime(second){
        return ([parseInt(second / 60),second % 60].join("'")+"'").replace(/\b(\d)\b/g, "0$1");
    };
    $("#danmu").css("height",(screen.width*0.4)+"px");
    var i=0;
    var ii=0;
    var video=document.getElementById("video1");
    setInterval(function(){
        var texts=<?php echo json_encode($works["data"]["texts"]);?>;
        var image=<?php echo json_encode($works["data"]["images"]);?>;
        var timeline=<?php echo json_encode($works["data"]["timeline"]);?>;
        var bgimg=document.getElementById("bgImg");
        var textshow=document.getElementById("texts");
        var showTime=document.getElementById("show_time");
        if(texts!=""){
            if(parseInt(video.currentTime)==texts[i]['timeline']){
                textshow.innerHTML="<span>"+texts[i]['content']+"</span>";
                if(i<(texts.length-1)){
                    i++;
                }
            }
        };
        if(parseInt(video.currentTime)==timeline[ii]){
            bgimg.src=image[ii];
            if(ii<(timeline.length-1)){
                ii++;
            }
        };
        showTime.innerHTML=formatTime(parseInt(video.currentTime));
    },1000);
    var start=0;
    var comment=<?php echo isset($comment["data"])?json_encode($comment["data"]):0;?>;
    // alert(comment.length);
    $("#buttonPlay").click(function(){
        document.getElementById('video1').play();
        // alert(comment.length);
        if(comment.length>0){ 
            if(start==0){
                // alert(comment.length);
                
                for (iii = 0; iii < comment.length; iii++) {
                     tangmu("<img src='"+comment[iii]["avatar"]+"' width='23px' style='position:absolute;margin:0;margin-left:0px;margin-top:0px;margin-bottom:0px;'>&nbsp;&nbsp;&nbsp;&nbsp;"+comment[iii]["content"],iii);
                }
                start++;
            }else{
                for (iii = 0; iii < si.length; iii++) {
                 tangmu1(iii);
                }
            }
        }
        $("#playButton").hide();
        boxing();
    });

    

    $("#bgImg").click(function(){
        $('#danmu').danmu('danmu_pause');
        document.getElementById('video1').pause();
        for (iii = 0; iii < si.length; iii++) {
             clearInterval(si[iii]);
        }
        $("#playButton").show();
        boxingstop();
    });
    $("#danmu").click(function(){
        document.getElementById('video1').pause();
        for (iii = 0; iii < si.length; iii++) {
             clearInterval(si[iii]);
        }
        $("#playButton").show();
        boxingstop();
    });
$("#layer_3").click(function(){
        document.getElementById('video1').pause();
        for (iii = 0; iii < si.length; iii++) {
             clearInterval(si[iii]);
        }
        $("#playButton").show();
        boxingstop();
    });
    
    
    var si=new Array();
    var x=new Array();
    function tangmu(text,j){
        var textStyle="<span id=\"textStyle"+j+"\" style='display:inline-block;position:relative;margin-left:10px;width:1000px;width:auto;word-break:keep-all; white-space:nowrap'>"+text+"&nbsp;&nbsp;&nbsp;&nbsp;</span>";
        var mathHeight = '5px';
        var jj = 1;
        var suiji =  Math.floor(Math.random() * 7 + 1);
        // alert(suiji);
        var textLeft=$('#danmu').innerWidth()+"px";
        if($('#danmu_'+suiji).html()==""){
            var textLeftb=Math.floor(Math.random() * 7 + 1)*10+"px";
            $('#danmu_'+suiji).css("padding-left",textLeftb);
        }
        $('#danmu_'+suiji).html($('#danmu_'+suiji).html()+textStyle);
        $("#textStyle"+j).css("left",textLeft);
        $("#textStyle"+j).css("top",mathHeight);
        x[j]=parseInt($("#textStyle"+j).css("left"));
      si[j] = setInterval(function(){
        x[j]=parseInt($("#textStyle"+j).css("left"));
        document.getElementById("textStyle"+j).style.left=x[j];
        x[j]-=1;
        $("#textStyle"+j).css("left",x[j]+"px");
    },0.1);
    };
    function tangmu1(j){
        si[j] = setInterval(function(){
      x[j]=parseInt($("#textStyle"+j).css("left"));
      document.getElementById("textStyle"+j).style.left=x[j];
      x[j]-=1;
      $("#textStyle"+j).css("left",x[j]+"px");
    },0.1);
    };
});
</script>

<script>
var i = 0;
var miao = '<?php echo $works["data"]["duration"]*10;?>';
var boxingup = "<?php echo count($peaks['peaks'])*6+3;?>";
var kuan = $('.layer_3').width();
var b = kuan/2;
var t;
var sudu = boxingup/miao;
var video=document.getElementById("video1");
function boxing() {
    t=setTimeout(function () {
        i++;
        if ((i*sudu) < boxingup) {
            $("#boxingup").css("left","-"+(i*sudu)+"px");
            $("#positiona").css("left","-"+(i*sudu)+"px");
            $("#positionb").css("left","-"+(i*sudu)+"px");
            $("#positionc").css("left","-"+(i*sudu)+"px");
            $("#positiond").css("left","-"+(i*sudu)+"px");
            if((i*sudu)>=b){
                var pp = (i*sudu)-b;
                $("#boxingdown").css("left","-"+pp+"px");
            }else{
                var p = b-(i*sudu);
                $("#boxingdown").css("left",p+"px");
            }
            i=parseInt(video.currentTime*10);
            boxing();
        }
    }, 100);
}
function boxingstop() 
{ 
clearTimeout(t);
}

function bplay(){
    document.getElementById('video1').play();
    $("#playButton").hide();
    boxing();
}
</script>
</body>

</html>