function gotoPin(i) {
	var $pin = $('.wrap .pin');
	$pin.removeClass('current').eq(i).addClass('current');
	if(i==1){
	//	shake page
		$('.progress-bar').css('width','100%');
		$('.progress-text span').html('10');
		$('.shaking').css('opacity','0');
		progress = 100;
	}
}

function isWeiXin() {
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) == 'micromessenger') {
		return true;
	} else {
		return false;
	}
}

jQuery(document).ready(function($){


});
