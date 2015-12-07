var progress = 100,
	totalShake = 0;
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
	shakeInit();
	//go to shake page
	$('.p1-3').on('click', function(){
		gotoPin(1);
	});

	//start canvas
	var requireId,
		enableAnimate = true,
		enableShake = true,
	 	total = 5,
		animateTime = 1,
		blobs = new Array(total),
		mouse_pos = { x: 0, y: 0 },
		canvas = this.__canvas = new fabric.Canvas('c', {
			width:window.innerWidth,
			height:window.innerHeight,
			renderOnAddRemove: false,
			selection: false
		}),
		maxx = canvas.width,
		maxy = canvas.height;

	fabric.Image.fromURL('http://www.jiazhoubadanmu.com/almonds-wechat-shaking/img/baddamu.png', blobLoaded);
	function blobLoaded(img) {
		for (var i = 0; i < total; i++) {
			var img = new fabric.Image(img.getElement(), {
				width:50,
				height:75,
				angle: Math.random()*45,
//                    opacity:Math.random(),
				left: Math.random() * maxx,
				top: Math.random() * maxy-maxy,
				selectable: false
			});
			img.vx = 0;
			img.vy = 0;
			canvas.add(img);
			blobs[i] = img;
		}
		//animate();
	};
	function animate(){
		animateTime++;
		//$('#c').css('opacity','1');
		for (var i = 0; i < total; i++) {
			var blob = blobs[i];
			var dx = blob.left - mouse_pos.x;
			var dy = blob.top - mouse_pos.y;
			var vy = dy;
			vy = vy+10;
			if(vy>window.innerHeight){
				vy = -maxy;
			}
			blob.top= vy;
			blob.vy = vy;
		}
		requireId = fabric.util.requestAnimFrame(animate, canvas.getElement());

		if(animateTime>2*window.innerHeight/10){
			//$('#c').css('opacity','0');
			window.cancelAnimationFrame(requireId);
			animateTime=1;
			enableAnimate = true;
		}
		canvas.renderAll();
	};


	var SHAKE_THRESHOLD = 1000,
		last_update = 0,
		x, y, z, last_x, last_y, last_z;
	function deviceMotionHandler(eventData) {
		// 获取含重力的加速度
		var acceleration = eventData.accelerationIncludingGravity;

		// 获取当前时间
		var curTime = new Date().getTime();
		var diffTime = curTime -last_update;

		// 固定时间段
		if (diffTime > 100) {
			last_update = curTime;

			x = acceleration.x;
			y = acceleration.y;
			z = acceleration.z;

			var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;
			if (speed > SHAKE_THRESHOLD) {
				//totalTime = totalTime+ diffTime;

				// TODO:在此处可以实现摇一摇之后所要进行的数据逻辑操作
				if($('.pin-2').hasClass('current')){
					//开始倒计时
					if(enableAnimate){
						enableAnimate = false;
						totalShake++;
						animate();
					}
					if(!enableShake) return;
					enableShake = false;
					var i=1;
					var startTime = setInterval(function(){
						if(i>9){
							clearInterval(startTime);
							window.cancelAnimationFrame(requireId);
							service.isPrize(totalShake,function(data){
								gotoPin(2);
								enableShake = true;
								if(data.result){
									$('.pin-3').addClass('getprize');
									//title,shareimg,sharelink,desc
									var successShareObj = {
										title1:'我摇到了满满的加州巴旦木，你敢来和我PK吗？',
										title2:'终于!',
										desc:'我摇到了满满的加州巴旦木，你敢来和我PK吗？',
										link:window.location.origin+window.location.pathname,
										img:window.location.origin+window.location.pathname+'img/wechat-share.jpg'
									};
									wxshare(successShareObj);

								}else{
									$('.pin-3').removeClass('getprize');
									//no prize
									var successShareObj = {
										title1:'啊额，什么都没摇到！你们要不要来试试？',
										title2:'终于!',
										desc:'啊额，什么都没摇到！你们要不要来试试？',
										link:window.location.origin+window.location.pathname,
										img:window.location.origin+window.location.pathname+'img/wechat-share.jpg'
									};
									wxshare(successShareObj);
								}
							});
						}
						var progressPercent =(10-i)*10+"%";
						$('.progress-bar').css('width',progressPercent);
						$('.progress-text span').html(10-i);
						i++;
					},500);
				}

			}
			last_x = x;
			last_y = y;
			last_z = z;
		}
	}

	function shakeInit(){
		if (window.DeviceMotionEvent) {
			// 移动浏览器支持运动传感事件
			window.addEventListener('devicemotion', deviceMotionHandler, false);

		} else{
			// 移动浏览器不支持运动传感事件
			console.log('不支持摇一摇功能');
		}
	}

	$('.p2-1').on('click', function(){
		//开始倒计时
		animate();
		if(!enableShake) return;
		enableShake = false;
		var i=1;
		var startTime = setInterval(function(){
			if(i>9){
				clearInterval(startTime);
				service.isPrize(totalShake, function(data){
					gotoPin(2);
					enableShake = true;
					if(data.result){
						$('.pin-3').addClass('getprize');
						//title,shareimg,sharelink,desc
						var successShareObj = {
							title1:'我摇到了满满的加州巴旦木，你敢来和我PK吗？',
							title2:'终于!',
							desc:'我摇到了满满的加州巴旦木，你敢来和我PK吗？',
							link:window.location.origin+window.location.pathname,
							img:window.location.origin+window.location.pathname+'img/wechat-share.jpg'
						};
						wxshare(successShareObj);

					}else{
						$('.pin-3').removeClass('getprize');
						//no prize
						var successShareObj = {
							title1:'啊额，什么都没摇到！你们要不要来试试？',
							title2:'终于!',
							desc:'啊额，什么都没摇到！你们要不要来试试？',
							link:window.location.origin+window.location.pathname,
							img:window.location.origin+window.location.pathname+'img/wechat-share.jpg'
						};
						wxshare(successShareObj);
					}
				});
			}
			var progressPercent =(10-i)*10+"%";
			$('.progress-bar').css('width',progressPercent);
			$('.progress-text span').html(10-i);
			i++;
		},500);


	});

	$('.p3-3').on('click', function(){
		//shake page
		gotoPin(1);
	});
	$('.p3-5').on('click', function(){
		//go to form page
		gotoPin(3);
	});

	//as follow
	$('.follow').on('click', function(){
		$('.qrcode').addClass('show');
	});
	$('.qrcode').on('click', function(){
		$('.qrcode').removeClass('show');
	});
	//share
	$('.share').on('click', function(){
		$('.share-img').addClass('show');
	});
	$('.share-img').on('click', function(){
		$('.share-img').removeClass('show');
	});

	//for pin-4
	$('.p4-close').on('click', function(){
		$('.p4-activity').removeClass('show');
		$('#form-contact').removeClass('hide');
		$('.p4-txt').removeClass('hide');
	});
	$('.btn-rule').on('click', function(){
		$('.p4-activity').addClass('show');
		$('#form-contact').addClass('hide');
		$('.p4-txt').addClass('hide');
	});

	var errorMsg = {
		add:function(ele,msg){
			if(!ele.find('.error').length){
				ele.append('<div class="error">'+msg+'</div>');
			}else{
				ele.find('.error').html(msg);
			}
		},
		remove:function(ele){
			if(ele.find('.error').length){
				ele.find('.error').remove();
			}
		}
	}

	function formValidation(){

		var validate = true;
		if(!$('.input-name').val()){
			errorMsg.add($('.input-name').parent(),'姓名不能为空');
			validate = false;
		}else{
			errorMsg.remove($('.input-name').parent());
		}

		if(!$('.input-phone').val()){
			errorMsg.add($('.input-phone').parent(),'手机号码不能为空');
			validate = false;
		}else{
			var reg=/^1\d{10}$/;
			if(!(reg.test($('.input-phone').val()))){
				validate = false;
				errorMsg.add($('.input-phone').parent(),'手机号格式错误，请重新输入');
			}else{
				errorMsg.remove($('.input-phone').parent());
			}

		}

		if(!$('.input-address').val()){
			errorMsg.add($('.input-address').parent(),'地址不能为空');
			validate = false;
		}else{
			//errorMsg.remove($('.input-address').parent());
			//xx市xx区xx路xx号xx室
			var str = $('.input-address').val();
			var patt1 = /市/g;
			var patt2 = /区/g;
			var patt3 = /路/g;
			var patt4 = /号/g;
			var patt5 = /室/g;
			var result = patt1.test(str) && patt2.test(str) && patt3.test(str) && patt4.test(str) && patt5.test(str);
			if(!result){
				validate = false;
				errorMsg.add($('.input-address').parent(),'请按照“*市*区*路*号*室”的格式输入');
			}else{
				errorMsg.remove($('.input-address').parent());
			}
		}

		if(validate){
			return true;
		}else{
			return false;
		}
	}

	$('.btn-submit').on('click', function(){

		if(formValidation()){
			console.log('验证通过');
			var name = $('.input-name').val();
			var address = $('.input-address').val();
			var phone = $('.input-phone').val();
			service.formSubmit(name,address,phone,function(data){
				if(data.status){
					gotoPin(4);
				}else{
					alert(data.msg);
				}
			});
		}
	});




});
