//just for test
//var CANSHAKE = '1';
//var lotteryList = {
//	code:'1',
//	msg:[1,2,3]
//}

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

jQuery(document).ready(function($){

	//preload page0
	var baseurl = "http://coachxmas.samesamechina.com";
	var imagesArray = [
		baseurl + '/img/loading-logo.png',
		baseurl + '/img/v2/bg.jpg',
		baseurl + '/img/mar2.png',
		baseurl + '/img/qrcode.png',
		baseurl + '/img/share-3.png',
		baseurl + '/img/v2/dog-1.jpg',
		baseurl + '/img/v2/dog-2-2.png',
		baseurl + '/img/v2/dog-2.png',
		baseurl + '/img/v2/dog-3.png',
		baseurl + '/img/v2/dog-4.png',
		baseurl + '/img/v2/icon-sp.png',
		baseurl + '/img/v2/p1-1.png',
		baseurl + '/img/share.jpg'
	];
	new preLoader(imagesArray, {
		onProgress: function(){

		},
		onComplete: function(){
			$('.preloading').remove();
			if(!$('.qrcode').length){
				gotoPin(0);
			}
			//跑马灯效果
			var marEle = $('#marquee .list');
			var data = lotteryList;
			if(data.code==1){
				var listData = data.msg,
					listHtml = '';
				for(var i=0;i<listData.length;i++){
					listHtml = listHtml+'<li>'+listData[i]+'已经中奖</li>';
				}
				marEle.append(listHtml);
				marEle.marquee();
			}else if(data.code==2){
				marEle.append('<li>'+data.msg+'</li>');
				marEle.marquee();
			}else{
				console.log(data.msg);
			}
		}
	})

	//register shake
	var pin2Shake = new Shake({
		threshold: 10, //default velocity threshold for shake to register
		timeout: 1000 //default interval between events
	});
	pin2Shake.start();
	window.addEventListener('shake', shakeEventDidOccur, false);
	var enableShake = true;
	function shakeEventDidOccur () {
		//put your own code here etc.
		if($('.pin-2').hasClass('current') && parseInt(CANSHAKE)){
			if(!enableShake) return;
			enableShake = false;
			CANSHAKE='0';
			service.isPrize(function(data){
				//code msg
				//0 未登录
				//1 礼券
				//2 卡包
				//3 未中奖
				enableShake = true;
				if(data.code==1){
					//1 礼券
					gotoPin(2);
					$('.pin-3').removeClass('getcoupon');
					_hmt.push(['_trackEvent', '摇一摇', 'shake', '第二次摇奖的数量']);
				}else if(data.code==2){
					//2 卡包
					gotoPin(2);
					$('.pin-3').addClass('getcoupon');
					_hmt.push(['_trackEvent', '摇一摇', 'shake', '第一次摇奖的数量']);
				}else if(data.code==3){
					//3 未中奖
					gotoPin(3);
					_hmt.push(['_trackEvent', '摇一摇', 'shake', '第一次摇奖的数量']);
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
	$('.buttons').on('touchstart', function(){
		if($(this).hasClass('p1-3')){
			//go shake page 我要摇奖
			_hmt.push(['_trackEvent', 'buttons', 'click', '我要摇奖']);
			gotoPin(1);
			if(!parseInt(CANSHAKE)>0){
				$('.share').addClass('show');
			}
		}else if($(this).hasClass('gocoupon')){

			if($(this).hasClass('coupon-1')){
				//	领取圣诞卡券1
				_hmt.push(['_trackEvent', 'buttons', 'click', '领取圣诞卡券1']);
			}else if($(this).hasClass('coupon-2')){
				//	领取圣诞卡券2
				_hmt.push(['_trackEvent', 'buttons', 'click', '领取圣诞卡券2']);
			}
			addCard(1);
		}else if($(this).hasClass('p3-5')){
			//go form page 留下你的获奖信息
			gotoPin(4);
			_hmt.push(['_trackEvent', 'buttons', 'click', '留下你的获奖信息']);
		}else if($(this).hasClass('btn-submit')){
			if (service.formValidation()){
				//submit the form
				var name =$('.input-name').val();
				var number =$('.input-phone').val();
				service.formSubmit(name,number,function(){
					//go to success page
					gotoPin(5);
					_hmt.push(['_trackEvent', 'buttons', 'click', '提交']);
				});
			}
		}else if($(this).hasClass('p4-5')){
			//go shake page 再摇一次
			$('.share').addClass('show');
			_hmt.push(['_trackEvent', 'buttons', 'click', '再摇一次']);
		}else if($(this).hasClass('p7-btn')){
			gotoPin(0);
		}
	});

	//活动规则
	$('.p1-5').on('touchstart', function(){
		gotoPin(6);
		_hmt.push(['_trackEvent', 'buttons', 'click', '活动细则']);
	});


});
