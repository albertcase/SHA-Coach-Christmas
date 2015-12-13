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
				if(!$('.qrcode').length){
					gotoPin(0);
				}
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
			service.isPrize(function(data){
				console.log(data);
				//code msg
				//0 未登录
				//1 礼券
				//2 卡包
				//3 未中奖
				if(data.code==1){
					//1 礼券
					gotoPin(2);
					$('.pin-3').addClass('getcoupon');
				}else if(data.code==2){
					//2 卡包
					gotoPin(2);
					$('.pin-3').removeClass('getcoupon');
				}else if(data.code==3){
					//3 未中奖
					gotoPin(3);
				}else{
					//重新刷新
					window.location.reload();
				}
			});
		}
	}

//	click buttons==>
	$('.buttons').on('click', function(){
		if($(this).hasClass('p1-3')){
			console.log(1);
			//go shake page
			gotoPin(1);
		}else if($(this).hasClass('gocoupon')){
			addCard(1);
		}else if($(this).hasClass('p3-5')){
			//go form page
			gotoPin(4);
		}else if($(this).hasClass('btn-submit')){
			if (service.formValidation()){
				console.log('validated');
				//submit the form
				var name =$('.input-name').val();
				var number =$('.input-phone').val();
				service.formSubmit(name,number,function(){
					console.log('success');
					//go to success page
					gotoPin(5);
				});
			}
		}else if($(this).hasClass('p4-5')){
			//go shake page
			$('.share').addClass('show');
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
		service.isPrize(function(data){
			console.log(data);
			//code msg
			//0 未登录
			//1 礼券
			//2 卡包
			//3 未中奖
			if(data.code==1){
				//1 礼券
				gotoPin(2);
				$('.pin-3').addClass('getcoupon');
			}else if(data.code==2){
				//2 卡包
				gotoPin(2);
				$('.pin-3').removeClass('getcoupon');
			}else if(data.code==3){
				//3 未中奖
				gotoPin(3);
			}else{
				//重新刷新
				alert(data.msg);
			}
		});
	});




});
