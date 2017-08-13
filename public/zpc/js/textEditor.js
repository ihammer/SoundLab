'use strict';

var TextEditor = {
	defaultParams: {
	    container: null,
	    data:null,
	    width: 522,
	    height: 522,
	    textStyle: {
		        color: '#FFF',
		        fontSize: '40px',
		        backgroundColor: 'transparent',
		        textAlign: 'center',
		        height:'100%',
		        width:'100%',
		        outline:'none',
		        overflow:'hidden',
		        border:'1px solid red'
		    }
	},

	init:function  (params) {
		this.txtList = [];//保存输入的文本数据
		this.params = WaveSurfer.util.extend({}, this.defaultParams, params);

		this.container = typeof this.params.container == 'string' ?
	        document.querySelector(this.params.container) :
	        this.params.container;

	    if (!this.container) {
	        throw new Error("Container element not found");
	    }

	    this.data = this.params.data;
		// this.createBlurBg();
		this.createWrapper();
		this.createElements();
	},


/*	createBlurBg:function  () {
		this.imgBg = this.container.appendChild(document.createElement('img'));
		this.setAttributes(this.imgBg,{
			id:"imgBg",
			// width:522,
			// height:522,
			src :this.data[0].src
		})
		
		this.style(this.imgBg, {
		    position: 'absolute',
		    display:'block',
		    zIndex: 998,
		    width: '522px',
		    height: '522px',
		    overflow: 'hidden',
		});

		this.blurCanvas = this.container.appendChild(document.createElement('canvas'));
		this.setAttributes(this.blurCanvas,{
			id:"blurCanvas",
			width:'522',
			height:'522'
		})
		
		this.style(this.blurCanvas, {
		    position: 'absolute',
		    zIndex: 999,
		    width: '522px',
		    height: '522px',
		    overflow: 'hidden',
		});

		stackBlurImage("imgBg", "blurCanvas",80 ,true);
	},*/


	createWrapper:function  () {
		if(this.wrapper){return};
		this.wrapper = this.container.appendChild(document.createElement('div'));
		this.setAttributes(this.wrapper,{
			id:"editor-wrap"
		})
		this.style(this.wrapper, {
		    position: 'absolute',
		    zIndex: 1000,
		    width: '100%',
		    height: '100%',
		    overflow: 'hidden',
		    display:'none'
		});
	},

	createElements:function  () {
		if(this.textArea){ return };

		this.textArea = this.wrapper.appendChild(document.createElement('textarea'));
		this.setAttributes(this.textArea, {
			name:'editor',
			id: 'editor'
		});
		this.style(this.textArea,this.params.textStyle);

		// 文本输入框字数限制100以内
		var self = this;
		this.textArea.addEventListener('keyup', function(e) {
            var inputByteLen = self.getByteLen(this.value)
            var leftByteLen = 100 - inputByteLen;	
            // console.log(inputByteLen+"字符/剩余"+leftByteLen)

			/*var a = this.value.split('\n');
			var row = a.length-1; //<10
			var lastRow = String(a[row]);
			var lastRowbyteNum = lastRow ? lastRow.length : 0;
			console.log(a, row, lastRow, lastRowbyteNum);*/

		    if (this.value.length > 100) {
		        e.returnValue = false;
		        this.value = this.value.substr(0, 100);
		        console.log("输入框不能超过100个字符!");
		        return false;
		    }
		})
	},

	//过滤字符中的回车换行符
	ignoreReturn:function (val){
		var result = val.replace(/\r\n/g, "");
			result = val.replace(/\n/g, "");
			return result;
	},
	// 中/英文字数统计
	getByteLen: function(val) {
	    var len = 0;
	    for (var i = 0; i < val.length; i++) {
	        var length = val.charCodeAt(i);
	        if (length >= 0 && length <= 128) {
	            len += 1;
	        } else {
	            len += 2;
	        }
	    }
	    return len;
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

    txtInputStart:function  (currTime) {
    	this.textArea.removeAttribute("disabled");
    	this.textArea.value="";
    	
    	this.tempTxtData = {};
    	this.tempTxtData.timeline = currTime;

    	this.showInputTextArea();
    },

    txtInputEnd:function(){
    	var text = this.ignoreReturn(this.textArea.value);

    	if (text.length > 0 && this.tempTxtData) {
    	    this.tempTxtData.txt = this.textArea.value;
    	    this.txtList.push(this.tempTxtData);
    	    this.tempTxtData = null;
    	}

    	this.setAttributes(this.textArea,{disabled:"disabled"});
    	// this.textArea.value = "";

    	// this.hideInputTextArea();
    },

    // 显示文本框
    showInputTextArea:function()   {
    	this.style(this.wrapper,{display:'block'} )
    },

    // 隐藏文本框
    hideInputTextArea:function()   {
    	this.style(this.wrapper,{display:'none'} )
    },

    autoHidden:function(delay) {
    	
    },

    getTxtFinal:function  () {
    	return this.txtList;
    }




}