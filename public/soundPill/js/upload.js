$(document).ready(function() {
    // var SoundServer_URL = 'http://app.dev/api/upload/sound';
    // var ImageServer_URL = 'http://dev.capsule.com/api/upload/image';

    var SoundServer_URL = '/123xxxadmin/upfile?type=1';
    var ImageServer_URL = '/123xxxadmin/upfile?type=2';
    

    // 百分比文本
    var $soundProgressText = $('.left .progress-text').hide();
    var $imageProgressText = $('.right .progress-text').hide();

    // 向上箭头,上传中需要隐藏
    // $upArrow = $(".uparrow")

    // 进度条遮罩
    var maskHeight = $(".left .progress-mask").height();
    var $soundPrgressMask = $(".left .progress-mask").height(0);
    var $imagePrgressMask = $(".right .progress-mask").height(0);


    var controller = {};
    WaveSurfer.util.extend(controller, WaveSurfer.Observer);

    // 添加的图片文件数量
    var fileCount = 0,

        // 添加的图片文件总数
        fileSize = 0,

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 110 * ratio,
        thumbnailHeight = 110 * ratio,

        // 可能有pedding, ready, uploading, confirm, done.
        state = 'pedding',

        // 所有文件的进度信息，key为file id
        percentages = {};

    // 波形控制器
    var wavesurfer = Object.create(WaveSurfer);

    // 滑动条刻度标签
    var repeatValue = ["5.0", "4.0", "3.0", "2.0", "1.0"];
    // 图片动画重复次数
    var defaultImageRepeatCount = repeatValue[2];

    //速度滑动条
    // var speedSlider = $(".slider").get(0);
    // WaveSurfer.util.extend(speedSlider, WaveSurfer.Observer);
    

    // 音频上传
    var soundUploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '/swf/Uploader.swf',

        // 文件接收服务端。
        server: SoundServer_URL,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {
            id: '#soundPicker',
            multiple: false
        },

        // 只允许选择音频文件
        accept: {
            title: 'Audio',
            extensions: 'mp3,ogg',
            mimeTypes: 'audio/*'
        },

        // drag and drop 启动拖拽的容器
        dnd: "#sound-dragdrop",
        // 单个音频限制在20M以内, 验证单个文件大小是否超出限制, 超出则不允许加入队列。
        fileSingleSizeLimit: 20971520
    });

    // 当有文件被添加进队列的时候
    soundUploader.on('fileQueued', function(file) {
        console.log(file.name, file.size, file.type)
        $(".leftbox").append('<p class="info">' + file.name + '</p>');
        /*$list.append( '<div id="' + file.id + '" class="item">' +
            '<h4 class="info">' + file.name + '</h4>' +
            '<p class="state">等待上传...</p>' +
        '</div>' );*/
    });


    // 文件上传过程中创建进度条实时显示。
    soundUploader.on('uploadProgress', function(file, percentage) {
        // $li.find('p.state').text('上传中');
        $soundPrgressMask.height(percentage * maskHeight);
        $soundProgressText.show().text(parseInt(percentage * 100) + '%');

    });


    // 发送成功则派送uploadSuccess事件
    soundUploader.on('uploadSuccess', function(file, response) {
        // $( '#'+file.id ).find('p.state').text('已上传');
        initwaveform();

        console.log("audio上传成功", response);
    });

    //文件上传失败会派送uploadError事件
    soundUploader.on('uploadError', function(file) {
        // $( '#'+file.id ).find('p.state').text('上传出错');
        console.log("上传出错");
    });

    // 不管成功或者失败，在文件上传完后都会触发uploadComplete事件。
    soundUploader.on('uploadComplete', function(file) {
        // $( '#'+file.id ).find('.progress').fadeOut();
        // console.log("上传完成");
    });

    // 图片上传
    var imageUploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '/js/Uploader.swf',

        // 文件接收服务端。
        server: ImageServer_URL,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#imagePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Image',
            extensions: 'jpg, jepg, png, bmp',
            mimeTypes: 'Image/*'
        },

        // drag and drop 启动拖拽的容器
        // dnd: "#image-dragdrop",

        // 整数，上传文件数量限制,超出则不许加入队列。 总数20-张
        fileNumLimit: 20,

        // 整数，文件总大小是否超出限制, 超出则不允许加入队列
        fileSizeLimit: 100 * 1024 * 1024,

        // 整数5M, 验证单个文件大小是否超出限制, 超出则不允许加入队列。
        fileSingleSizeLimit: 5 * 1024 * 1024

    });

    // 文件上传过程中创建进度条实时显示。
    imageUploader.on('uploadProgress', function(file, percentage) {
        // $li.find('p.state').text('上传中');
        $imagePrgressMask.height(percentage * maskHeight);
        $imageProgressText.show().text(parseInt(percentage * 100) + '%');
    });

    // 发送成功则派送uploadSuccess事件
    imageUploader.on('uploadSuccess', function(file, response) {
        // $( '#'+file.id ).find('p.state').text('已上传');
        console.log("图片上传成功=>", response);
        //记录文件url
    });

    //文件上传失败会派送uploadError事件
    imageUploader.on('uploadError', function(file, reason) {
        // $( '#'+file.id ).find('p.state').text('上传出错');
        console.log("上传出错", reason);
    });

    // 不管成功或者失败，在文件上传完后都会触发uploadComplete事件。
    imageUploader.on('uploadComplete', function(file) {
        // $( '#'+file.id ).find('.progress').fadeOut();
        // console.log("上传完成");
    });

//页面过渡动画控制=================================

    var pageAnimateQueue = [joinPill, showMask, pillGone, showEditContent];
    $(".main").queue("pageAnimate", pageAnimateQueue);
    
    // 初始化页面设置
    var $mask = $(".mask").height(0);
    var $edit = $('.edit').hide();
    var $uploaderDiv = $('.uploader');
    var $nextBtn = $('.next') //.hide();
    // $('.text-buttons').hide();


    // 下一步按钮
    $nextBtn.on('click', function(e) {
        e.preventDefault();
        startPageAnimate();
    })

    // 开始动画序列
    function startPageAnimate () {
        $(".main").dequeue("pageAnimate");
    }

    // 拼接pill动画
    function joinPill() {
        $(".pill .left").animate({left: '95px'}, "slow", "easeInQuint" );
        $(".pill .right").animate({left: '585px'}, "slow", "easeInQuint",
            function() { startPageAnimate();//animateEvent.dispatch('joinPillComplete');
        });
    }

    // pill消失动画
    function pillGone() {  
        $uploaderDiv.animate({
                "margin-top": -700,
            },
            'slow',
            "easeInQuint",
            function() {
                $uploaderDiv .hide();
                startPageAnimate();
            });
    }

    // 显示遮罩层
    function showMask(){
        $mask.animate({height:'100%'}, "slow","easeInQuint",function  () {
            startPageAnimate();
        });
    }

    // 初始化编辑页面
    function showEditContent () {
        $edit.fadeIn('slow', function() {
            initSlideBar ();
            // initwaveform();
            wavesurfer.drawBuffer();
        });
    }

//编辑页面
//============================

    function initSlideBar () {
        // 获取滑块和目标圆点重中心对齐后的位置差dy
        var dyDot = parseInt($('.dot').css('margin-top')) - ($('.thumb').height() - $('.dot').height()) / 2;

        // 初始化滑块位置
        initThumbPosByIndexOfDot(4, dyDot);

        // 初始化滑动条刻度文本
        $('.label p').each(function(index) {
            $(this).text(repeatValue[index]);
        })

        // 点击滑块滑动到目标刻度位置，调节动画播放速度
        $(".slider").on("click", ".dot", function(me) {
            var pos = $(this).position();
            var topTo = pos.top + dyDot;
            $('.thumb').animate({top: topTo});
            var repeatCount = repeatValue[pos.top/101];
            controller.fireEvent("speedChange", repeatCount);
        })
    }

    // 根据刻度（class='dot'）索引值初始化滑块位置
    function initThumbPosByIndexOfDot(index, offsetY) {
        var pos = $('.dot').eq(index).position();
        var topTo = pos.top + offsetY; 
        $('.thumb').animate({top:topTo},"slow");
        controller.fireEvent("speedChange", 1);
    }

    // 获取鼠标相对元素内部的坐标（相对坐标）
    function getMousePosition(element) {
        var mouse = {
            x: 0,
            y: 0
        };

        element.addEventListener('mousemove', function(event) {
            var x, y;
            if (event.pageX || event.pageY) {
                x = event.pageX;
                y = event.pageY;
            } else {
                x = event.clientX + document.body.scrollLeft || document.documentElement.scrollLeft;
                y = event.clientY + document.body.scrollTop || document.documentElement.scrollTop;
            }

            x -= getPosition(element).left;
            y -= getPosition(element).top;

            mouse.x = x;
            mouse.y = y;
        }, false);

        return mouse;
    };

    // 获取目标元素相对于页面的位置
    function getPosition(target) {
        var left = 0,
            top = 0;
        do {
            left += target.offsetLeft || 0;
            top += target.offsetTop || 0;
            target = target.offsetParent;
        } while (target);
        return {
            left: left,
            top: top
        };
    }

// 波形控制器
//======================================
    initSlideBar ();
    initwaveform();
    //加载音频
    function initwaveform () {
         var options = {
            height: 40,
            container: document.querySelector('#waveform-container'),
            waveColor: '#c8c9ca',//c8c9ca
            waveShadowColor:'#888',
            progressColor: '#55b3d9',
            progressShadowColor: '#3393ba',
            loaderColor: 'purple',
            cursorColor: 'white'
        };

        // Init
        // debugger;
        wavesurfer.init(options);
        // Load audio from URL
        wavesurfer.load('http://pillele.cn/zpc/sound/Anan Ryoko - Refrain.mp3');
        // wavesurfer.load('http://ftremix-remix.qiniudn.com/2014/1212/lp/TF/201412127Mk.mp3');
        // wavesurfer.playPause();
    }

    // 格式化时间
    function formatTime(seconds) {
        var m = ~~(seconds / 60);
        var s = ~~(seconds % 60);
        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        return m + ":" + s;
    }

    function showTime () {
        // if (!wavesurfer.backend.isPaused()) {
            var currentTime = wavesurfer.getCurrentTime();
            var totalTime = wavesurfer.getDuration();

            currentTime = formatTime(currentTime);
            totalTime = formatTime(totalTime);
            $('.time').text(currentTime + "/" + totalTime);
        // }
    }

    // 显示时间
    wavesurfer.on("audioprocess", function() {
        showTime();
        // 广播显示文本的事件
    });

    //播放暂停
    wavesurfer.on('ready', function() {
        // $('.text-buttons').show();
        $(".btns .icon").on("click", function  () {
            $(".btns .icon").toggleClass('active');
            wavesurfer.playPause();
        })
        showTime();
        // console.log('audio ready');
    });

    // 错误
    wavesurfer.on('error', function(err) {
        console.error("很不幸有错误=>",err);
    });

    // 播放完成
    wavesurfer.on('finish', function() {
        console.log('歌曲播放完成鸟, 干什么？');
        $(".btns .icon").toggleClass('active');
    });

    //音频加载进度控制 
    document.addEventListener('DOMContentLoaded', function() {
        // var progressDiv = document.querySelector('#progress-bar');
        // var progressBar = progressDiv.querySelector('.progress-bar');

        var showProgress = function(percent) {
            // progressDiv.style.display = 'block';
            // progressBar.style.width = percent + '%';
            console.log("progress=>", percent);
        };

        var hideProgress = function() {
            // progressDiv.style.display = 'none';
        };

        wavesurfer.on('loading', showProgress);
        wavesurfer.on('ready', hideProgress);
        wavesurfer.on('destroy', hideProgress);
        wavesurfer.on('error', hideProgress);
    });


    var GLOBAL_ACTIONS = {
        'play': function() {
            wavesurfer.playPause();
            console.log("start play");
        }
    };

    // 播放控制
    function playPause() {
        var btns = document.querySelectorAll('[data-action]');
        Array.prototype.forEach.call(btns, function(el) {
            el.addEventListener('click', function(e) {
                var action = e.currentTarget.dataset.action;
                if (action in GLOBAL_ACTIONS) {
                    e.preventDefault();
                    GLOBAL_ACTIONS[action](e);
                }
            });
        });
    }

//图片动画 =======================================
    var imageList=["aaa.jpg","bbb.jpg","ccc.jpg","ddd.jpg", "eee.jpg"];
    // var imageList=["1.jpg","2.jpg","3.jpg","4.jpg"];
    var imageAnimation = Object.create(ImageAnimation);

    imageAnimation.init({
        blur:70,
        data:imageList,
        container:"#stage",
        waveController:wavesurfer
    });

    //音频加载完成初始化图片动画的间隔时常
    wavesurfer.on('ready', function() {
        var audioDuration = wavesurfer.getDuration();
        imageAnimation.setTimeInvterval(audioDuration);
    });


//文本编辑/显示 =====================================
    var textEditor = Object.create(TextEditor);
    textEditor.init({
        container: "#stage"
    });
    //点击添加文字按钮
    $('.text-buttons a').click(function(e) {
        e.preventDefault();

        //点击添加按钮
        if (this.id == "add") {
            $(this).addClass('hidden');
            controller.fireEvent('addTextClicked');
        }

        // 点击确定按钮
        if(this.id =="ok"){
            $('.addText').removeClass('hidden');
             controller.fireEvent('addTextOk');
        }
    });
    
    //调节速度改变图片播放的间隔时间
    controller.on("speedChange", function (repeatCount) {
        imageAnimation.setRepeatCount(parseInt(repeatCount));
    });

    controller.on("addTextClicked", function () {
        console.log("txtInputStart");
        //记录表当前音频时间，音频停止播放,
        if(!wavesurfer.backend.isPaused())
        {
            wavesurfer.pause();
        }

        textEditor.txtInputStart(wavesurfer.getCurrentTime());
        imageAnimation.setBlurEnable(true); //显示毛玻璃效果
    });

    controller.on("addTextOk", function () {
        console.log("txtInputEnd");
        textEditor.txtInputEnd();
        imageAnimation.setBlurEnable(false); //隐藏毛玻璃效果

        console.log(textEditor.getTxtFinal());
        //继续播放音频
        // wavesurfer.play();
        //如果有文本数据，记录文本内容和时间点
        //如果有文本数据，波形中打点
    });
})



