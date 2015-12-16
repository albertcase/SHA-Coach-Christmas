//just for test
var CANSHAKE = 0;

function addCard(i) {
	wx.addCard({
		cardList: [{
			cardId: cardListJSON[i-1].cardId,
			cardExt: '{"timestamp":"'+cardListJSON[i-1].cardExt.timestamp+'","signature":"'+cardListJSON[i-1].cardExt.signature+'"}'
		}],
		success: function(res) {
			var cardList = res.cardList;
			//alert(JSON.stringfiy(res));
		},
		fail: function(res) {
			//alert(JSON.stringfiy(res));
		},
		complete: function(res) {
			//alert(JSON.stringfiy(res));
		},
		cancel: function(res) {
			//alert(JSON.stringfiy(res));
		},
		trigger: function(res) {
			//alert(JSON.stringfiy(res));
		}
	});

};

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
		}).done(function() {

			//Hide the loading page
			var loadtime = setTimeout(function(){
				$('.preloading').remove();
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
	var enableShake = true;
	//preload all the images
	loadImg();
	//gotoPin(0);
	//$('#marquee .list').marquee();
	//register shake
	var pin2Shake = new Shake({
		threshold: 10, //default velocity threshold for shake to register
		timeout: 1000 //default interval between events
	});
	pin2Shake.start();
	window.addEventListener('shake', shakeEventDidOccur, false);
	function shakeEventDidOccur () {

		//put your own code here etc.
		if($('.pin-2').hasClass('current') && enableShake){
			CANSHAKE--;
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
				}else if(data.code==4){
					//无中奖权限
					$('.share').addClass('show');
					alert(data.msg);
				}else if(data.code==0){
					//未登录
					alert(data.msg);
				}else{
					alert('未知错误');
				}
			});
		}
	}

//	click buttons==>
	$('.buttons').on('click', function(){
		if($(this).hasClass('p1-3')){
			//go shake page
			gotoPin(1);
			if(CANSHAKE=='1'){
				enableShake = true;
			}else{
				enableShake = false;
				$('.share').addClass('show');
			}
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
			//$('.share').addClass('show');
			service.addChance(function(data){
				if(data.code){
					alert('获得一次抽奖机会');
					gotoPin(1);
				}else{
					alert('未登录');
				}
			});
		}else if($(this).hasClass('p7-btn')){
			gotoPin(0);
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
	$('.p2-2').on('click',function(){
		if($('.pin-2').hasClass('current') && enableShake){
			CANSHAKE--;
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
				}else if(data.code==4){
					//无中奖权限
					$('.share').addClass('show');
					alert(data.msg);
				}else if(data.code==0){
					//未登录
					alert(data.msg);
				}else{
					alert('未知错误');
				}
			});
		}
	});
//
//	$('.p2-t1').on('click',function(){
//		service.addChance(function(data){
//			alert(data.code);
//			if(data.code){
//				alert('获得一次抽奖机会');
//			}else{
//				alert('未登录');
//			}
//		});
//	});




});
