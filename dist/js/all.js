function addCard(t){wx.addCard({cardList:[{cardId:cardListJSON[t-1].cardId,cardExt:'{"timestamp":"'+cardListJSON[t-1].cardExt.timestamp+'","signature":"'+cardListJSON[t-1].cardExt.signature+'"}'}],success:function(t){t.cardList},fail:function(t){},complete:function(t){},cancel:function(t){},trigger:function(t){}})}function gotoPin(t){var e=$(".wrap .pin");e.removeClass("current").eq(t).addClass("current")}(function(){"use strict";function t(t,e){var i=[],n=this.options;return n.onProgress&&t&&n.onProgress.call(this,t,e,this.completed.length),this.completed.length+this.errors.length===this.queue.length&&(i.push(this.completed),this.errors.length&&i.push(this.errors),n.onComplete.apply(this,i)),this}var e="addEventListener"in new Image,i=function(t,e){this.options={pipeline:!1,auto:!0,prefetch:!1,onComplete:function(){}},e&&"object"==typeof e&&this.setOptions(e),this.addQueue(t),this.queue.length&&this.options.auto&&this.processQueue()};i.prototype.setOptions=function(t){var e,i=this.options;for(e in t)t.hasOwnProperty(e)&&(i[e]=t[e]);return this},i.prototype.addQueue=function(t){return this.queue=t.slice(),this},i.prototype.reset=function(){return this.completed=[],this.errors=[],this},i.prototype.addEvents=function(i,n,s){var o=this,a=this.options,r=function(){e?(this.removeEventListener("error",l),this.removeEventListener("abort",l),this.removeEventListener("load",h)):this.onerror=this.onabort=this.onload=null},l=function(){r.call(this),o.errors.push(n),a.onError&&a.onError.call(o,n),t.call(o,n),a.pipeline&&o.loadNext(s)},h=function(){r.call(this),o.completed.push(n),t.call(o,n,this),a.pipeline&&o.loadNext(s)};e?(i.addEventListener("error",l,!1),i.addEventListener("abort",l,!1),i.addEventListener("load",h,!1)):(i.onerror=i.onabort=l,i.onload=h)},i.prototype.load=function(t,e){var i=new Image;return this.addEvents(i,t,e),i.src=t,this},i.prototype.loadNext=function(t){return t++,this.queue[t]&&this.load(this.queue[t],t),this},i.prototype.processQueue=function(){var t=0,e=this.queue,i=e.length;if(this.reset(),this.options.pipeline)this.load(e[0],0);else for(;i>t;++t)this.load(e[t],t);return this},"function"==typeof define&&define.amd?define(function(){return i}):this.preLoader=i}).call(this),function(t){t.fn.marquee=function(e){function i(t,e,i){var n=i.behavior,s=i.width,o=i.dir,a=0;return a="alternate"==n?1==t?e[i.widthAxis]-2*s:s:"slide"==n?-1==t?-1==o?e[i.widthAxis]:s:-1==o?e[i.widthAxis]-2*s:0:-1==t?e[i.widthAxis]:0}function n(){for(var e=s.length,o=null,a=null,r={},l=[],h=!1;e--;)o=s[e],a=t(o),r=a.data("marqueeState"),a.data("paused")!==!0?(o[r.axis]+=r.scrollamount*r.dir,h=-1==r.dir?o[r.axis]<=i(-1*r.dir,o,r):o[r.axis]>=i(-1*r.dir,o,r),"scroll"==r.behavior&&r.last==o[r.axis]||"alternate"==r.behavior&&h&&-1!=r.last||"slide"==r.behavior&&h&&-1!=r.last?("alternate"==r.behavior&&(r.dir*=-1),r.last=-1,a.trigger("stop"),r.loops--,0===r.loops?("slide"!=r.behavior?o[r.axis]=i(r.dir,o,r):o[r.axis]=i(-1*r.dir,o,r),a.trigger("end")):(l.push(o),a.trigger("start"),o[r.axis]=i(r.dir,o,r))):l.push(o),r.last=o[r.axis],a.data("marqueeState",r)):l.push(o);s=l,s.length&&setTimeout(n,25)}var s=[],o=this.length;return this.each(function(a){var r=t(this),l=r.attr("width")||r.width(),h=r.attr("height")||r.height(),d=r.after("<div "+(e?'class="'+e+'" ':"")+'style="display: inline-block; width: '+l+"px; height: "+h+'px; overflow: hidden;"><div style="float: left; white-space: nowrap;">'+r.html()+"</div></div>").next(),c=d.get(0),u=(r.attr("direction")||"left").toLowerCase(),p={dir:/down|right/.test(u)?-1:1,axis:/left|right/.test(u)?"scrollLeft":"scrollTop",widthAxis:/left|right/.test(u)?"scrollWidth":"scrollHeight",last:-1,loops:r.attr("loop")||-1,scrollamount:r.attr("scrollamount")||this.scrollAmount||2,behavior:(r.attr("behavior")||"scroll").toLowerCase(),width:/left|right/.test(u)?l:h};-1==r.attr("loop")&&"slide"==p.behavior&&(p.loops=1),r.remove(),/left|right/.test(u)?d.find("> div").css("padding","0 "+l+"px"):d.find("> div").css("padding",h+"px 0"),d.bind("stop",function(){d.data("paused",!0)}).bind("pause",function(){d.data("paused",!0)}).bind("start",function(){d.data("paused",!1)}).bind("unpause",function(){d.data("paused",!1)}).data("marqueeState",p),s.push(c),c[p.axis]=i(p.dir,c,p),d.trigger("start"),a+1==o&&n()}),t(s)}}(jQuery);var service=function(){var t="",e={show:function(t){t?$("body").append('<div class="ajaxpop"><div class="loading"><span class="icon-loading"></span>'+t+"</div></div>"):$("body").append('<div class="ajaxpop"><div class="loading"><span class="icon-loading"></span>loading...</div></div>')},hide:function(){$(".ajaxpop").length&&$(".ajaxpop").remove()}},i=function(i){e.show(),$.ajax({url:t+"/api/lottery",type:"POST",dataType:"json",success:function(t){return e.hide(),i(t)}})},n=function(i,n,s){e.show(),$.ajax({url:t+"/api/saveinfo",type:"POST",dataType:"json",data:{name:i,mobile:n},success:function(t){return e.hide(),s(t)}})},s=function(i){e.show(),$.ajax({url:t+"/api/status",type:"POST",dataType:"json",success:function(t){return e.hide(),i(t)}})},o=function(e){$.ajax({url:t+"/api/share",type:"POST",dataType:"json",success:function(t){return e(t)}})},a=function(e){$.ajax({url:t+"/api/lotterylist",type:"POST",dataType:"json",success:function(t){return e(t)}})},r={add:function(t,e){t.find(".error").length?t.find(".error").html(e):t.append('<div class="error">'+e+"</div>")},remove:function(t){t.find(".error").length&&t.find(".error").remove()}},l=function(){var t=!0;if($(".input-name").val()?r.remove($(".input-name").parent()):(r.add($(".input-name").parent(),"姓名不能为空"),t=!1),$(".input-phone").val()){var e=/^1\d{10}$/;e.test($(".input-phone").val())?r.remove($(".input-phone").parent()):(t=!1,r.add($(".input-phone").parent(),"手机号格式错误，请重新输入"))}else r.add($(".input-phone").parent(),"手机号码不能为空"),t=!1;return t?!0:!1};return{path:t,isPrize:i,formValidation:l,isShake:s,addChance:o,formSubmit:n,marqueeList:a}}();jQuery(document).ready(function(){function t(t){wx.ready(function(){window.wechat_setting.friend={title:t.title1,desc:t.des,link:t.link,imgUrl:t.img},wx.onMenuShareAppMessage({title:t.title1,desc:t.des,link:t.link,imgUrl:t.img,type:"",dataUrl:"",success:function(){console.log("share success to friend"),CANSHAKE++,$(".share").removeClass("show"),gotoPin(1),service.addChance(function(t){t.code||alert("未登录")})},cancel:function(){}}),window.wechat_setting.timeline={title:t.title1,link:t.link,imgUrl:t.img},wx.onMenuShareTimeline({title:t.title1,link:t.link,imgUrl:t.img,success:function(){console.log("share success to timeline"),CANSHAKE++,gotoPin(1),$(".share").removeClass("show"),service.addChance(function(t){t.code||alert("未登录")})},cancel:function(){}})})}t({title1:"50份COACH圣诞福袋摇回家",des:"感谢您一年的支持，点击即可遇见COACH圣诞好礼！",link:window.location.href,img:"http://coachxmas.samesamechina.com/img/share.jpg"})}),function(t,e){"function"==typeof define&&define.amd?define(function(){return e(t,t.document)}):"undefined"!=typeof module&&module.exports?module.exports=e(t,t.document):t.Shake=e(t,t.document)}("undefined"!=typeof window?window:this,function(t,e){"use strict";function i(i){if(this.hasDeviceMotion="ondevicemotion"in t,this.options={threshold:15,timeout:1e3},"object"==typeof i)for(var n in i)i.hasOwnProperty(n)&&(this.options[n]=i[n]);if(this.lastTime=new Date,this.lastX=null,this.lastY=null,this.lastZ=null,"function"==typeof e.CustomEvent)this.event=new e.CustomEvent("shake",{bubbles:!0,cancelable:!0});else{if("function"!=typeof e.createEvent)return!1;this.event=e.createEvent("Event"),this.event.initEvent("shake",!0,!0)}}return i.prototype.reset=function(){this.lastTime=new Date,this.lastX=null,this.lastY=null,this.lastZ=null},i.prototype.start=function(){this.reset(),this.hasDeviceMotion&&t.addEventListener("devicemotion",this,!1)},i.prototype.stop=function(){this.hasDeviceMotion&&t.removeEventListener("devicemotion",this,!1),this.reset()},i.prototype.devicemotion=function(e){var i,n,s=e.accelerationIncludingGravity,o=0,a=0,r=0;return null===this.lastX&&null===this.lastY&&null===this.lastZ?(this.lastX=s.x,this.lastY=s.y,void(this.lastZ=s.z)):(o=Math.abs(this.lastX-s.x),a=Math.abs(this.lastY-s.y),r=Math.abs(this.lastZ-s.z),(o>this.options.threshold&&a>this.options.threshold||o>this.options.threshold&&r>this.options.threshold||a>this.options.threshold&&r>this.options.threshold)&&(i=new Date,n=i.getTime()-this.lastTime.getTime(),n>this.options.timeout&&(t.dispatchEvent(this.event),this.lastTime=new Date)),this.lastX=s.x,this.lastY=s.y,void(this.lastZ=s.z))},i.prototype.handleEvent=function(t){return"function"==typeof this[t.type]?this[t.type](t):void 0},i}),jQuery(document).ready(function(t){function e(){o&&(o=!1,t(".pin-2").hasClass("current")&&parseInt(CANSHAKE)&&(CANSHAKE--,service.isPrize(function(e){o=!0,1==e.code?(gotoPin(2),t(".pin-3").removeClass("getcoupon"),_hmt.push(["_trackEvent","摇一摇","shake","第二次摇奖的数量"])):2==e.code?(gotoPin(2),t(".pin-3").addClass("getcoupon"),_hmt.push(["_trackEvent","摇一摇","shake","第一次摇奖的数量"])):3==e.code?(gotoPin(3),_hmt.push(["_trackEvent","摇一摇","shake","第一次摇奖的数量"])):4==e.code?(t(".share").addClass("show"),alert(e.msg)):0==e.code?alert(e.msg):alert("未知错误")})))}var i="http://coachxmas.samesamechina.com",n=[i+"/img/v2/bg.jpg",i+"/img/loading-logo.png",i+"/img/logo.png",i+"/img/mar2.png",i+"/img/qrcode.png",i+"/img/share-3.png",i+"/img/v2/dog-1.jpg",i+"/img/v2/dog-2-2.png",i+"/img/v2/dog-2.png",i+"/img/v2/dog-3.png",i+"/img/v2/dog-4.png",i+"/img/v2/icon-sp.png",i+"/img/v2/p1-1.png",i+"/img/share.jpg"];new preLoader(n,{onProgress:function(){},onComplete:function(){t(".preloading").remove(),t(".qrcode").length||gotoPin(0);var e=t("#marquee .list"),i=lotteryList;if(1==i.code){for(var n=i.msg,s="",o=0;o<n.length;o++)s=s+"<li>"+n[o]+"已经中奖</li>";e.append(s),e.marquee()}else 2==i.code?(e.append("<li>"+i.msg+"</li>"),e.marquee()):console.log(i.msg)}});var s=new Shake({threshold:10,timeout:1e3});s.start(),window.addEventListener("shake",e,!1);var o=!0;t(".buttons").on("touchstart",function(){if(t(this).hasClass("p1-3"))_hmt.push(["_trackEvent","buttons","click","我要摇奖"]),gotoPin(1),!parseInt(CANSHAKE)>0&&t(".share").addClass("show");else if(t(this).hasClass("gocoupon"))t(this).hasClass("coupon-1")?_hmt.push(["_trackEvent","buttons","click","领取圣诞卡券1"]):t(this).hasClass("coupon-2")&&_hmt.push(["_trackEvent","buttons","click","领取圣诞卡券2"]),addCard(1);else if(t(this).hasClass("p3-5"))gotoPin(4),_hmt.push(["_trackEvent","buttons","click","留下你的获奖信息"]);else if(t(this).hasClass("btn-submit")){if(service.formValidation()){var e=t(".input-name").val(),i=t(".input-phone").val();service.formSubmit(e,i,function(){gotoPin(5),_hmt.push(["_trackEvent","buttons","click","提交"])})}}else t(this).hasClass("p4-5")?(t(".share").addClass("show"),_hmt.push(["_trackEvent","buttons","click","再摇一次"])):t(this).hasClass("p7-btn")&&gotoPin(0)}),t(".p1-5").on("touchstart",function(){gotoPin(6),_hmt.push(["_trackEvent","buttons","click","活动细则"])})});