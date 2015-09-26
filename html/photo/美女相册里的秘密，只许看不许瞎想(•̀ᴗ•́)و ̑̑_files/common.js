var media = '{'
	+'"img": ['
	+'	{"c":"1",	"s":"word1",	"w":"222",	"h":"242",	"l":"282","t":"-15","p":"absolute","b":"100% 100%","o":"1"},'
	+'	{"c":"1",	"s":"word2",	"w":"120",  "h":"175",	"l":"333","t":"30","p":"absolute","b":"100% 100%","d":"none","o":"0"},'
	+'],'
	+'"video": ['
	+'],'
	+'"audio": ['
	+']'
+'}';
var c = [];
var o = eval ("(" + media + ")");
var i=o.img,a=o.audio,v=o.video;
var w=640;h=1136;
var url="";
var innerW =window.innerWidth;
var innerH =window.innerHeight;

for(var j=0;j<i.length;j++){
    url="./images/p"+i[j].c+"_"+i[j].s+".png?"+parseInt(Math.random()*1000);
    var img=new Image();
	img.src=url;
	c.push(	".p"+i[j].c+"_"+i[j].s+"{"
			+"background:"		+"url('"+url+"') no-repeat;"
			+"width:"			+(i[j].w/w)*100+"%;"
			+"height:"			+(i[j].h/h)*100+"%;"
			+"left:"			+(i[j].l/w)*100+"%;"
			+"top:"				+(i[j].t/h)*100+"%;"
			+"position:"		+i[j].p+";"
			+"background-size:"	+i[j].b+";"
			+"display:"			+i[j].d+";"
			+"opacity:"			+i[j].o+";"
	+"}");
	}
	c.push(".load-img"+"{"+"top:"				+(585/h)*100+"%;" +"}");
	c.push(".datatime"+"{"+"margin-top:"		+(170/h)*100+"%;" +"}");
	c.push(".load-word"+"{"+"top:"				+(630/h)*100+"%;" +"}");	
for(j=0;j<=30;j++){
	c.push(
		".delay"+parseInt(j/3)+"_"+parseInt(j*10/3)%10+"{"+"animation-delay:"+(j/3).toFixed(2)+"s;"+"}"
		+".duration"+parseInt(j/3)+"_"+parseInt(j*10/3)%10+"{"+"animation-duration:"+(j/3).toFixed(2)+"s;"+"}"
	);
}
var s = document.createElement('style');
s.textContent = c.join('\r\n');
function getNum(text){
var value = text.replace(/[^0-9]/ig,""); 
return value;
}

var cou;
var jishu=0;
$(function() {
$('#p0-1').bind('touchmove',function(event){
		event.preventDefault();
});
     $('.xin').bind('touchend',function(ev) {
	 if ($(this).attr('data-type') == 0) {
      $(this).css({'background': 'url(./images/xin.png) 0 0 no-repeat','background-size': '100% 100%'});
      $(this).attr('data-type', '1');
      $(':hidden[name=' + suoyin + ']').attr('data-type', '1');
	  setTimeout(function() {
	   if (suoyin == 1) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish1.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 6) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish4.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 12) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish9.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 16) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish2.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 19) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish8.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 21) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish3.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 26) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish5.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 30) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish6.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 35) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish7.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 40) {
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish6.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        }
		else{ $('#zzblock').show();}
		 $('.my-simple-gallery').hide().css('display','none');
		},600);
			//$('.current').find('img').attr('data-type','1');
        } 
	  else {
            $(this).css({'background': 'url(./images/xin0.png) 0 0 no-repeat','background-size': '100% 100%'});
            $(this).attr('data-type', '0');
            $(':hidden[name=' + suoyin + ']').attr('data-type', '0');
           }
       //ev.preventDefault();
    });
    $('.my-simple-gallery').delegate('figure', 'touchend',function(ev) {
	    suoyin = getNum($(this).find('img').attr('src'));
	    if(suoyin == 3||suoyin == 7||suoyin == 9||suoyin == 13||suoyin == 14||suoyin == 18||suoyin == 20||suoyin == 22||suoyin == 24||suoyin == 25
		||suoyin == 27||suoyin == 28||suoyin == 29||suoyin == 34||suoyin ==36||suoyin ==43||suoyin ==47||suoyin ==49||suoyin ==54||suoyin ==57
		||suoyin ==63||suoyin ==65||suoyin ==68||suoyin ==57||suoyin ==57||suoyin ==57){
		jishu++;}
		else{jishu=0; }
		if(jishu>=5){$('#zzblock1').show()};
		$('.pswp').css('opacity','1');
	    $('.my-simple-gallery').show();
        if ($(':hidden[name=' + suoyin + ']').attr('data-type') == 0) {
            $('.xin').css('background', 'url(./images/xin0.png) 0 0 no-repeat');
            $('.xin').attr('data-type', '0');
        } else {
            $('.xin').css('background', 'url(./images/xin.png) 0 0 no-repeat');
            $('.xin').attr('data-type', '1');
        }
        //ev.preventDefault();
    })

    $('.pswp__item').bind('swiperight',function(ev) {
        suoyin--;
        if ($(':hidden[name=' + suoyin + ']').attr('data-type') == 0) {
            $('.xin').css('background', 'url(./images/xin0.png) 0 0 no-repeat');
            $('.xin').attr('data-type', '0');
        } else {
            $('.xin').css('background', 'url(./images/xin.png) 0 0 no-repeat');
            $('.xin').attr('data-type', '1');
        }
        ev.preventDefault();
    });

    $('.pswp__item').bind('swipeleft',function(ev) {
        suoyin++;
        if ($(':hidden[name=' + suoyin + ']').attr('data-type') == 0) {
            $('.xin').css('background', 'url(./images/xin0.png) 0 0 no-repeat');
            $('.xin').attr('data-type', '0');
        } else {
            $('.xin').css('background', 'url(./images/xin.png) 0 0 no-repeat');
            $('.xin').attr('data-type', '1');
        }
        ev.preventDefault();
    });

    touch.on('#return', 'touchstart',function(ev) {
        $('.my-simple-gallery').show();
		$('.pswp--supports-fs').css('opacity', '1');
        $('.p3_Dish').hide();
        ev.preventDefault();
    });
	
	touch.on('#submitBtn', 'touchstart',function(ev) {
	   $('.pswp__button--close').trigger("click");
       $('#zzblock').hide();
	   ev.preventDefault();
    });
	
	touch.on('#submitBtn1', 'touchstart',function(ev) {
	   $('.pswp__button--close').trigger("click");
       $('#zzblock1').hide();
	   ev.preventDefault();
    });
	
    /*touch.on('#ling', 'touchstart',function(ev) {
        window.location.href = 'http://m.baidu.com/s?word=%E5%A4%96%E5%8D%96&from=1010184w&tn=iphone';
    });
    touch.on('#other', 'touchstart',function(ev) {
        window.location.href = 'http://m.baidu.com/s?word=%E5%A4%96%E5%8D%96&from=1010184w&tn=iphone';
    });*/
	touch.on('.p1_word2', 'touchstart',function(ev) {
	    //swiper.slideNext();
		$('#p0-1').css({'opacity':'0','visibility;':'hidden'});
		$('#p1-1').css({'opacity':'0','visibility;':'hidden'});
        //ev.preventDefault();
    });

   $('.next_page').bind('touchend touchstart click',function(ev) {
        if (suoyin == 1) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish1.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 6) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish4.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 12) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish9.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 16) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish2.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 19) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish8.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 21) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish3.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 26) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish5.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 30) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish6.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 35) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish7.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else if (suoyin == 40) {
		    $('.pswp').css('opacity','0');
            $('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish6.jpg');
			$('.my-simple-gallery').hide();$('.pswp--supports-fs').css('opacity', '0');$('.p3_Dish').show();
			$('.pswp__button--close').trigger("click");
        } else {
		    $('#zzblock').show();
            //cou = Math.round(Math.random() * 8 + 1);
			//$('.p3_Dish img').eq(0).attr('src', 'images/p3_Dish' + cou + '.jpg');
        }
	    $('.my-simple-gallery').hide().css('display','none');
        // ev.preventDefault();
	 });

})

