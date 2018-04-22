$(function() {
    let showOption = false;

    let config = {
        page: 0,
        pageSize: 10,
        isLoad: true,
        filter: {
            input: '',
            type: '',
            time: ''
        }
    }

    let activityList = [];
    let $window = $(window);
    let $doc = $(document);
    let search_msg = $('#j_msg');


    getData(config.page, config.pageSize, config.filter); 

    initEvent();

    /**
     * 初始化事件
     */
    function initEvent() {
        $window.scroll(function(){
        　　let scrollTop = $window.scrollTop();
        　　let scrollHeight = $doc.height();
            let windowHeight = $window.height();
        　　
        　　if(scrollTop + windowHeight == scrollHeight && config.isLoad){
                config.isLoad = false;
                config.page += config.pageSize;
        　　　　getData(config.page, config.pageSize, config.filter, function(flag) {
                    if(flag === 1) {
                        config.isLoad = true;
                    }else {
                        config.isLoad = false;
                    }
                });
        　　}
        });
    
        $('.triangle').click(function() {
            if(!showOption) {
                $('.other-option').show();
                $(this).addClass('rotate');
                showOption = true;
            }else {
                $('.other-option').hide();
                $(this).removeClass('rotate');
                showOption = false;
            }
        })
    
        $('.btn').click(function() {
            $(this).next().toggleClass('show');
        });

        $('.icon-list').click(function () {
            $(this).next().toggleClass('show');
        });

        $('.option').click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('#j_search').click(function() {
            config.filter.input = search_msg.val();
            if(!config.filter.input) {
                return;
            }else {
                config.page = 0;
                config.isLoad = true;
                config.filter.type = '';
                config.filter.time = '';
                $('.default').addClass('active').siblings().removeClass('active');
                activityList = [];
                getData(config.page,config.pageSize,config.filter);
            }
        })

        $('.filter-option > .option').click(function() {
            config.filter.time = $(this).html();
            config.page = 0;
            config.isLoad = true;
            config.filter.input = '';
            activityList = [];
            search_msg.val('');
            getData(config.page, config.pageSize, config.filter)
        })
        $('.filter-type > .option').click(function() {
            config.filter.type = $(this).html();
            config.page = 0;
            config.isLoad = true;
            config.filter.input = '';
            activityList = [];
            search_msg.val('');
            getData(config.page, config.pageSize, config.filter)
        })

    }
    
   /**
    * 获取数据
    * @param {number} page 字段起始行
    * @param {number} pageSize 一次获取的数量
    * @param {function} [callback] 回调 可无
    */
    function getData(page, pageSize, filter, callback) {
        let str = '';
        for(let i in filter) {
            if(filter[i] != '') {
                str += '&' + i + '=' + filter[i];
            }
        }
        console.log(str);
        
        $.get('./verification.php?action=getList' + str + '&page=' + page + '&size=' + pageSize, function(data) {
        
            let list = JSON.parse(data);
            
            console.log(list)
            if(list.isempty === 1) {
                $("#list").html('<p class="err">抱歉，没有找到相关记录X﹏X</p>');
                return;
            }
            if(list.isend === 1 ) {
                console.log('is end...');
                callback&&callback(0);
            }else {
                activityList = activityList.concat(list);
                appendHtml(activityList);
                callback&&callback(1);
            }
            
        })

    }

    /**
     * 展示页面
     * @param {Array} list 
     */
    function appendHtml(list) {
        let html = '';
        for(let i = 0; i < list.length; i++) {
            let item = list[i];

            let isEnd = function(item) {
                var now =  (new Date()).getTime();
                var end =  (new Date(item.l_end)).getTime();
                if(end - now > 0) {
                    return false;
                }else {
                    return true;
                }
            }

            let isEnded = (!isEnd(item)) ? '' : 'end';
            let endMsg = (!isEnd(item)) ? '报名中' : '报名截止';
            let attend = `<span onclick="join(${item.id},'${item.l_end}')" data-id="${item.id}" data-end="${item.l_end}" class="jointo">报名</span>`;
            let nattend = `报名截止`;
            let attendMsg = (!isEnd(item)) ? attend : nattend;

            let option_tpl = `
            <div class="option-wrapper">
                <h3>
                    <a href="activity_detail.php?activity_id=${item.id}">
                        <span class="${isEnded}">【${endMsg}】</span>${item.l_title}
                    </a>
                </h3>
                <div class="content">
                    <div class="left" style="background: url('${item.l_img}')"></div>
                    <div class="right">
                        <p>发起: ${item.l_release}</p>
                        <p>组织: ${item.l_organizer}</p>
                        <p>时间： ${item.l_start}</p>
                        <p>地点： ${item.l_place}</p>
                        <p>人数： ${item.l_number}
                        </p>
                    </div>
                </div>
                <div class="o-footer">
                    <span class="is-enroll">
                        <span class="enrollmsg">${attendMsg}</span>
                    </span>
                    <span><span class="icon icon-comment" style="color: #b39218;"></span>0</span>
                    <span class="like" onclick="like(${item.id})" data-id="${item.id}"><span class="icon icon-like" style="color: #3642da;"></span>${item.l_like}</span>
                    <span><span class="icon icon-eye" style="color: #17ce14;"></span>${item.l_read}</span>
                </div>
            </div>
            `;
            html += option_tpl;
        }
        $('#list').html(html);

        
    }
    
})
function like(id) {
    console.log(id);
    return;
    $.get('verification.php?action=like&act_id=' + id, function(res) {
        res = JSON.parse(res);
        console.log(res);
        if(res.errcode == 1000) {
            window.location.href = 'login.php';
        }
    })
}

function join(id,end) {
    end = new Date(end).getTime();
    $.get('verification.php?action=join&act_id=' + id + '&end=' + end, function(res) {
        // res = JSON.parse(res);
        console.log(res);
        try{
            res = JSON.parse(res);
            if(res.errcode == '0000') {
                window.location.href = 'ticket.php?t_id=' + res.t_id;
            }else if(res.errcode == '0002') {
                alert('已经报过名了');
                window.location.href = 'ticket.php?t_id=' + res.t_id;
            }else {
                alert('报名失败');
            }
        }catch(e) {
            console.log(res);
            return;
        }
        
    })
}