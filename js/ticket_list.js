$(function() {
    Date.prototype.toLocaleString = function(format) {
        const set = function(num) {
            if(num < 10) {
                return "0" + num;
            }else {
                return num;
            }
        }
        let result = '';
        switch(format) {
            case "Y-M-d H:m": 
                result = set(this.getFullYear()) + "-" + set(this.getMonth() + 1) + "-" + set(this.getDate()) + " " + set(this.getHours()) + ":" + set(this.getMinutes());
                break;
            case "Y/M/d/H:m":
                result = set(this.getFullYear()) + "/" + set(this.getMonth() + 1) + "/" + set(this.getDate()) + "/" + set(this.getHours()) + ":" + set(this.getMinutes());
                break;
            case "Y/M/d H:m":
                result = set(this.getFullYear()) + "/" + set(this.getMonth() + 1) + "/" + set(this.getDate()) + " " + set(this.getHours()) + ":" + set(this.getMinutes());
                break;    
        }
        return result;
        
    };

    $.get('verification.php?action=all_ticket', function(res) {
        res = JSON.parse(res);
        console.log(res);
        // return;
        if(!res.errcode) {
            attendTpl(res)
        }else if(res.errcode == '1000') {
            console.log(res);
            window.location.href = 'index.php';
            return;
        }
        
    })

    initEvent();

    function initEvent() {
        $('.btn').click(function() {
            $(this).next().toggleClass('show');
        });

        $('.icon-list').click(function () {
            $(this).next().toggleClass('show');
        });
    }

    function attendTpl(list) {
        let html = '';
        list.forEach(function(item) {
            let start = new Date(parseInt(item.t_start)).toLocaleString("Y/M/d H:m");
            let end = new Date(parseInt(item.t_end)).toLocaleString("Y/M/d H:m");
            start = start.split(' ');
            let flagMsg = (item.t_flag == 0) ? '<span class="flag" style="background: #4CAF50;">未使用</span>' : '<span class="flag" style="background:rgb(155, 155, 155);">已使用</span>';
            let tpl = `
                <li>
                    <a class="ticket" href="ticket.php?t_id=${item.t_id}">
                        <div class="left">
                            <p class="day">${start[0].slice(2)}</p>
                            <p class="time">${start[1]}</p>
                        </div>
                        <div class="right">
                            <h3>${item.t_title} </h3>
                            <p>有效期至${end}</p>
                            <p>${item.t_place}</p>
                        </div>
                    </a>
                    ${flagMsg}
                </li>
            `;
            html += tpl;
        })
        $('.ticket-wrapper').html(html);
    }
})
