'use strict';

WaveSurfer.Drawer.Canvas = Object.create(WaveSurfer.Drawer);

WaveSurfer.util.extend(WaveSurfer.Drawer.Canvas, {
	createElements: function () {
        var waveCanvasUp = this.wrapper.appendChild(
            this.style(document.createElement('canvas'), {
                position: 'absolute',
                zIndex: 1,
                height:this.params.height/2+"px",
            })
        );

        var waveCanvasDown = this.wrapper.appendChild(
            this.style(document.createElement('canvas'), {
                position: 'absolute',
                zIndex: 2,
                height:this.params.height/2+"px",
                top:this.params.height/2+"px"
            })
        );

        var waveCanvasBg = this.wrapper.appendChild(
            this.style(document.createElement('canvas'), {
                position: 'absolute',
                zIndex: 3,
                height:this.params.height/2+"px",
                top:this.params.height/2+"px"
            })
        );
        this.waveCcUp = waveCanvasUp.getContext('2d');
        this.waveCcDown = waveCanvasDown.getContext('2d');
        this.waveCcBg = waveCanvasBg.getContext('2d');

        this.progressWave = this.wrapper.appendChild(
            this.style(document.createElement('wave'), {
                position: 'absolute',
                zIndex: 2,
                overflow: 'hidden',
                width: '0',
                height: this.params.height + 'px'
                // borderRightStyle: 'solid',
                // borderRightWidth: this.params.cursorWidth + 'px',
                // borderRightColor: '#ce6665'
            })
        );

        if (this.params.waveColor != this.params.progressColor) {
            var progressCanvasUp = this.progressWave.appendChild(
                this.style(document.createElement('canvas'),{
                    position: 'absolute',
                    zIndex: 1,
                    height:this.params.height/2+"px"
                })
            );

            var progressCanvasDown = this.progressWave.appendChild(
                this.style(document.createElement('canvas'),{
                    position: 'absolute',
                    zIndex: 2,
                    height:this.params.height/2+"px",
                    top:this.params.height/2+"px"
                })
            );
            this.progressCcUp = progressCanvasUp.getContext('2d');
            this.progressCcDown = progressCanvasDown.getContext('2d');

        }
    },

    updateWidth: function () {
        var width = Math.round(this.width / this.params.pixelRatio);

        this.waveCcUp.canvas.width = this.width;
        this.waveCcUp.canvas.height = this.height;
        this.style(this.waveCcUp.canvas, { width: width + 'px'});

        this.waveCcDown.canvas.width = this.width;
        this.waveCcDown.canvas.height = this.height;
        this.style(this.waveCcDown.canvas, { width: width + 'px'});

        this.waveCcBg.canvas.width = this.width;
        this.waveCcBg.canvas.height = this.height;
        this.style(this.waveCcBg.canvas, { width: width + 'px'});

        if (this.progressCcUp) {
            this.progressCcUp.canvas.width = this.width;
            this.progressCcUp.canvas.height = this.height;
            this.style(this.progressCcUp.canvas, { width: width + 'px'});
        }

        if (this.progressCcDown) {
            this.progressCcDown.canvas.width = this.width;
            this.progressCcDown.canvas.height = this.height;
            this.style(this.progressCcDown.canvas, { width: width + 'px'});
        }

        this.clearWave();
    },

    clearWave: function () {
        this.waveCcUp.clearRect(0, 0, this.width, this.height);
        this.waveCcDown.clearRect(0, 0, this.width, this.height);
        this.waveCcBg.clearRect(0, 0, this.width, this.height);
        if (this.progressCcUp) {
            this.progressCcUp.clearRect(0, 0, this.width, this.height);
        }

        if (this.progressCcDown) {
            this.progressCcDown.clearRect(0, 0, this.width, this.height);
        }
    },

    drawWave: function(peaks, max) {
            // A half-pixel offset makes lines crisp
            var $ = 0.5 / this.params.pixelRatio;
            var shadowHeightRatio = 0.6;

            this.waveCcUp.fillStyle = this.params.waveColor;
            this.waveCcDown.fillStyle = this.params.waveShadowColor;

            if (this.progressCcUp) {
                this.progressCcUp.fillStyle = this.params.progressColor;
            }

            if (this.progressCcDown) {
                this.progressCcDown.fillStyle = this.params.progressShadowColor;
            }

            var halfH = this.height / 2;
            var coef = halfH / max;
            var length = peaks.length;

            var meterWidth = 2; //能量条的宽度
            var gap = 3; //能量条间的间距
            var w = meterWidth + gap;
            var meterNum = length / w; //计算当前画布上能画多少条
            var step = Math.round(length / meterNum);
            var factor = 2;//2
            var scale = 1;
            if (this.params.fillParent && this.width != length) {
                scale = this.width / peaks.length;
            }

            //波形上半部分
            for (var i = 0; i < meterNum; i++) {
                var h = Math.round(peaks[i * step] * coef);
                this.waveCcUp.fillRect(i * scale * w, this.height - h * 2, meterWidth, h * factor);
            }

            //波形下半部分
            for (var i = 0; i < meterNum; i++) {
                var h = Math.round(peaks[i * step] * coef);
                this.waveCcDown.fillRect(i * scale * w, 0, meterWidth, h * factor * shadowHeightRatio);
            }

            //进度波形上半部分
            for (var i = 0; i < meterNum; i++) {
                var h = Math.round(peaks[i * step] * coef);
                this.progressCcUp.fillRect(i * scale * w, this.height - h * 2, meterWidth, h * factor);

            }

            //进度波形下半部分
            for (var i = 0; i < meterNum; i++) {
                var h = Math.round(peaks[i * step] * coef);
                this.progressCcDown.fillRect(i * scale * w, 0, meterWidth, h * factor * shadowHeightRatio);
            }

            // Always draw a median line
            var grd = this.waveCcDown.createLinearGradient(0, 0, 0, halfH);
            grd.addColorStop(0, "rgba(0,0,0,0.1)");
            grd.addColorStop(1, "rgba(0,0,0,0)");
            this.waveCcBg.fillStyle = grd;
            this.waveCcBg.fillRect(0, 0, this.width, this.height);

    },

    updateProgress: function (progress) {
        var pos = Math.round(
            this.width * progress
        ) / this.params.pixelRatio;
        this.style(this.progressWave, { width: pos + 'px' });
    }
});