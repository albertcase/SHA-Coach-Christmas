
var service = function(){
    var path = '';

    var ajaxPop = {
        show:function(tips){
            if(tips){
                //$('body').append('<div class="ajaxpop"><div class="loading">'+tips+'<span></span><span></span><span></span></div></div>');
                $('body').append('<div class="ajaxpop"><div class="loading"><span class="icon-loading"></span>'+tips+'</div></div>');


            }else{
                $('body').append('<div class="ajaxpop"><div class="loading"><span class="icon-loading"></span>loading...</div></div>');
            }

        },
        hide:function(){
            if($('.ajaxpop').length){
                $('.ajaxpop').remove();
            }
        }
    };


    var isPrize = function(callback){
        ajaxPop.show();
        $.ajax({
            url:path+'/api/lottery',
            type:'POST',
            dataType:'json',
            success:function(data){
                ajaxPop.hide();
                return callback(data);
            }
        })
    };
    var formSubmit = function(name,phone,callback){
        ajaxPop.show();
        $.ajax({
            url:path+'/api/saveinfo',
            type:'POST',
            dataType:'json',
            data:{name:name,mobile:phone},
            success:function(data){
                ajaxPop.hide();
                return callback(data);
            }
        })
    };

    //0 未登录
    //1 1/0
    var isShake = function(callback){
        ajaxPop.show();
        $.ajax({
            url:path+'/api/status',
            type:'POST',
            dataType:'json',
            success:function(data){
                ajaxPop.hide();
                return callback(data);
            }
        })
    };

    //0 未登录
    //1 提交成功
    var addChance = function(callback){
        //ajaxPop.show();
        $.ajax({
            url:path+'/api/share',
            type:'POST',
            dataType:'json',
            success:function(data){
                //ajaxPop.hide();
                return callback(data);
            }
        })
    };

    ///Request.php?model=status
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
    };

    var formValidation = function(){

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

        if(validate){
            return true;
        }else{
            return false;
        }
    }

    return{
        path:path,
        isPrize:isPrize,
        formValidation:formValidation,
        isShake:isShake,
        addChance:addChance,
        formSubmit:formSubmit
        //fruitDrop:fruitDrop,
        //animate:animate
    }
}();