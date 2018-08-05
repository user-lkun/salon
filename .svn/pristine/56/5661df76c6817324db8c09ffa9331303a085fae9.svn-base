
/**图片切换*/
(function($){	
	$.fn.imgsoll=function(firstlazy){		
		var $this=$(this),index=1,len=$this.find("li").length,picTimer;
		//调用数字HTML函数
		$this.append($.fn.imgsoll.bnt(len))
		//数字hover事件
		var $span=$this.find(".bntHtml span");
		$span.hover(function(){
		  index  = $span.index(this);
			showImg(index,$span,$this);
		})
		//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
		$this.hover(function() {
			clearInterval(picTimer);
		},function() {
			clearInterval(picTimer);
			picTimer = setInterval(function() {
				showImg(index,$span,$this);
				index++;
				if(index == len) {index = 0;}
			},4000); //此4000代表自动播放的间隔，单位：毫秒
			
		}).trigger("mouseleave");
		if(firstlazy) {
			clearInterval(picTimer);
			setTimeout(function() {
				picTimer = setInterval(function() {
					showImg(index,$span,$this);
					index++;
					if(index == len) {index = 0;}
				},4000); 
			}, 6000);
		}
	}
	//加入数字HTML函数
	$.fn.imgsoll.bnt=function(len)
	{
		var html="";
		for(var i=1; i<=len; i++ )
	  {
			if(i==1)
				html=html+"<span class='curr'>"+"</span>";
			else
				html=html+"<span>"+"</span>";			
	  }
		return "<div class='layout'><div class='bntHtml'>"+html+"</div></div>";
	}	
	//动作方法
	function showImg(n,$span,$this)
	{
		 $this.find("li").eq(n).stop(true,true).fadeIn(1000).siblings().fadeOut(1000);
		 $span.eq(n).addClass("curr").siblings().removeClass("curr");
	}
	

})(jQuery);
/**  图片切换 end*/

/** 文字滚动 */
(function($){
	$.fn.textSlider = function(settings){    
        settings = jQuery.extend({
        	speed : "normal",
			    line : 2,
					type:1,
			    timer : 1000
    	}, settings);
		return this.each(function() {
			$.fn.textSlider.scllor( $( this ), settings );
    	});
    }; 
	$.fn.textSlider.scllor = function($this, settings){
		//alert($this.html());
		var ul = $( "ul:eq(0)", $this );
		var timerID;
		var li = ul.children();
		var _btnUp=$(".up:eq(0)", $this)
		var _btnDown=$(".down:eq(0)", $this)
		var liHight=$(li[0]).height();
		var upHeight=0-settings.line*liHight;
		var scrollUp=function(){
			_btnUp.unbind("click",scrollUp);
			ul.animate({marginTop:upHeight},settings.speed,function(){
				for(i=0;i<settings.line;i++){
					 ul.find("li:first").appendTo(ul);
        }
				ul.css({marginTop:0});
        _btnUp.bind("click",scrollUp); 
			});	
		};
		var scrollDown=function(){
			_btnDown.unbind("click",scrollDown);
			ul.css({marginTop:upHeight});
			for(i=0;i<settings.line;i++){
				ul.find("li:last").prependTo(ul);
            }
			ul.animate({marginTop:0},settings.speed,function(){
                _btnDown.bind("click",scrollDown); 
			});	
		};
		var autoPlay=function(){
			timerID = window.setInterval(scrollUp,settings.timer);
			//alert(settings.timer);
		};
		var autoStop = function(){
            window.clearInterval(timerID);
        };
		ul.hover(autoStop,autoPlay).mouseout();
		_btnUp.css("cursor","pointer").click( scrollUp );
		_btnUp.hover(autoStop,autoPlay);
		_btnDown.css("cursor","pointer").click( scrollDown );
		_btnDown.hover(autoStop,autoPlay)
	};
})(jQuery);
/** 文字滚动 end */



/**返回顶部&计算器*/
function backTop()
{
	var winh = $(window).height();
	var $backToTopEle = $('<a href="javascript:;" rel="nofollow" class="backToTop"></a>').appendTo($("body")).click(function() {
		    $("html, body").animate({ scrollTop:0}, 120);
	    }),
			//$counterEle= $('<a href="#" rel="nofollow" class="counterLayer" target="_blank"></a>').appendTo($("body")),
			$backToTopFun = function() {
				var st = $(document).scrollTop();		
				(st > 0)? $backToTopEle.show(): $backToTopEle.hide();
				//IE6下的定位
				if (!window.XMLHttpRequest) {
					$backToTopEle.css("top", st + winh - 142);
					//$counterEle.css("top", st + winh - 188);
				}
	    };
	$(window).bind("scroll", $backToTopFun);
}

/**返回顶部&计算器 end*/

//公共
$(function(){
	//输入框提示和选中
		var text_val;
		$(".inputText").focus(function(){
		 text_val=$(this).attr("alt");
		 $(this).addClass("inputTextCurr");
		 if($(this).val()==text_val)
		 {
			 $(this).val("");
			 $(this).css("color","#000"); 
		 }
		 else
		 {
			 $(this).css("color","#000"); 
		 }
		})
		$(".inputText").blur(function(){
			if(!$(this).val())
			{
				$(this).val(text_val);
				$(this).css("color","#000"); 
			}	 
			$(this).removeClass("inputTextCurr");
		})
	//hover加样式showCss
  $("#nav li,.financialNew,.jsWeixin,.jsqq,#listProudct dl dd,.tableClass table tr,.formUl li,#mZiliao .dlClass dl,#main .houqibao").hover(function(){
	  $(this).addClass("showCss");
	},function(){
	  $(this).removeClass("showCss");
	})
	//首页注册和登录，慢慢滑下效果
	//$("#jsIndexReg").animate({top:'40px'},1000).animate({top:'0px'},300);
	//进度条动画
	$(".jsMeter").each(function(index, element) {
    var thisW=$(this).find("em").attr("deta-width");
		$(this).find("em").animate({width:thisW},1000);
  });	
  //表单HOVER效果
  $(".formUl li").hover(function(){
	   $(this).addClass("liHover");
	},function(){
		 $(this).removeClass("liHover");
	})
	//调用返回顶部
	backTop();	

	//在线客户
	$("#adLayer").hover(function(){
	  $(this).find(".askClass").show();
		$(this).css("width","514px");
	},function(){
	  $(this).find(".askClass").hide();
		$(this).css("width","50px");
	})
	
	$(".helpTipsIcon,.zjDetail").hover(function(){
		var h=($(this).find(".helpTipsText").height()+17)*-1;
		$(this).css("background-position","-40px -180px");
		$(this).find(".helpTipsText").css("top",h);
	  $(this).find(".helpTipsText").show();
	  $(this).find(".helpTipsI").show();
	},function(){
		$(this).css("background-position","0 -180px");
	  $(this).find(".helpTipsText").hide();
	  $(this).find(".helpTipsI").hide();
	})
	//倒计时 projectCountDown是项目列表中的倒计时按钮
	$(".jsCountDown, .projectCountDown, .boomCountDown, .listCountDown, .pCountDown, .pCountDownNew").each(function(index, element) {
      var downTime=$(this).attr("data-time"),sysdate=$(this).attr("data-sysdate");
	  countDown(downTime,$(this),sysdate)
    });

})





//首页右侧滚动
function fixedSidebar() {
		var side = $('#main .column');
		if(side.length > 0) {
			var sideTop = side.offset().top + side.height();
			var h = $('#main .sidebar').height() - side.height();
			var timer = 300;
			var fixStatus = function() {                
					var winHeight = $(window).height();
					var scrollTop = $(document).scrollTop();
					var tempBottom = scrollTop + winHeight - sideTop;
					if (tempBottom > h) {
							tempBottom = h+18;
					};
					if (scrollTop + winHeight > sideTop) {
							side.css({position: 'absolute',right: '0'}).stop(true).animate({top: tempBottom}, timer)
					} 
					else {
							side.css({position: 'static',right: '0'}).stop(true).animate({top: 0}, timer)
					}
			};
			$(window).scroll(function() {
					fixStatus()
			});
			$(window).resize(function() {
					fixStatus()
			})
		}
		
};




//首页的js
$(function() {
  //首页 顶部
  $(".cusmer").hover(function() {
  	$(this).children(".cusmerQList").removeClass("disNone");
  }, function() {
  	$(this).children(".cusmerQList").addClass("disNone");
  })	
  //首页
  $(".pList li").bind("mouseover", function() {
  	$(this).addClass("curr");
  }).bind("mouseout", function() {
  	$(this).removeClass("curr");
  })

  //首页
  $("header .user").bind("mouseover", function() {
  	$(this).addClass("curr");
  }).bind("mouseout", function() {
  	$(this).removeClass("curr");
  })
  //首页
  $(".boom").bind("mouseover", function() {
    $(".progressL span").addClass("disNone");
  	$(".progressL a").removeClass("disNone");
  }).bind("mouseout", function() {
  	$(".progressL span").removeClass("disNone");
  	$(".progressL a").addClass("disNone");
  })
})





$(".productSortType .sortLi").hover(function() {
    var $this = $(this);
    var $typeLink = $this.children(".typeLink");
    var $childrenNav = $this.children(".childNav");
    var isClick = "-1";

    if($childrenNav.length > 0) {
        isClick = $typeLink.attr("data-isCleck");
        $this.css("z-index", "101");
        $childrenNav.show();
    }
}, function() {
    var $this = $(this);
    var $typeLink = $this.children(".typeLink");
    var $childrenNav = $this.children(".childNav");

    if($childrenNav.length > 0) {
        $this.css("z-index", "100");
        $childrenNav.hide();
    }
});

/**
 * 和PHP一样的时间戳格式化函数
 * @param  {string} format    格式
 * @param  {int}    timestamp 要格式化的时间 默认为当前时间
 * @return {string}           格式化的时间字符串
 */
function date(format, timestamp){
    var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());
    var pad = function(n, c){
        if((n = n + "").length < c){
            return new Array(++c - n.length).join("0") + n;
        } else {
            return n;
        }
    };
    var txt_weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var txt_ordin = {1:"st", 2:"nd", 3:"rd", 21:"st", 22:"nd", 23:"rd", 31:"st"};
    var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var f = {
        // Day
        d: function(){return pad(f.j(), 2)},
        D: function(){return f.l().substr(0,3)},
        j: function(){return jsdate.getDate()},
        l: function(){return txt_weekdays[f.w()]},
        N: function(){return f.w() + 1},
        S: function(){return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th'},
        w: function(){return jsdate.getDay()},
        z: function(){return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0},

        // Week
        W: function(){
            var a = f.z(), b = 364 + f.L() - a;
            var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;
            if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){
                return 1;
            } else{
                if(a <= 2 && nd >= 4 && a >= (6 - nd)){
                    nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
                    return date("W", Math.round(nd2.getTime()/1000));
                } else{
                    return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
                }
            }
        },

        // Month
        F: function(){return txt_months[f.n()]},
        m: function(){return pad(f.n(), 2)},
        M: function(){return f.F().substr(0,3)},
        n: function(){return jsdate.getMonth() + 1},
        t: function(){
            var n;
            if( (n = jsdate.getMonth() + 1) == 2 ){
                return 28 + f.L();
            } else{
                if( n & 1 && n < 8 || !(n & 1) && n > 7 ){
                    return 31;
                } else{
                    return 30;
                }
            }
        },

        // Year
        L: function(){var y = f.Y();return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},
        //o not supported yet
        Y: function(){return jsdate.getFullYear()},
        y: function(){return (jsdate.getFullYear() + "").slice(2)},

        // Time
        a: function(){return jsdate.getHours() > 11 ? "pm" : "am"},
        A: function(){return f.a().toUpperCase()},
        B: function(){
            // peter paul koch:
            var off = (jsdate.getTimezoneOffset() + 60)*60;
            var theSeconds = (jsdate.getHours() * 3600) + (jsdate.getMinutes() * 60) + jsdate.getSeconds() + off;
            var beat = Math.floor(theSeconds/86.4);
            if (beat > 1000) beat -= 1000;
            if (beat < 0) beat += 1000;
            if ((String(beat)).length == 1) beat = "00"+beat;
            if ((String(beat)).length == 2) beat = "0"+beat;
            return beat;
        },
        g: function(){return jsdate.getHours() % 12 || 12},
        G: function(){return jsdate.getHours()},
        h: function(){return pad(f.g(), 2)},
        H: function(){return pad(jsdate.getHours(), 2)},
        i: function(){return pad(jsdate.getMinutes(), 2)},
        s: function(){return pad(jsdate.getSeconds(), 2)},
        //u not supported yet

        // Timezone
        //e not supported yet
        //I not supported yet
        O: function(){
            var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);
            if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;
            return t;
        },
        P: function(){var O = f.O();return (O.substr(0, 3) + ":" + O.substr(3, 2))},
        //T not supported yet
        //Z not supported yet

        // Full Date/Time
        c: function(){return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P()},
        //r not supported yet
        U: function(){return Math.round(jsdate.getTime()/1000)}
    };

    return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){
        if( t!=s ){
            // escaped
            ret = s;
        } else if( f[s] ){
            // a date function exists
            ret = f[s]();
        } else{
            // nothing special
            ret = s;
        }
        return ret;
    });
}








