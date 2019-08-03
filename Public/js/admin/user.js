var reg = {
    check : function() {
        // 获取登录页面中的用户名 和 密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        var repassword = $('input[name="repassword"]').val();
        var verify = $('input[name="verify"]').val();

        if(!username) {
            dialog.error('用户名不能为空');
        }
        if(!password) {
            dialog.error('密码不能为空');
        }
        if (!repassword) {
            dialog.error('确认密码不能为空');
        }
        if(!verify) {
            dialog.error('验证码不能为空');
        }

       var url = "/index.php?c=user&a=add";
        var data = {'username':username,'password':password,'repassword':repassword,'verify':verify};
        // 执行异步请求  $.post
        $.post(url,data,function(result){
            if(result.status == 0) {
                return dialog.error1(result.message,'/index.php?c=user&a=reg');
            }
            if(result.status == 1) {
                return dialog.success(result.message, '/index.php?c=user&a=login');
            }

        },'JSON');

    }

};
var login ={
    check : function() {
        // 获取登录页面中的用户名 和 密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        var verify = $('input[name="verify"]').val();

        if(!username) {
            dialog.error('用户名不能为空');
        }
        if(!password) {
            dialog.error('密码不能为空');
        }
        if(!verify) {
            dialog.error('验证码不能为空');
        }

        var url = "/index.php?c=user&a=check";
        var data = {'username':username,'password':password,'verify':verify};
        // 执行异步请求  $.post
        $.post(url,data,function(result){
            if(result.status == 0) {
                return dialog.error1(result.message,'index.php?c=user&a=login');
            }
            if(result.status == 1) {
                return dialog.success(result.message, '/index.php');
            }

        },'JSON');

    }
};
var userout={
    check:function () {
        return dialog.confirm("是否确定退出登入",'/index.php?c=user&a=loginout');

    }
}
var adminout={
    check:function () {
        return dialog.confirm("是否确定退出登入",'/admin.php?c=login&a=loginout');

    }
}

