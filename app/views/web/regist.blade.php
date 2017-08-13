<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>个人主页</title>
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
                <a class="navbar-brand" href="/home">
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

    <div class="main_myhome" id="regist1">
        <div class="main_warp ismy"  id="login">
        <div style="clear:both;width:100%;height:150px;"></div>
        <form>
            <table width="350" align="center">
                
                <tr>
                    <td width="40" align="center">+86</td>
                    <td width="5" align="center" class="bnone"></td>
                    <td width="205" colspan="3" align="left"><input class="mobile" type="text" value="" placeholder="输入手机号码"></td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td colspan="3" width="200"  align="center">
                        <input  type="text" value="" class="sryzm" placeholder="输入验证码">
                    </td>
                    <td width="5" align="center" class="bnone"></td>
                    <td colspan="1" width="180" align="center">
                        <input class="getyzm" type="button" value="获取验证码">
                    </td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td colspan="5" align="left"><input class="pasw" type="password" value="" placeholder="输入密码"></td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td colspan="5" align="left"><input class="pasw2" type="password" value="" placeholder="确认密码"></td>
                </tr>
                <tr style="height:20px;"></tr>
                <tr>
                    <td colspan="5" align="center" class="sublogin"><input type="submit" value="注册"></td>
                </tr>
                <tr style="height:5px;"></tr>
                <tr>
                    <td width="40" colspan="2" align="left" class="bnone">
                        <a href="plogin" class="forget">登陆</a>
                    </td>
                    <td colspan="3" align="right" class="bnone">
                        <a href="javascript:;" onclick="$('#regist2').show();$('#regist1').hide();$('#regist3').hide();" class="forget">下一步</a>
                    </td>
                </tr>
            </table>
        </form>
            
        </div>
    </div>

    <div class="main_myhome" id="regist2" style="display:none;">
        <div class="main_warp ismy"  id="login">
        <div style="clear:both;width:100%;height:80px;"></div>
        <form>
            <table width="350" align="center">
                <tr>
                    <td width="60" colspan="5" align="center" class="bnone"><img width="120" src="zpc/images/photo.png"></td>
                </tr>
                <tr style="height:30px;"></tr>
                <tr>
                    <td width="60" align="center" class="bnone text">昵称</td>
                    <td width="5" align="center" class="bnone"></td>
                    <td width="205" colspan="3" align="left"><input class="pdl10" type="text" value="" placeholder="请输入昵称"></td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td width="60" align="center" class="bnone text">性别</td>
                    <td width="5" align="center" class="bnone"></td>
                    <td width="205" colspan="3" align="left">
                    <select>
                        <option>外星人</option>
                        <option>男</option>
                        <option>女</option>
                    </select>
                    </td>
                </tr>
                <tr style="height:10px;"></tr>
                <tr>
                    <td width="60" align="center" class="bnone text">地区</td>
                    <td width="5" align="center" class="bnone"></td>
                    <td width="205" colspan="3" align="left">
                    <select class="mobile">
                        <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;未设置</option>
                        <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;北京 东城区</option>
                        <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;北京 昌平区</option>
                    </select>
                    </td>
                </tr>
                <tr style="height:20px;"></tr>
                <tr>
                    <td colspan="5" align="center" class="sublogin"><input type="submit" value="注册"></td>
                </tr>
                <tr style="height:5px;"></tr>
                <tr>
                    <td width="40" colspan="2" align="left" class="bnone">
                        <a href="login.html" class="forget">登陆</a>
                    </td>
                    <td colspan="3" align="right" class="bnone">
                        <a href="javascript:;" onclick="$('#regist2').hide();$('#regist1').hide();$('#regist3').show();" class="forget">下一步</a>
                    </td>
                </tr>
            </table>
        </form>
            
        </div>
    </div>

    <div class="main_myhome" id="regist3" style="display:none;">
        <div class="main_warp ismy"  id="login">
        <div style="clear:both;width:100%;height:80px;"></div>
        <form>
            <table width="350" align="center">
                <tr style="height:200px;border-bottom:1px solid #989696;">
                    <td width="60" colspan="5" align="left" class="bnone">
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                     <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                     <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    <input class="bblack" type="text" value="音乐" />
                    <input class="bblack" type="text" value="电影" />
                    </td>
                </tr>
                <tr style="height:20px;"></tr>
                <tr>
                    <td width="60" colspan="5" align="left" class="bnone">
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    <input class="bblack2" type="text" value="音乐" />
                    <input class="bblack2" type="text" value="电影" />
                    </td>
                </tr>
                
                <tr style="height:20px;"></tr>
                <tr>
                    <td colspan="5" align="center" class="sublogin"><input type="submit" value="完成"></td>
                </tr>
                <tr style="height:5px;"></tr>
                <tr>
                    <td width="40" colspan="2" align="left" class="bnone">
                        <!-- <a href="/plogin" class="forget">登陆</a> -->
                    </td>
                    <td colspan="3" align="right" class="bnone">
                       
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
</body>

</html>