jQuery(document).ready(function(){
    function weixinshare(obj){
        wx.ready(function(){

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
                    CANSHAKE++;
                    $('.share').removeClass('show');
                    service.addChance(function(data){
                        if(data.code){
                            //alert('获得一次抽奖机会');
                        }else{
                            alert('未登录');
                        }
                    });

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
                    CANSHAKE++;
                    $('.share').removeClass('show');
                    service.addChance(function(data){
                        if(data.code){
                            //alert('获得一次抽奖机会');
                        }else{
                            alert('未登录');
                        }
                    });
                },
                cancel: function () {

                }
            });


        })
    }

    weixinshare({
        title1: '摇一摇，遇见COACH圣诞好礼',
        des: '感谢您一年的支持，点击即可遇见COACH圣诞好礼！',
        link: window.location.href,
        img: window.location.origin+'/img/share.jpg'
    })

});