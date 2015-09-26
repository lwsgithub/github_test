/**
 * 
 */

var tests = function(){
	this.name = 'tests';
	this.init = function(){
		this.name = 'init';
	}
}
tests.prototype.nmethod = function(){
	console.log('this:'+this);
	return 'nmehtod';
}
tests.prototype.omethod = function(){
		return 'omethod';
}
tests.wmethod = function(){
	this.name = 'wmethod';
	return this.name;
}
tests.ss = function(){
	this.name = 'ss';
	return this.name;
}