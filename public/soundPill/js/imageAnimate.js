'use strict';


window.requestAnimationFrame = 
			window.requestAnimationFrame       || 
	        window.webkitRequestAnimationFrame || 
	        window.mozRequestAnimationFrame    || 
	        window.oRequestAnimationFrame      || 
	        window.msRequestAnimationFrame     || 
	        function (fn) {
	        	return window.setInterval(fn,1000/60)
	        };

window.cancelRequestAnimationFrame = 
			window.cancelRequestAnimationFrame       || 
	        window.webkitCancelRequestAnimationFrame || 
	        window.mozCancelRequestAnimationFrame    || 
	        window.oCancelRequestAnimationFrame      || 
	        window.msCancelRequestAnimationFrame     || 
	        function  (id) {
	        	return window.clearInterval(id);
	        };

var ImageAnimation = {
    defaultParams: {
        data: null,
        container: null,
        startIndex:0,
        delay: 0,
        interval: 2000,
        repeat:1,
        width:522,
        height:522,
        blur:70,
        waveController:null,
        pixelRatio: window.devicePixelRatio
    },

	init: function(params) {
	    this.params = WaveSurfer.util.extend({}, this.defaultParams, params);
	    this.timeInterval = this.params.interval;
	    this.delay = this.params.delay;
	    this.startIndex = this.params.startIndex;
	    this.repeatCount = this.params.repeat;
	    this.waveController = this.params.waveController;
        this.blurRadius = this.params.blur;

	    this.container = typeof this.params.container == 'string' ?
	        document.querySelector(this.params.container) :
	        this.params.container;

	    if (!this.container) {
	        throw new Error("Container element not found");
	    }

        // this.setBlurEnable(true);
	    this.imageElements = [];
	    this.BASE_URL = "images/a/";

	    this.on("loaded", this.startAnimate.bind(this));
	    // this.eventHandler();
	    this.createElements();
	    this.loadImage();
	},

    createElements: function() {
        var imageCanvasDown = this.container.appendChild(document.createElement('canvas'));
        this.setAttributes(imageCanvasDown,{
            id:"canvasDown"
        });
        this.style(imageCanvasDown, {
        	position: 'absolute',
		    top: 0,
		    left:0,
		    zIndex:1,
		    width: this.params.width + "px",
		    height: this.params.height + "px"
        });
        

        var imageCanvasUp = this.container.appendChild(document.createElement('canvas'));
        this.setAttributes(imageCanvasUp,{
            id:"canvasUp"
        });
        this.style(imageCanvasUp, {
        	position: 'absolute',
		    top: 0,
		    left:0,
		    zIndex:2,
		    width: this.params.width + "px",
		    height: this.params.height + "px"
        });
        

        this.updateSize(imageCanvasUp);
        this.updateSize(imageCanvasDown);

        this.imageCcUp = imageCanvasUp.getContext("2d");
        this.imageCcDown = imageCanvasDown.getContext("2d");

        this.imageCcUp.globalAlpha =0;
        this.imageCcDown.globalAlpha =0;

		WaveSurfer.util.extend(this.imageCcUp, WaveSurfer.Observer);
		WaveSurfer.util.extend(this.imageCcDown, WaveSurfer.Observer);

        this.animateEventHandler(this.imageCcUp, this.imageCcUpFadeInComplete, this.imageCcUpFadeOutComplete);
        this.animateEventHandler(this.imageCcDown, this.imageCcDownFadeInComplete, this.imageCcDownFadeOutComplete);

    },


    setRepeatCount:function  (n) {
    	this.repeatCount = n;
    	this.setTimeInvterval();
    },
    // 设置时间间隔
    setTimeInvterval: function(audioDuration) {
    	this.audioDuration = audioDuration || this.audioDuration;
    	var interval = this.audioDuration / (this.imageElements.length * this.repeatCount)*1000;
        this.timeInterval = interval || this.timeInterval;

        // console.log('interval changed to: '+ this.repeatCount, this.timeInterval);
    },

    updateSize:function  (canvas) {
    	canvas.width = this.params.width;
    	canvas.height = this.params.height;
    },

    style: function (el, styles) {
        Object.keys(styles).forEach(function (prop) {
            if (el.style[prop] != styles[prop]) {
                el.style[prop] = styles[prop];
            }
        });
        return el;
    },

    setAttributes: function (el, attr) {
        Object.keys(attr).forEach(function (prop) {
            if (el.getAttribute(prop) != attr[prop]) {
                el.setAttribute(prop,attr[prop]);
            }
        });
        return el;
    },

    loadImage:function(){
    	var self = this;
    	var data = this.params.data;
    	if (data.length <= 0) {
    	    return;
    	}

    	var img = new Image();
    	img.src = this.BASE_URL + data[data.length - 1],
    	    img.onload = function() {
    	        self.resizeImage(this);
    	        self.imageElements.push(this);
    	        self.loadImage()
    	    }

    	data.length = data.length - 1;
    	if (data.length <= 0) {
    	    self.fireEvent("loaded");
    	}

    },

    // 按图片原始比率缩放图片，填满cavans
    resizeImage:function(image) {
    	var w = image.width / this.params.pixelRatio;
    	var h = image.height / this.params.pixelRatio;

    	var ratio;
    	if (w / h > 1) {
    	    ratio = h / this.params.height;
    	    image.width = w / ratio;
    	    image.height = this.params.height;
    	} else {
    	    ratio = w / this.params.width;
    	    image.width = this.params.width;
    	    image.height = h / ratio;
    	}
    },

    // 在canvas中居中绘制图片
    drawImage:function(ctx, img){
    	ctx.clearRect(0, 0, this.params.width, this.params.height);
    	var w = parseInt(img.width);
    	var h = parseInt(img.height);
    	var centerX = -(w - this.params.width) / 2;
    	var centerY = -(h - this.params.height) / 2;
    	ctx.drawImage(img, centerX, centerY, w, h);
    },

    // 开始动画序列
    startAnimate:function(){
    	console.log("start Animate queue");
    	var self = this;
        // stackBlurCanvasRGB("canvasUp", 0, 0, 522, 522, 10)
        // stackBlurCanvasRGB("canvasDown", 0, 0, 522, 522, 10)

    	var firstImage = this.getImageByIndex(this.startIndex);
    	setTimeout(function() {
    	    self.fadeIn(self.imageCcUp, firstImage);
    	}, this.delay);
    },

    getImageByIndex:function  (index) {
    	var img = this.imageElements[index];
    	return img;
    },

    fadeInUpImage: function() {
        this.startIndex = (++this.startIndex > this.imageElements.length - 1) ? 0 : this.startIndex;

        var nextImage = this.getImageByIndex(this.startIndex);
        this.fadeIn(this.imageCcUp, nextImage);
    },

    fadeInDownImage: function() {
        this.startIndex = (++this.startIndex > this.imageElements.length - 1) ? 0 : this.startIndex;

        var nextImage = this.getImageByIndex(this.startIndex);
        this.fadeIn(this.imageCcDown, nextImage);
    },


    fadeIn: function (ctx, image) {
        var self = this;
        var req;
        var id = ctx.canvas.getAttribute('id');
        var frame = function () {
				req = requestAnimationFrame(frame);
                ctx.globalAlpha += 0.05;
            	if(ctx.globalAlpha>=0.95)
            	{
            		ctx.globalAlpha = 1;
            		cancelRequestAnimationFrame(req);
            	}

                if(ctx.globalAlpha == 1)
                {
                    ctx.fireEvent("fadeInComplete", ctx ,image);
                }
            	self.drawImage(ctx, image);

                if(self.isBlur)
                {
                    stackBlurCanvasRGB(id, 0, 0, this.params.width, this.params.height, self.blurRadius);
                }
        };
        frame();
    },

    fadeOut: function (ctx, image) {
        var self = this;
        var req;
        var id = ctx.canvas.getAttribute('id');
        ctx.globalAlpha = 1;
        var frame = function () {
        		req = requestAnimationFrame(frame);
            	ctx.globalAlpha -= 0.05;
            	
            	if(ctx.globalAlpha<=0.05)
            	{
            		ctx.globalAlpha = 0;
            		cancelRequestAnimationFrame(req);
            	}
            	self.drawImage(ctx, image);

                if(ctx.globalAlpha == 0)
                {
                    ctx.fireEvent("fadeOutComplete", ctx ,image);
                }
                
        };
        frame();
    },

    /*showBlurFx:function(id){
        if(this.isBlur)
        {
           stackBlurCanvasRGB(id, 0, 0, 522, 522, this.blurRadius);
        }
    },*/

    // 添加动画事件监听器
    animateEventHandler:function  (imageCc, fadeinCallback, fadeOutCallback) {
    	imageCc.on('fadeInComplete',fadeinCallback.bind(this));
    	imageCc.on('fadeOutComplete',fadeOutCallback.bind(this));
    },


    // @param ctx  		context 2d of image canvas
    imageCcUpFadeInComplete:function (ctx,image) {
    	var self = this;
    	var id = setInterval(function  () {
            // console.log("start UpfadeOut: "+self.timeInterval)
            if(!self.waveController.backend.isPaused()){
                clearInterval(id);
	    		self.fadeInDownImage(ctx);
				self.fadeOut(ctx,image);
            }
		}, self.timeInterval);
    },

	imageCcDownFadeInComplete:function (ctx,image) {
    	var self = this;
        var id = setInterval(function() {
            // console.log("start DownfadeOut: "+self.timeInterval)
            if (!self.waveController.backend.isPaused()) {
                clearInterval(id);
                self.fadeInUpImage(ctx);
                self.fadeOut(ctx, image);
            }
        }, self.timeInterval);
		
    },


    imageCcUpFadeOutComplete:function (ctx,image) {
    	// console.log("UpFadeOutComplete")
    },

    imageCcDownFadeOutComplete:function (ctx,image) {
    	// console.log("DownFadeOutComplete")
    },

    // 设置模糊状态值， true打开摸胡状态，false关闭模糊状态
    setBlurEnable:function(b){
        this.isBlur = b;
        var idUp = this.imageCcUp.canvas.id;
        var idDown = this.imageCcUp.canvas.id;
        
        if(b)
        {
            stackBlurCanvasRGB(idUp, 0, 0, this.params.width, this.params.height, this.blurRadius);
            stackBlurCanvasRGB(idDown, 0, 0, this.params.width, this.params.height, this.blurRadius);
            // console.log('blur enabled');
        }else{
            // 取消模糊效果
/*            stackBlurCanvasRGB(idUp, 0, 0, 522, 522, 0);
            stackBlurCanvasRGB(idDown, 0, 0, 522, 522, 0);
*/            //console.log('blur disabled');
        }
        
    }

}

WaveSurfer.util.extend(ImageAnimation, WaveSurfer.Observer);
