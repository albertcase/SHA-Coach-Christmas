function gotoPin(i) {
	var $pin = $('.wrap .pin');
	$pin.removeClass('current').eq(i).addClass('current');
}

function isWeiXin() {
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) == 'micromessenger') {
		return true;
	} else {
		return false;
	}
}
function imgLoadDeferred($container) {
	var deferred = $.Deferred();
	var $img = $($container).find('img');
	var count = 0;
	deferred.notify(count, $img.length);
	$img.on('load error', function(e) {
		count++;
		deferred.notify(count, $img.length);
		if (count >= $img.length) {
			deferred.resolve();
		}
	});
	return deferred.promise();
}

function loadImg() {
	$('.wrap img').each(function(i, elem) {
		this.src0 = this.src;
		this.src = '';
	});
	imgLoadDeferred($('.wrap')).done(function() {
		$('.wrap img').each(function(i, elem) {
			this.src = this.src0;
		});
		imgLoadDeferred($('.wrap')).progress(function(count, length) {
			var progress = parseInt(count*100 / length)+'%';
			//$('.loading').html(progress);
		}).done(function() {

			//Hide the loading page
			var loadtime = setTimeout(function(){
				$('.loading').remove();
				gotoPin(6);
				//跑马灯效果
				$('#marquee .list').marquee();
				clearTimeout(loadtime);
			},1000);
			$('.wrap img').each(function(i, elem) {
				this.src = this.src0;
			});
		});
	});
}

jQuery(document).ready(function($){
	//preload all the images
	loadImg();
	//gotoPin(0);
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

//	go first page
	$('.back').on('click', function(){
		gotoPin(0);
	});
	$('.p1-5').on('click', function(){
		gotoPin(6);
	});





//test
	$('.p2-3').on('click',function(){
		gotoPin(2);
	});




});
