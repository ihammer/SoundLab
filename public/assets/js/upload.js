$(document).ready(function() {
    // 下一步按钮
    // $nextBtn = $('.next').hide();

    // 百分比文本
    $soundProgressText = $('.left .progress-text').hide();
    $imageProgressText = $('.right .progress-text').hide();

    // 向上箭头,上传中需要隐藏
    $upArrow = $(".uparrow")

    // 进度条遮罩
    var maskHeight = $(".left .progress-mask").height();
    $soundPrgressMask = $(".left .progress-mask").height(0);
    $imagePrgressMask = $(".right .progress-mask").height(0);


    // 音频上传
    var soundUploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '/swf/Uploader.swf',

        // 文件接收服务端。
        server: 'http://dev.capsule.com/soundupload.php',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#soundPicker',

        // 只允许选择音频文件。
        accept: {
            title: 'Audio',
            extensions: 'mp3,ogg',
            mimeTypes: 'audio/*'
        },

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        // resize: false
    });

    // 当有文件被添加进队列的时候
    soundUploader.on('fileQueued', function(file) {
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
    soundUploader.on('uploadSuccess', function(file) {
        // $( '#'+file.id ).find('p.state').text('已上传');
        console.log("上传成功");
    });

    //文件上传失败会派送uploadError事件
    soundUploader.on('uploadError', function(file) {
        // $( '#'+file.id ).find('p.state').text('上传出错');
        console.log("上传出错");
    });

    // 不管成功或者失败，在文件上传完后都会触发uploadComplete事件。
    soundUploader.on('uploadComplete', function(file) {
        // $( '#'+file.id ).find('.progress').fadeOut();
        console.log("上传完成");
    });


    // 图片上传
    var imageUploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: '/js/Uploader.swf',

        // 文件接收服务端。
        server: 'http://dev.capsule.com/imageupload.php',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#imagePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Image',
            extensions: 'jpg, jepg, png, bmp',
            mimeTypes: 'Image/*'
        },

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        // resize: false
    });

    // 文件上传过程中创建进度条实时显示。
    imageUploader.on('uploadProgress', function(file, percentage) {
        // $li.find('p.state').text('上传中');
        $imagePrgressMask.height(percentage * maskHeight);
        $imageProgressText.show().text(parseInt(percentage * 100) + '%');
    });

    // 发送成功则派送uploadSuccess事件
    imageUploader.on('uploadSuccess', function(file) {
        // $( '#'+file.id ).find('p.state').text('已上传');
        console.log("上传成功");
    });

    //文件上传失败会派送uploadError事件
    imageUploader.on('uploadError', function(file) {
        // $( '#'+file.id ).find('p.state').text('上传出错');
        console.log("上传出错");
    });

    // 不管成功或者失败，在文件上传完后都会触发uploadComplete事件。
    imageUploader.on('uploadComplete', function(file) {
        // $( '#'+file.id ).find('.progress').fadeOut();
        console.log("上传完成");
    });

});
