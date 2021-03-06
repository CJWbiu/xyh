$(function() {

    initEvent();

    function initEvent() {
        $('.btn').click(function() {
            $(this).next().toggleClass('show');
        });

        $('.icon-list').click(function () {
            $(this).next().toggleClass('show');
        });
        $('.add-act').click(function() {
            let id = $(this).children(0).get(0).dataset.id;
            let end = $(this).children(0).get(0).dataset.end;
            let flag = $(this).children(0).get(0).dataset.flag;
            let start = $(this).children(0).get(0).dataset.start;
            let place = $(this).children(0).get(0).dataset.place;
            let title = $(this).children(0).get(0).dataset.title;
            if(flag == 0) {
                return;
            }else if(flag == 1) {
                end = new Date(end).getTime();
                start = new Date(start).getTime();
                let data = {
                    "action": "join" ,
                    "act_id": id,
                    "end": end,
                    "start": start,
                    "place": place,
                    "title": title
                };
                console.log(data);
                $.post('verification.php', data, function(res) {
                    console.log(res);
                    try{
                        res = JSON.parse(res);
                        console.log(res);
                        if(res.errcode == '0000') {
                            window.location.href = 'ticket.php?t_id=' + res.t_id;
                        }else {
                            alert(res.errmsg);
                        }
                    }catch(e) {
                        console.log(res);
                        return;
                    }
                    
                })
            }else if(flag == 2) {
                $.post('verification.php',{"action":"esc_join","t_act_id": id}, function(res){
                    console.log(res);
                    res = JSON.parse(res);
                    if(res.errcode == '0000') {
                        window.location.reload();
                    }else {
                        console.log(res.errmsg);
                    }
                })
            }
        })
        $('#send').click(function() {
            if($('#s-msg').val() == '') {
                return;
            }
            let act_id = $(this).get(0).dataset.id;
            $.post('verification.php',{"action": "comment", "content":$('#s-msg').val(), "act_id": act_id}, function (res) { 
                console.log(res);
                res = JSON.parse(res);
                if(res.errcode == '0000') {
                    $('#s-msg').val('');
                    window.location.reload();
                }else if(res.errcode == '1000') {
                    window.location.href = 'index.php';
                    return;
                }else if(res.errcode == '3002') {
                    alert('报名后才可以评论');
                    $('#s-msg').val('');
                    return;
                }else {
                    console.log('未知错误');
                }
             })
        })
    }
})