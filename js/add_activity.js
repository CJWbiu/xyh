$(function() {
    let file_btn = $('input[type=file]'), 
        err_info = $('.errInfo'),
        type_btn = $('#type');
    

    addEvent();
    
    /**
     * 初始化事件
     */
    function addEvent() {
        file_btn.on('change', function(e) {
            $('.fileMsg').val(e.target.value);
        });

        $('.upload').click(function() {
            file_btn.click();
        });

        type_btn.click(function() {
            console.log(1)
            type_btn.next().toggleClass('show');
        })
        $('.option-wrapper').on('click','.option', function(e) {
            let that = $(this);
            console.log(that.html())
            $('input[name=type]').val(that.html());
            that.parent().removeClass('show');
        })

        $('#submit').click(function(e) {
            e.preventDefault();
            let form = $('#modify');

            let result = validate(form);

            if(result.errnum === 0) {
                err_info.hide();

                let formData = new FormData(form.get(0));
                formData.append('action','add_activity');
                formData.append('type',$('.select > input').val())

                $.ajax({
                    url: "verification.php",
                    type: "POST",
                    data: formData,
                    processData: false, // 设置jQuery不去处理发送的数据
                    contentType: false, // 设置jQuery不去设置Content-Type请求头
                    success: function(data) {
                        data = JSON.parse(data);
                        console.log(data);
                        if(data.errcode == "0000") {
                            window.location.href = 'activity_detail.php?activity_id=' + data.id;
                        }else if(data.errcode == '1000') {
                            window.location.href = 'index.php';
                            return;
                        }
                    },
                    error: function(xht) {
                        console.log("发生错误："+xhr.status);
                    }
                });
            }else {
                err_info.show().html(result.errmsg);
                return;
            }
            
        });
    }

    /**
     * 验证表单
     * @param {object} form 
     */
    function validate(form) {
        let errnum = 0;

        form = toObj(form.serialize());

        console.log(matchTime(form.start))
        console.log(matchTime(form.end))
        if(form.release == '' || form.organizer == '' || form.start == '' || form.end == '' || form.place == '' || form.number == '') {
            return {
                errnum: ++errnum,
                errmsg: '选项不能为空'
            }
        }else if(!matchTime(form.start) || !matchTime(form.end)) {
            return {
                errnum: ++errnum,
                errmsg: '时间格式不正确'
            }
        }else {
            return {
                errnum: 0,
                errmsg: ''
            }
        }
    }

    /**
     * 将表单值转为对象
     * @param {object} form 
     */
    function toObj(form) {
        let arr = form.split('&');
        let obj = {};
        arr.forEach(function(item) {
            let data = item.split('=');
            obj[data[0]] = data[1];
        })
        return obj;
    }

    /**
     * 验证时间格式
     * @param {string} str 
     */
    function matchTime(str) {
        // let pattern = /[0-9]{4}\/[0-9]{2}\/[0-9]{2}\/[0-9]{2}:[0-9]{2}/;
        str = unescape(str);

        console.log(str);
        if(new Date(str).getTime().toString() == 'NaN') {
            return false;
        }else {
            return true;
        }
    }
})