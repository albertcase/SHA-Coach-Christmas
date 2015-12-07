
var service = function(){
    var path = 'http://www.jiazhoubadanmu.com/almonds';

    var ajaxPop = {
        show:function(tips){
            if(tips){
                $('body').append('<div class="ajaxpop"><div class="loading">'+tips+'<span></span><span></span><span></span></div></div>');
            }else{
                $('body').append('<div class="ajaxpop"><div class="loading">loading...</div></div>');
            }

        },
        hide:function(){
            if($('.ajaxpop').length){
                $('.ajaxpop').remove();
            }
        }
    };
    var isPrize = function(number,callback){
        ajaxPop.show();
        $.ajax({
            url:path+'/shake/result/json',
            type:'POST',
            data:{number:number},
            dataType:'json',
            success:function(data){
                ajaxPop.hide();
                return callback(data);
            }
        })
    };
    var formSubmit = function(name,address,phone,callback){
        ajaxPop.show();
        $.ajax({
            url:path+'/shake/info/json',
            type:'POST',
            dataType:'json',
            data:{name:name,address:address,phone:phone},
            success:function(data){
                ajaxPop.hide();
                return callback(data);
            }
        })
    };

    return{
        path:path,
        isPrize:isPrize,
        formSubmit:formSubmit
        //fruitDrop:fruitDrop,
        //animate:animate
    }
}();