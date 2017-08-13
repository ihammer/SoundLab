<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="qc:admins" content="24506032244545636" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>上传音频 图片</title>
    <link rel="stylesheet" href=" {{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/css/common.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/css/upload.css') }}">

    <!-- HTML5 shim 让IE9或者更低版本的 IE 浏览器支持 HTML5和媒体查询 -->
    <!-- 主意: 使用file://浏览页面时 Respond.js 无法正常运行  -->
    <!--[if lt IE 9]>
      <script src=" {{ asset('assets/js/html5shiv.min.js') }}"></script>
      <script src=" {{ asset('assets/js/respond.js') }}"></script>
    <![endif]-->
</head>

<body class="upload">
	<div class="half-background"></div>
    <!-- 导航条 -->
    <nav class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/logo_2x.jpg') }}" alt="Brand">
                </a>
            </div>
        </div>
    </nav>
    <!-- /导航条 -->
    <div class="main">
        @yield('content')
        <!-- footer -->
        <footer class="footer text-center">
            <p>©2015 北京灵犀一点文化科技有限公司 - 京ICP证123456号 - 京公网安备12345678901234号</p>
        </footer>
    </div>

    <!-- script -->
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/webuploader.js"></script>
    <script type="text/javascript" src="js/upload.js"></script>
</body>

</html>