jQuery(document).ready(function(){
    //window.wxshare = function(obj){
    //    $.ajax({
    //        url:service.path+'/wechat/jssign/json',
    //        type:'POST',
    //        data:{url:window.location.href},
    //        dataType:'json',
    //        success:function(result){
    //            var wxdata = result;
    //            wx.config({
    //                debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    //                appId: wxdata.appid, // 必填，公众号的唯一标识
    //                timestamp: wxdata.timestamp, // 必填，生成签名的时间戳
    //                nonceStr: wxdata.noncestr, // 必填，生成签名的随机串
    //                signature: wxdata.signature,// 必填，签名，见附录1
    //                jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    //            });
    //            wx.onMenuShareTimeline({
    //                title: obj.title1, // 分享标题
    //                link: obj.link, // 分享链接
    //                imgUrl: obj.img, // 分享图标
    //                success: function () {
    //                    // 用户确认分享后执行的回调函数
    //
    //                },
    //                cancel: function () {
    //                    // 用户取消分享后执行的回调函数
    //                }
    //            });
    //            wx.onMenuShareAppMessage({
    //                title: obj.title2, // 分享标题
    //                desc: obj.desc, // 分享描述
    //                link: obj.link, // 分享链接
    //                imgUrl: obj.img, // 分享图标
    //                type: '', // 分享类型,music、video或link，不填默认为link
    //                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    //                success: function () {
    //                    // 用户确认分享后执行的回调函数
    //                },
    //                cancel: function () {
    //                    // 用户取消分享后执行的回调函数
    //                }
    //            });
    //
    //        }
    //    })
    //};

    //Init the share function
    //var initShareObj = {
    //    title1:'摇一摇，遇见COACH圣诞好礼',
    //    title2:'摇一摇，遇见COACH圣诞好礼',
    //    desc:'感谢您一年的支持，点击即可遇见COACH圣诞好礼！',
    //    link:window.location.origin+window.location.pathname,
    //    img:window.location.origin+window.location.pathname+'img/wechat-share.jpg'
    //};
    //wxshare(initShareObj);


    wx.ready(function(obj){

        window.wechat_setting.friend  = {
            title: obj.title1,
            desc: obj.des,
            link: obj.link,
            imgUrl: obj.img
        };
        wx.onMenuShareAppMessage({
            title: obj.title1,
            desc: obj.des,
            link: obj.link,
            imgUrl: obj.img,
            type: '',
            dataUrl: '',
            success: function () {
                console.log('share success to friend');
            },
            cancel: function () {

            }
        });



        window.wechat_setting.timeline = {
            title: obj.title1,
            link: obj.link,
            imgUrl: obj.img
        };
        wx.onMenuShareTimeline({
            title: obj.title1,
            link: obj.link,
            imgUrl: obj.img,
            success: function () {
                console.log('share success to timeline');
            },
            cancel: function () {

            }
        });


    })


});