// 波形控制器
var pill,wavesurfer;
// 图片动画
var imageAnimation;
//播放列表参数
var ro_height=0,sendajax=0,more=1,lastID=0;
//网络参数
// var OpusList_URL = 'http://dev.capsule.com/api/user/works';
var OpusList_URL = 'http://pillele.cn/zpc/data/listjson.php';//临时请求地址 dev地址跨域调用问题
var OpusDatas_URL = "http://pillele.cn/zpc/data/opustest.php?data=1";
var PlayCount_URL = "http://pillele.cn/zpc/data/opustest.php?play_count=1";
var GetSound_URL = "http://pillele.cn/zpc/data/opustest.php?data=1";

//加载音频
function initwaveform(sound_url) {
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
    wavesurfer.load(sound_url);
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

//显示时间
function showTime() {
    var currentTime = wavesurfer.getCurrentTime();
    var totalTime = wavesurfer.getDuration();

    currentTime = formatTime(currentTime);
    totalTime = formatTime(totalTime);
    return currentTime + "/" + totalTime;
}

//显示文本
function shwoText(){
    //根据时间判断显示文字的信息
}

//获取更多作品信息
function getMoreOpus($box){
    //判断是否有更多
    if(more==1 && sendajax==0){
        var d=lastID==0?{}:{'lastID':lastID};
        sendajax=1;
        var init=lastID==0?1:0;
        //配置加载状态Loading
        $box.append($('<div class="list_loading" id="list_loading">读取信息中，请稍候...</div>'));
        //网络通讯加载
        $.get(OpusList_URL,d,function(data){
            //处理数据信息
            if(!data.hasMore){
                more=0;
            }
            $box.children('#list_loading').remove();
            //添加数据
            if(data.results.length){
                var res=data.results;
                var html='';
                $.each(res,function(i,n){
                    var time=getMonthTime(n['created_at']),
                        tags=getTagHtml(n['tags']);
                    lastID=n['id'];
                    html+='<div class="opus_warp" onclick="getTheOpus('+n['id']+');" id="opus_'+n['id']+'" opusdata="'+n['id']+'"><div class="opus_date"><p class="date_md"><span class="month">'+time[1]+'</span><span class="day">'+time[2]+'</span></p><p class="date_year">'+time[0]+'</p></div><div class="opus_line"><div></div></div><div class="opus_box"><div class="opus_cover"><img src="'+n['cover']+'" /><div class="cover_mask"><i class="iconfont icon active" id="icon-play">&#xe600;</i></div></div><div class="opus_info"><div class="opus_name">'+n['title']+'</div><div class="opus_tags">'+tags+'</div><div class="opus_counts"><span class="oc_play">'+n['play_count']+'</span><span class="oc_light">'+n['comment_count']+'</span><span class="oc_like">'+n['like_count']+'</span></div></div></div></div>';
                });
                $(html).appendTo($box);
                //重新获取ro_height高度
                ro_height=$box.height();
                if(init && res.length){
                    initList($box);
                }
            }
            sendajax=0;
        },'json');
    }
}

//拆解字符串时间
function getMonthTime(time){
    var time=time.substring(0,10).split('-');
    var m=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Spt","Oct","Nov","Dec"];
    var month=parseInt(time[1])-1;
    time[1]=m[month];
    return time;
}
//循环遍历数组 生成HTML
function getTagHtml(tags){
    var h='';
    for(var i=0;i<tags.length;i++){
        h+='<span>'+tags[i]['name']+'</span>';
    }
    return h;
}
//初始化列表和音乐播放状态请求
function initList($box,len){
    //列表的滚轮事件监听
    $box.mousewheel(function(event,delta){
        if(ro_height>530){
            var $t=$(this),
                cur=parseInt($t.css('top'));
            var max_top=0,
                min_top=530-ro_height;
            var new_top=cur+delta*20;
            if(new_top>max_top){
                new_top=max_top;
            }else if(new_top<min_top){
                new_top=min_top;
            }else{
                event.preventDefault();
            }
            $t.css('top',new_top+'px');
            if(new_top-min_top<100 && more && sendajax==0){
                //加载更多信息
                getMoreOpus($t);
            }
            return false;
        }
    });
    //默认加载第一个音频信息
    var curId=$box.children('.opus_warp:first').attr('opusdata');
    getTheOpus(curId);

}
//获取音乐信息
function getTheOpus(id){
    var $opus=$('#opus_'+id);
    $opus.addClass('cur').siblings('.cur').removeClass('cur');
    //信息请求
    $.get(OpusDatas_URL,{id:id},function(d){
        if(!d.errors){
            var 
        }
    },'json');
}

/**
 * 
 * credits for this plugin go to brandonaaron.net
 *  
 * unfortunately his site is down
 * 
 * @param {Object} up
 * @param {Object} down
 * @param {Object} preventDefault
 */
jQuery.fn.extend({
    mousewheel: function(up, down, preventDefault) {
        return this.hover(
            function() {
                jQuery.event.mousewheel.giveFocus(this, up, down, preventDefault);
            },
            function() {
                jQuery.event.mousewheel.removeFocus(this);
            }
        );
    },
    mousewheeldown: function(fn, preventDefault) {
        return this.mousewheel(function(){}, fn, preventDefault);
    },
    mousewheelup: function(fn, preventDefault) {
        return this.mousewheel(fn, function(){}, preventDefault);
    },
    unmousewheel: function() {
        return this.each(function() {
            jQuery(this).unmouseover().unmouseout();
            jQuery.event.mousewheel.removeFocus(this);
        });
    },
    unmousewheeldown: jQuery.fn.unmousewheel,
    unmousewheelup: jQuery.fn.unmousewheel
});

jQuery.event.mousewheel = {
    giveFocus: function(el, up, down, preventDefault) {
        if (el._handleMousewheel) jQuery(el).unmousewheel();

        if (preventDefault == window.undefined && down && down.constructor != Function) {
            preventDefault = down;
            down = null;
        }

        el._handleMousewheel = function(event) {
            if (!event) event = window.event;
            if (preventDefault)
                if (event.preventDefault) event.preventDefault();
                else event.returnValue = false;
            var delta = 0;
            if (event.wheelDelta) {
                delta = event.wheelDelta/120;
                if (window.opera) delta = -delta;
            } else if (event.detail) {
                delta = -event.detail/3;
            }
            if (up && (delta > 0 || !down))
                up.apply(el, [event, delta]);
            else if (down && delta < 0)
                down.apply(el, [event, delta]);
        };

        if (window.addEventListener)
            window.addEventListener('DOMMouseScroll', el._handleMousewheel, false);
        window.onmousewheel = document.onmousewheel = el._handleMousewheel;
    },

    removeFocus: function(el) {
        if (!el._handleMousewheel) return;

        if (window.removeEventListener)
            window.removeEventListener('DOMMouseScroll', el._handleMousewheel, false);
        window.onmousewheel = document.onmousewheel = null;
        el._handleMousewheel = null;
    }
};


function initWave(){
    /* Progress bar */
    var $progressDiv = $('#progress-bar'),
        $progressBar = $progressDiv.find('.progress-bar');
    function showProgress(percent) {
        $progressDiv.show();
        $progressBar.css('width', percent + '%');
    };
    function hideProgress() {
        $progressDiv.hide();
    };
    wavesurfer = Object.create(WaveSurfer);
    imageAnimation = Object.create(ImageAnimation);

    //图片动画
    imageAnimation.init({
        blur:70,
        data:pill.images,
        container:"#stage",
        waveController:wavesurfer,
        width:501,
        height:501,
        repeat:pill.repeat
    });

    //初始化波形
    initwaveform(pill.music);
    // 播放进入控制
    wavesurfer.on("audioprocess", function() {
        // 显示时间
        $('#time').text(showTime());
        //时间判定 文字交替显示
        //************************************
    });
    //初始化播放器配置
    wavesurfer.on('ready', function() {
        hideProgress();
        //图片交替显示
        imageAnimation.setTimeInvterval(wavesurfer.getDuration());
        //暂停和继续
        $("#player_btns>.icon").click(function  () {
            $("#player_btns>.icon").toggleClass('active');
            wavesurfer.playPause();
        });
        $('#time').text(showTime());
    });
    // 播放完成
    wavesurfer.on('finish', function() {
        //下一首歌
        //************************************
        //暂时循环播放
        wavesurfer.seekTo(0);
        wavesurfer.play();
    });
    //跳转
    wavesurfer.on('seek', function() {
        $('#time').text(showTime());
    });
    // 错误处理
    wavesurfer.on('error', function(err) {
        hideProgress();
        console.error("很不幸有错误=>",err);
    });

    wavesurfer.on('loading', showProgress);
    wavesurfer.on('destroy', hideProgress);
}

//页面加载完成后的继续操作
$(function(){
    if(pill){
        initWave();
    }
});
