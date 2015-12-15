jQuery(document).ready(function(){
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
                service.addChance(function(data){
                    if(data.code){
                        alert('获得一次抽奖机会');
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
                service.addChance(function(data){
                    if(data.code){
                        alert('获得一次抽奖机会');
                        gotoPin(1);
                        $('.share').removeClass('show');
                    }else{
                        alert('未登录');
                    }
                });
            },
            cancel: function () {

            }
        });


    })


});