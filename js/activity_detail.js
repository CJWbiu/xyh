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
            if(!flag) {
                return;
            }else {
                end = new Date(end).getTime();
                $.get('verification.php?action=join&act_id=' + id + '&end=' + end, function(res) {
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
            }
        })
    }
})