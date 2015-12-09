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

	gotoPin(0);
	//跑马灯效果
	$('#marquee .list').marquee();


	//register shake
	var testShake = new Shake({
		threshold: 10, //default velocity threshold for shake to register
		timeout: 1000 //default interval between events
	});
	testShake.start();
	window.addEventListener('shake', shakeEventDidOccur, false);
	function shakeEventDidOccur () {

		//put your own code here etc.
		if($('.pin-2').hasClass('current')){
			console.log('start api');
		}
	}

//	click buttons==>
	$('.buttons').on('click', function(){
		if($(this).hasClass('p1-3')){
			console.log(1);
			//go shake page
			gotoPin(1);
		}else if($(this).hasClass('p3-5')){
			//go form page
			gotoPin(4);
		}else if($(this).hasClass('btn-submit')){
			//submit the form
			//var name =
			//service.formSubmit(name,number,function(){
            //
			//});
			if (service.formValidation()){
				console.log('validated');
			}
		}else if($(this).hasClass('p4-5')){
			//go shake page
			gotoPin(1);
		}
	});





//test
	$('.p2-3').on('click',function(){
		gotoPin(2);
	});




});
