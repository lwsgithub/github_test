/**
 * 
 */
/*
Array.prototype.test = function(){
	alert(this);
}

var arr = new Array();
		for(var i = 97; i < 123; i++){
			arr[i-97] = String.fromCharCode(i);
		}
		console.log('arr: ' + arr);
arr.test();
arr.otest = function(){
	alert(this[0]);
}
arr.otest();
*/
/*
;(function(test){
	alert(test);
}('test'))();
*/

/*
function test() {
	this.tests = this;
	this.method_test = function(){
		alert(this.tests);
	}
}

test.prototype.arr = Array.prototype;


var testzz = new test();



console.log('testzz:'+testzz);


console.log('wait!');
*/

var ohover = {}
ohover.o = '';
ohover.h = '';
ohover.no = '';

ohover.init = function($w){
	ohover.o = $w.get(0);//ul
	ohover.h = $(ohover.o).find('.hovers');//选中按钮
	ohover.no = $(ohover.o).find('li').not('.hovers');//非选中按钮
	//绑定click事件
	$(ohover.o).find('li').each(function(i, o){
		ohover.omclick(o);
	});
	//非选中按钮绑定mouseover、mouseout事件
	ohover.no.each(function(i, o){
		$(o).on({
			mouseover:function(){$(this).addClass('hovers');},
			mouseout:function(){$(this).removeAttr('class');}
		});
	});
}

ohover.omclick = function(o){
	$(o).off('mouseover mouseout');
	$(o).click(function(){console.log($(this).index());
		ohover.h.removeAttr('class');
		$(this).addClass('hovers');
		ohover.h.on({
			mouseover:function(){$(this).addClass('hovers');},
			mouseout:function(){$(this).removeAttr('class');}
		});
		$(this).off('mouseover mouseout');
		ohover.h = $(this);
	});
}
















