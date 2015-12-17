(function(doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var clientWidth = docEl.clientWidth;
			var clientHeight = window.innerHeight;
			if (!clientWidth) return;
			console.log(clientWidth/clientHeight+''+750/1116);
			if(clientWidth/clientHeight > 750/1116){
				console.log(1);
				docEl.style.fontSize = 50 * (clientHeight / 558) + 'px';
				$('.wrapper').addClass('landscape');
			}else{
				console.log(2);
				$('.wrapper').removeClass('landscape');
				docEl.style.fontSize = 50 * (clientWidth / 375) + 'px';
			}

		};
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	$(function(){
		recalc();
	});
	//doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);