$(function() {
    let info = {
        errmsg: '',
        name: $('#user'),
        psw: $('#psw'),
        email: $('#email'),
        errbox: $('#errmsg')
    };
    $('.clear').click(function() {
        $(this).prev().val('');
    });
    $('.btn').click(function() {
        let data = {
            "action": "register",
            "name": info.name.val(),
            "email": info.email.val(),
            "psw": info.psw.val()
        };
        if(!validate(data)) {
            info.errbox.show().html(info.errmsg);
            return;
        };
        $.post('verification.php', data, function(res) {
            res = JSON.parse(res);
            if(res.errcode == '0000') {info.errbox.hide();
                window.location.href = 'personal.php';
            }else {
                console.log(res.errmsg);
                info.errbox.show().html(res.errmsg);
            }
        })
    })

    function validate(data) {
        for(let i in data) {
            if(data[i] == '') {
                info.errmsg = '信息不能为空';
                return false;
            }
        }
        let pattern = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
        if(data.name.length > 8 || data.name.length < 2) {
            info.errmsg = '姓名2~8位';
            return false;
        }else if(data.psw.length < 6 || data.psw.length > 12) {
            info.errmsg = '密码6~12位';
            return false;
        }else if(!pattern.test(data.email)) {
            info.errmsg = '邮箱格式不正确';
            return false;
        }else {
            return true;
        }
    }
})
