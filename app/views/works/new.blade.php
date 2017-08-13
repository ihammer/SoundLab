@extends('base')
@section('content')
<div class="wrap">
    <div class="pill">
        <div class="left">
            <div class="box-shadow"></div>
            <div class="boxwrap">
                <div class="leftbox">
                    <img class="title" src="{{ asset('assets/images/soundpill_logo_red.jpg') }}" alt="">
                    <div class="progress-left text-center">
                        <div class="logo">
                            <img class="progress-bg" src="{{ asset('assets/images/progress_left.jpg') }}" alt="">
                            <img class="uparrow" src="{{ asset('assets/images/upArrow_left.jpg') }}" alt="">


                            <!-- 进度条条遮罩 -->
                            <div class="progress-mask">

                                <div class="progress-bar-container">
                                </div>
                                <!-- <img class="progress-top" src="images/progress_top_white.jpg" alt=""> -->
                            </div>
                            <p class="progress-text">100%</p>
                        </div>

                        <!-- 上传音频 -->
                        <div class="sound-uploader" id="sound-uploader">
                            <div id="thelist" class="uploader-list"></div>
                            <!-- <div class="upload-btns"> -->
                            <div id="soundPicker" class="btn">上传 音频</div>
                            <!-- </div> -->
                        </div>

                        <p class="small">支持MP3/WAV/M4V格式的音频</p>
                        <p class="small">文件大小不少超过20M</p>
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
                    <div class="logo">
                        <img class="progress-bg" src="{{ asset('assets/images/progress_right.jpg') }}" alt="">
                        <img class="uparrow" src="{{ asset('assets/images/upArrow_right.jpg') }}" alt="">


                        <!-- 进度条条遮罩 -->
                        <div class="progress-mask">
                            <!-- 进度条 -->
                            <div class="progress-bar-container">
                            </div>
                            <!-- <img class="progress-top" src="images/progress_top_red.jpg" alt=""> -->
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
                    <p class="small">文件大小不少超过20M</p>
                </div>
            </div>
        </div>
    </div>
    <!-- 下一步 -->
    <div class="nextstep text-center"><a href="#" class="btn next"  data-toggle="modal" data-target=".bs-example-modal-lg">下一步</a>
    </div>

</div>
@stop