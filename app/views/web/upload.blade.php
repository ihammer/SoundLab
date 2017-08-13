<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>上传音频 图片</title>
    <link rel="stylesheet" href="zpc/css/bootstrap.css">
    <link rel="stylesheet" href="zpc/css/common.css">
    <link rel="stylesheet" href="zpc/css/upload.css">
    <link rel="stylesheet" href="zpc/css/edit.css">
    <style type="text/css">
    .jj_wtime{width:10%;border:none;background:#ce6665;color:#ffffff;float:left;text-align:center;height:30px;line-height:30px;}
    .jj_words{width:80%;border:none;background:#f7f7f8;color:#000;float:left;height:30px;line-height:30px;padding-left: 10px;}
    .jj_borderb1{border-bottom:10px solid #ffffff;}
    .jj_borderb{border-bottom: 1px solid #555555;}
    </style>

    <!-- HTML5 shim 让IE9或者更低版本的 IE 浏览器支持 HTML5和媒体查询 -->
    <!-- 主意: 使用file://浏览页面时 Respond.js 无法正常运行  -->
    <!--[if lt IE 9]>
      <script src="zpc/js/html5shiv.min.js"></script>
      <script src="zpc/js/respond.js"></script>
    <![endif]-->
</head>

<body>
    <div id="half-background" class="half-background"></div>

    <!-- 导航条 -->
    <nav class="navbar navbar-fixed-top" role="navigation" <?php if (empty($mobile)) { ?>style="background:#fff;"<?php }?> >
        <div class="container" >
            <div class="navbar-header" style="">
                <a class="navbar-brand" href="/home">
                    <img src="zpc/images/logo.png" alt="Brand">
                    <img class="logo_font" src="zpc/images/logo_font.png" alt="Brand">
                </a>

            </div>
            <div class="navbar-header" style="float:right;text-align:right;padding-top:15px;">
            <?php if (empty($mobile)) { ?>
                <a href="plogin">
                    <img src="zpc/images/pic10.png" width="50%">
                </a>
            <?php }?>
            </div>

        </div>

    </nav>
    <!-- /导航条 -->
    <div class="main" style="min-height:500px;">
        <!-- 上传 -->
        <div class="uploader">
            <div class="wrap">

                <div class="pill">
                    <div class="left">
                        <div class="box-shadow"></div>
                        <div class="boxwrap">
                            <div class="leftbox">
                                <!--img class="title" src="zpc/images/soundpill_logo_red.jpg" alt=""-->
                                <div class="progress-left text-center">
                                    <div class="logo" id="sound-dragdrop">
                                        <img class="progress-bg" src="zpc/images/progress_left.jpg" alt="">
                                        <img class="uparrow" src="zpc/images/upArrow_left.jpg" alt="">


                                        <!-- 进度条条遮罩 -->
                                        <div class="progress-mask">

                                            <div class="progress-bar-container">
                                            </div>
                                            <!-- <img class="progress-top" src="zpc/images/progress_top_white.jpg" alt=""> -->
                                        </div>
                                        <p class="progress-text">100%</p>
                                    </div>

                                    <!-- 上传音频 -->
                                    <div class="sound-uploader" id="sound-uploader">
                                        <div id="thelist" class="uploader-list"></div>
                                        <div id="soundPicker" class="btn">上传 音频</div>
                                    </div>

                                    <p class="small">支持MP3/WAV/M4V格式的音频</p>
                                    <p class="small">文件大小不超过20M</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="right">
                        <div class="boxwrap">
                            <div class="box-shadow"></div>
                        </div>
                        <div class="rightbox">
                            <div class="progress-right text-center">
                                <div class="logo" id="image-dragdrop">
                                    <img class="progress-bg" src="zpc/images/progress_right.jpg" alt="">
                                    <img class="uparrow" src="zpc/images/upArrow_right.jpg" alt="">


                                    <!-- 进度条条遮罩 -->
                                    <div class="progress-mask">
                                        <!-- 进度条 -->
                                        <div class="progress-bar-container">
                                        </div>
                                        <!-- <img class="progress-top" src="zpc/images/progress_top_red.jpg" alt=""> -->
                                    </div>
                                    <p class="progress-text">100%</p>
                                </div>

                                <!-- 上传图片 -->
                                <div class="image-uploader">
                                    <div class="image-list"></div>
                                    <div id="imagePicker" class="btn">上传 图片</div>
                                </div>
                                <!-- <p><a href="javascript:void(0)" class="btn upload-images">上传 图片</a>
                            </p> -->

                                <p class="small">支持JPG/PNG格式的图片</p>
                                <p class="small">文件大小不超过20M</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 下一步 -->
                <div class="nextstep text-center" id="uploader_next"><a href="#" class="btn next" data-toggle="modal" data-target=".bs-example-modal-lg">下一步</a></div>
            </div>
        </div>
        <!-- /上传 -->
        <div id="mask" class="mask" style="background:none;"></div>
        <!-- 编辑页面 -->
        <div id="edit" class="edit clearfix">
            <!-- 速率控制条 -->
            <div class="speed-slider" style="display:none;">
                <!-- 刻度条 -->
                <div class="label">
                    <p>5</p>
                    <p>4</p>
                    <p>3</p>
                    <p>2</p>
                    <p>1</p>
                </div>
                <!-- 滑动条 -->
                <div class="slider">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="thumb"></div>
                </div>
            </div>
            <!--/速率控制条 -->

            <!-- 主显示区域 -->
            <div class="show-box" style="margin-left:148px;">
                <!-- 图片显示区域 -->
                <div class="stage" id="stage" style="display:none;">
                    <!-- <div class="textEditer">
                        <input type="text">
                    </div> -->
                </div>

                <!-- 播放进度控制条 -->
                <div class="controller">
                    <div class="btns">
                        <i class="iconfont icon icon-play active" style="color:#000000;">&#xe600;</i>
                        <i class="iconfont icon icon-pause " style="color:#000000;">&#xe607;</i>
                    </div>
                    <!-- 波形 -->
                    <div class="wave-bar" id="waveform-container">
                        <!-- <canvas id="waveform-canvas" width="480px" height="60px"></canvas> -->
                    </div>
                </div>
                <!-- /播放进度控制条 -->
                <span class="time">00:00/00:00</span>
                <div class="text-buttons" style="display:none;">
                    <a href="javascript:void(0)" class="btn addComplete" id="ok">
                        <i class="iconfont icon icon-editText ">&#xe60d;</i> 确定
                    </a>
                    <a href="javascript:void(0)" class="btn addText" id="add">
                        <i class="iconfont icon icon-editText ">&#xe60d;</i> 添加
                    </a>
                </div>
            </div>
            <!-- /主显示区域 -->

            <!-- 滤镜效果选择 -->
            <!-- <div class="filter">
                <div class="filter-thumbnail"></div>
                <div class="filter-thumbnail"></div>
                <div class="filter-thumbnail"></div>
                <div class="filter-thumbnail"></div>
                <div class="filter-thumbnail"></div>
            </div> -->
            <!--/滤镜效果选择 -->
            <div class="formtable" style="clear:both;">
                <form action="/123xxxadmin/ccomplate" method="post" id="formwork">
                    <input type="hidden" value="" name="waveform" id="waveform">
                    <input type="hidden" value="" name="totalTime" id="totalTime">
                    <input type="hidden" value="" name="playurl" id="playurl">
                    <table id="table_one" align="center" width="80%" style="margin-top:100px;">
                        <tr style="height:30px;line-height:30px;">
                            <th colspan="3" style="text-align:center;height:50px;line-height:50px;font-size:20px;">添加文字标题</th>
                        </tr>
                        <tr style="height:30px;line-height:30px;background:#eeeeee">
                            <th width="20%" style="text-align:center;">时间</th>
                            <th width="60%" style="text-align:center;">图片</th>
                            <th width="20%" style="text-align:center;">封面</th>
                        </tr>
                    </table>
                    <table id="table_two" align="center" width="80%">
                        <tr style="height:30px;line-height:30px;">
                            <th width="80%" style="text-align:center;height:50px;line-height:50px;font-size:20px;"><a href="javascript:;" >添加文字节点+</a></th>
                        </tr>
                        <tr class="jj_borderb1">
                            <td align="center" class="jj_borderb">
                                <input type="text" value="" name="jj_wtime[]" class="jj_wtime" />
                                <input type="text" class="jj_words" value="" name="jj_words[]" placeholder="在此输入你的文字内容" />
                                <a class="jj_wtime" href="javascript:;" onclick="$(this).parent().parent().remove();" >删除</a>
                            </td>
                        </tr>
                    </table>
                    <table id="table_three" align="center" width="80%">
                        <tr style="height:30px;line-height:30px;">
                            <th width="80%" style="text-align:center;height:50px;line-height:50px;font-size:20px;">添加文字标题</th>
                        </tr>
                        <tr class="jj_borderb1">
                            <td align="center" class="jj_borderb">
                                <input type="text" class="jj_words" style="width:100%" value="" id="title" name="title" placeholder="在此输入标题" />
                            </td>
                        </tr>
                    </table>
                </form>
                <div><a href="javascript:;"  id="Ccomplate">完成</a>
                </div>
            </div>
        </div>
        
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">提示</h4>
          </div>
          <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade in">
                    请检查“<span class="bg-warning">黄色</span>”区域，红色字体提示：<br>
                    1、检查是否为空<br>
                    2、检查是否重复
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">确定</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="myModal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_upload">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel_upload">提示</h4>
          </div>
          <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade in">
                    请检查文件状态：<br>
                    1、是否上传音频、图片<br>
                    2、是否音频、图片已上传完成
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">确定</button>
          </div>
        </div>
      </div>
    </div>
    <!-- footer -->
    <footer class="footer text-center">
        <p>©2015 北京灵犀一点文化科技有限公司 - 京ICP证123456号 - 京公网安备12345678901234号</p>
    </footer>

    <!-- script -->
    <script type="text/javascript" src="zpc/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="zpc/js/jquery.easing.1.3.min.js"></script>
    <script type="text/javascript" src="zpc/js/bootstrap.js"></script>
    <script type="text/javascript" src="zpc/js/webuploader.js"></script>
    <script type="text/javascript" src="zpc/js/wavesurfer.min.js"></script>

    <script type="text/javascript" src="zpc/js/draw.canvas.mycanvas.js"></script>
    <script type="text/javascript" src="zpc/js/upload.js"></script>
    <script type="text/javascript" src="zpc/js/imageAnimate.js"></script>
    <script type="text/javascript" src="zpc/js/StackBlur.js"></script>
    <script type="text/javascript" src="zpc/js/textEditor.js"></script>

</body>

</html>
