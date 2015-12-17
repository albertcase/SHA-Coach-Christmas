(function(doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var clientWidth = docEl.clientWidth;
			var clientHeight = window.innerHeight;
			if (!clientWidth) return;
			if(clientWidth/clientHeight > 750/1212){
				docEl.style.fontSize = 50 * (clientHeight / 606) + 'px';
			}else{
				docEl.style.fontSize = 50 * (clientWidth / 375) + 'px';
			}

		};
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	$(function(){
		recalc();
	})
	//doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);