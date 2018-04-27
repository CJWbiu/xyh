$(function() {
    getData();

    $('.btn').click(function() {
        $(this).next().toggleClass('show');
    });

    $('.icon-list').click(function () {
        $(this).next().toggleClass('show');
    });
    $('.upload').click(function() {
        $('input[type=file]').click();
    })
    $('input[type=file]').on('change', function() {
        $('.fileMsg').val($(this).val());
    })

    $('#submit').click(function(e) {
        e.preventDefault();
        let formData = new FormData($('#form').get(0));
        formData.append('action','update_info');
        $.ajax({
            url: "verification.php",
            type: "POST",
            data: formData,
            processData: false, // 设置jQuery不去处理发送的数据
            contentType: false, // 设置jQuery不去设置Content-Type请求头
            success: function(data) {
                data = JSON.parse(data);
                if(data.errcode == "0000") {
                    window.location.href = 'personal.php';
                }else {
                    console.log(data.errmsg);
                }
            },
            error: function(xht) {
                console.log("发生错误："+xhr.status);
            }
        });
    })
    function getData() {
        $.get('verification.php?action=person_info', function(res) {
            res = JSON.parse(res);
            console.log(res)
            if(res.name) {
                $('input[name=name]').val(res.name);
            }
            if(res.email) {
                $('input[name=email]').val(res.email);
            }
            if(res.num) {
                $('input[name=number]').val(res.num);
            }
            if(res.depart) {
                $('input[name=depart]').val(res.depart);
            }
            if(res.password) {
                $('input[name=psw]').val(res.password);
            }
            if(res.abstract) {
                $('input[name=abstract]').val(res.abstract);
            }
            if(res.avatar) {
                $('input[name=old]').val(res.avatar);
            }
        })
    }
})