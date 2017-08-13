<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>登陆</title>
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
</head>

<body>
    <div id="half-background" class="half-background"></div>

    <!-- 导航条 -->
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container" >
            <div class="navbar-header" style="">
                <a class="navbar-brand" href="/">
                    <img src="zpc/images/logo.png" alt="Brand">
                    <img class="logo_font" src="zpc/images/logo_font.png" alt="Brand">
                </a>
            </div>
            <div class="navbar-header" style="float:right;text-align:right;padding-top:15px;">
                <!-- <a href="#">
                    <img src="images/pic10.png" width="50%">
                </a> -->
            </div>

        </div>

    </nav>
    <!-- /导航条 -->

    <div class="main_myhome">
        <div class="main_warp ismy"  id="login">
        <div style="clear:both;width:100%;height:150px;"></div>
        <form method="post" action="/sublogin" id="sublogin">
            <table width="350" align="center">
                <tr>
                    <td width="40" align="center">+86</td>
                    <td width="5" align="center" class="bnone"></td>
                    <td width="200" align="left"><input class="mobile" name="mobile" id="mobile" type="text" value="" placeholder="输入手机号码"  ></td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr id="mobilemsg" style="display:none;">
                    <td colspan="3" class="bnone"  style="height:10px;font-size:12px;line-height:10px;color:#555555;" align="right">请正确输入手机号码</td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td colspan="3" align="left"><input class="pasw" name="pasw" id="pasw" type="text" onfocus="this.type='password'" value="" placeholder="输入密码"  ></td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr id="paswmsg" style="display:none;">
                    <td colspan="3" class="bnone"  style="height:10px;font-size:12px;line-height:10px;color:#555555;" align="right">请正确输入密码</td>
                </tr>
                <tr style="height:20px;"></tr>
                <tr>
                    <td colspan="3" align="center" class="sublogin"><input type="button" onclick="sublogin()" value="登录"></td>
                </tr>
                <tr style="height:5px;"></tr>
                <tr>
                    <td width="40" align="left" class="bnone">
                        <!-- <a href="/pregist" class="forget">注册</a> -->
                    </td>
                    <td colspan="2" align="right" class="bnone">
                        <!-- <a href="/findmm" class="forget">忘记密码？</a> -->
                    </td>
                </tr>
            </table>
        </form>
            
        </div>
    </div>

    <!-- footer -->
    <footer class="footer text-center">
        <p>©2015 北京灵犀一点文化科技有限公司 - 京ICP证123456号 - 京公网安备12345678901234号</p>
    </footer>
    <script type="text/javascript">
    function nokong(m){
        if ($.trim(m)=='') {
            return false;
        }else{
            return true;
        }
    }
    function moblie(n){
        var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
        if (reg.test(n)) {
            return true;
        }else{
            return false;
        }
    }
    function sublogin(){
        var mobile = $("#mobile").val();
        var pasw = $("#pasw").val();
        var mcheck = false;
        var mobilecheck = false;
        var paswcheck = false;
        mcheck = moblie(mobile);
        mobilecheck = nokong(mobile);
        paswcheck = nokong(pasw);
        // alert(mcheck);
        if (mobilecheck==false) {
            $("#mobilemsg td").html('手机号码不可为空！');
            $("#mobilemsg").show();
        }else{
            if (mcheck==false) {
                $("#mobilemsg td").html('手机号码格式错误！');
                $("#mobilemsg").show();
            }else{
                $("#mobilemsg td").html('格式正确！');
            }
        }
        if (paswcheck==false) {
            $("#paswmsg td").html('密码不可为空！');
            $("#paswmsg").show();
        }else{
            $("#paswmsg td").html('');
        }
        


        if (mobilecheck==true && paswcheck==true && mcheck==true) {
            $.post('/sublogin',{m:mobile,n:pasw},function(msg){
                // alert(msg);
                if(msg>0){
                    window.location.href="/home";
                }else{
                    $("#paswmsg td").html('密码与手机号不符！');
                }
            });
        }
        

        // if ($.trim(mobile)=='') {
        //     $("#mobilemsg").show();
        // }else{
        //     if (reg.test(mobile)) {
        //         $("#mobilemsg").hide();
        //         if($.trim(pasw)==''){
        //             $("#paswmsg").show();
        //         }else{
        //             $("#paswmsg").hide();
        //             $('#sublogin').submit();
        //         }
        //     }else{
        //         $("#mobilemsg").show();
        //     }
            
        // }
        
    }
    </script>
</body>

</html>