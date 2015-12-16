//just for test
//var CANSHAKE = 0;

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
				//$('#marquee .list').marquee();
				var marEle = $('#marquee .list');
				service.marqueeList(function(data){
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
				});
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
	//register shake
	var pin2Shake = new Shake({
		threshold: 10, //default velocity threshold for shake to register
		timeout: 1000 //default interval between events
	});
	pin2Shake.start();
	window.addEventListener('shake', shakeEventDidOccur, false);
	function shakeEventDidOccur () {

		//put your own code here etc.
		if($('.pin-2').hasClass('current') && parseInt(CANSHAKE)){
			CANSHAKE--;
			service.isPrize(function(data){
				//code msg
				//0 未登录
				//1 礼券
				//2 卡包
				//3 未中奖
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
	$('.buttons').on('click', function(){
		if($(this).hasClass('p1-3')){
			//go shake page 我要摇奖
			gotoPin(1);
			if(!parseInt(CANSHAKE)>0){
				$('.share').addClass('show');
			}
			_hmt.push(['_trackEvent', 'buttons', 'click', '我要摇奖']);
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
	$('.p1-5').on('click', function(){
		gotoPin(6);
		_hmt.push(['_trackEvent', 'buttons', 'click', '活动细则']);
	});


});
