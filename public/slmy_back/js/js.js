/**
 * Created by Administrator on 2016/10/11.
 */
window.onload = function () {
    var mySwiper = new Swiper('.swiper-container',{
        loop: false,
        //其他设置
        pagination : '.swiper-pagination',
//            paginationType : 'bullets'
    });
}
$(function () {
    var follow = $('.follow');
    follow.bind('click', function () {
        $.get('/user/37/feeds', function (msg) {
            console.log(msg)
        })
    })
    function tab () {
        //拿到tab
        var tab = $('.tab');
        //拿到作品tabs
        var tabs = $('.tab li');
        //拿到所有product
        var contents = $('.wrapper .products');
        tab.click(function (event) {
            //拿到事件源index
            var tabIndex = $(event.target).index();
            //移除所有tab上的active
            tabs.removeClass('active');
            //为事件源添加active的类名
            $(event.target).addClass('active');
            //删除所有content的类名selected
            contents.removeClass('selected');
            //为对应index的元素添加类名selected
            $(contents[tabIndex]).addClass('selected')
        })
    }
    tab()
    //拉取作品信息
    $.ajax({
        type:"post",
        url:"http://123.57.1.43/api/user/37/getAlbum",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Token uid','token')
        },
        dataType:"JSONP",
        //date:"token",
        success: function (data) {
            console.log(data);
        }
    })
})
