/**
 * Created by Administrator on 2016/10/11.
 */
window.onload = function () {
    var mySwiper = new Swiper('nav .swiper-container',{
        loop: false,
        //其他设置
        pagination : '.swiper-pagination',
//            paginationType : 'bullets'
    });
    var mySwiper1 = new Swiper('.swiper-container2',{
        loop: false,
        //其他设置
        slidesPerView : 4,
        //spaceBetween : 20,
//            paginationType : 'bullets'
    });
}
$(function () {
    //获取专辑信息
    var albumDesc = [];
    //获取地址栏userid
    var userUrl = document.location.href;
    var uid = parseInt(userUrl.split("=")[1]);
    console.log(uid)
    //总页数获取
    var totalPage;
    //获取头像背景
    //拿到事件源id属性
    $.ajax({
        type:"get",
        url:"http://soundlab.com/api/user/"+ uid +"/show",
        success: function (data) {
            console.log(data.data.avatar)
            $('.blur').css({
                "background":"url("+ data.data.avatar +")no-repeat center ",
                "background-size":"cover"
            })
            //专辑信息
            for(var i = 0; i < data.data.album_list.length; i++){
                albumDesc.push(data.data.album_list[i].desc)
            }
        }
    })


    //var follow = $('.follow');
    //follow.bind('click', function () {
    //    $.get('/user/37/feeds', function (msg) {
    //        console.log(msg)
    //    })
    //})
    //内容切换
    function tab () {
        //拿到tab
        var tab = $('.tab');
        //拿到作品tabs
        var tabs = $('.tab li');
        $('.album_content ul').empty()
        //拿到所有product
        var products = $('.wrapper .products');
        tab.click(function (event) {
            //移除所有tab上的active

            tabs.removeClass('active');
            $('.album_content ul').empty()
            //拿到事件源index
            var tabIndex = $(event.target).index();
            //拿到事件源内容
            var tabContent = $(event.target).html();
            //拿到事件源id属性
            albumId =  $(event.target).attr('id');
            //为事件源添加active的类名
            $(event.target).addClass('active');
            //删除所有content的类名selected
            products.removeClass('selected');
            //为对应index的元素添加类名selected
            tabIndex>=1?tabIndex=1:tabIndex
            $(products[tabIndex]).addClass('selected')
            //如果事件源内容不为'作品'并且有id属性 并且ajax ==undefind
            if(tabContent != "作品" && albumId){
               getAlbums(1,uid,albumId)
                //console.log($('.album_content ul').html())
                //给事件源添加已发送请求属性
                $(event.target).attr('ajax','ajax');
                console.log('获取成功')
            }
        })
    }

    tab()

    /**
     * 拉取作品信息
     * @param page
     * @param uid
     */

    function getWorksPage(page,uid) {
        var num = [];
        var date = [];
        $.ajax({
            type:"get",
            url:'http://soundlab.com/api/user/'+ uid + '/feeds?type=0&p='+page ,
            beforeSend: function () {
                // loading状态提示
                $('p.tips').text('正在加载...')
                    .addClass('loading');
            },
            success: function (data) {

                //取得总页数
                totalPage = data.meta.pages;
                //处理时间
                    console.log(data.data)
                    $(data.data).each(function () {
                        num.push(this.created_at.split('-')[1]);
                        date.push(this.created_at.substring(8,10));
                    })

                //引入模板
                var workPage = template('album_ul',{
                    works:data.data,
                    //date:data.data.created_at
                    num:num,
                    date:date
                });
                //导入模板
                $('#works ul').append(workPage);
                console.log('导入模板成功');
                $('p.tips').text('上滑加载更多')
                    .removeClass('loading')
                    // 缓存页码
                    .attr('data-page', data.meta.page);
                console.log($("p.tips").attr('data-page'))

            }
        })
    }
    /**
     * 拉取专辑信息
     * @param uid
     * @param albumId
     */
    function getAlbums (page ,uid , albumId) {
        $.ajax({
            type:"get",
            url: 'http://soundlab.com/api/user/'+ uid +'/'+ albumId +'/getAlbum?p='+page,
            //url:'http://soundlab.com/api/user/'+ uid + '/feeds?type=0&p='+page ,
            success: function (data) {

                //取得总页数
                totalPage = data.meta.pages;
                //处理时间

                //引入模板
                var workPage = template('albums',{
                    works:data.data
                    //date:data.data.created_at
                });
                //导入模板
                $('.album_content ul').append(workPage);
                console.log('导入模板成功');
                $('p.tips').text('上滑加载更多')
                    .removeClass('loading')
                    // 缓存页码
                    .attr('data-page', data.meta.page);
                console.log($("p.tips").attr('data-page'))

            }
        })
    }



    //触发对应的滑动事件
    if($('.tab li').hasClass('active') && $('.active').html() == '作品'){
        $(window).on("scroll", function () {
            //if($('.my_works .tab .active').html() == '作品'){
            //}
            //console.log(111)
            var offsetTop = $('#works').offset().top;
            var height = $('#works').height();
            var scrollTop = $(this).scrollTop();
            var winHeight = $(this).height();

            // 计算滚动条的位置
            var offset = offsetTop + height - scrollTop - winHeight;

            console.log(offset);
            // 判断滚动条位置并禁重复加载
            if(offset <= 20 && !$('p.tips').hasClass('loading')) {
                console.log('滚动事件开始')
                // 获取下一页页码
                var page = parseInt($('p.tips').attr('data-page'));
                console.log(totalPage)
                if(page <= totalPage) {
                    // 发起请求获取数据
                    page==2?page=3:page;
                    getWorksPage(page +1, uid)
                }else{
                    $('p.tips').text('没有啦')
                }
            }
            return false
        })
    }




        $(window).on("scroll", function () {
            //if($('.my_works .tab .active').html() == '作品'){
            //}
            //var offsetTop = $('#works').offset().top;
            //console.log(offsetTop)
            //var height = $('#works').height();
            //console.log(height)
            //var scrollTop = $(this).scrollTop();
            //console.log(scrollTop)
            //var winHeight = $(this).height();
            //console.log(winHeight)

            // 计算滚动条的位置
            //var offset1 = offsetTop + height - scrollTop - winHeight;
            // 判断滚动条位置并禁止重复加载
            //console.log(offset1);
            if( !$('.wrapper p.tips').hasClass('loading')) {
                console.log('滚动事件开始')
                // 获取下一页页码
                var page = parseInt($('p.tips').attr('data-page'));
                console.log(totalPage)
                if(page <= totalPage) {
                    // 发起请求获取数据
                    page==2?page=3:page;
                   getAlbums(page +1, uid ,albumId )
                }else{
                    $('p.tips').text('没有啦')
                }
            }
        })


    //滚动函数



    //为works添加滚动事件

    getWorksPage(1,uid)

})
