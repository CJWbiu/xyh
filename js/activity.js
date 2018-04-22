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
                console.log('[activity] load info...');
                config.isLoad = false;
                config.page += config.pageSize;
        　　　　getData(config.page, config.pageSize, config.filter, function(flag) {
                    console.log(flag)
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
            console.log(config.filter.time);
            config.page = 0;
            config.isLoad = true;
            config.filter.input = '';
            activityList = [];
            getData(config.page, config.pageSize, config.filter)
        })
        $('.filter-type > .option').click(function() {
            config.filter.type = $(this).html();
            console.log(config.filter.type);
            config.page = 0;
            config.isLoad = true;
            config.filter.input = '';
            activityList = [];
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
        console.log(filter)
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
                $("#list").html('抱歉，没有找到相关记录X﹏X');
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

            let attend = `<a href="attend_activity.php?title=${item.title}">报名</a>`;
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
                        <-- <span class="exist">(已有{{item.exist}}人参加)</span> -->
                        </p>
                    </div>
                </div>
                <div class="o-footer">
                    <span class="is-enroll">
                        <span>${attendMsg}</span>
                    </span>
                    <span><span class="icon icon-comment" style="color: #b39218;"></span>0</span>
                    <span><span class="icon icon-like" style="color: #3642da;"></span>${item.l_like}</span>
                    <span><span class="icon icon-eye" style="color: #17ce14;"></span>${item.l_read}</span>
                </div>
            </div>
            `;
            html += option_tpl;
        }
        $('#list').html(html);

        
    }
    
})