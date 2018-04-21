$(function() {
    let showOption = false;

    let config = {
        page: 0,
        pageSize: 10,
        isLoad: true
    }

    let activityList = [];
    let $window = $(window);
    let $doc = $(document);


    getData(config.page, config.pageSize);   

    $window.scroll(function(){
    　　let scrollTop = $window.scrollTop();
    　　let scrollHeight = $doc.height();
        let windowHeight = $window.height();
    　　
    　　if(scrollTop + windowHeight == scrollHeight && config.isLoad){
            console.log('[activity] load info...');
            config.isLoad = false;
            config.page += config.pageSize;
    　　　　getData(config.page, config.pageSize, function(flag) {
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
    })
    $('.icon-list').click(function () {
        $(this).next().toggleClass('show');
    })
    $('.option').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    })
    
    /**
     * ajax获取页面数据
     */
    function getData(page, pageSize, callback) {
        $.get('./verification.php?action=getList&page=' + page + '&size=' + pageSize, function(data) {
            
            let list = JSON.parse(data);
            
            console.log(list)
            if(list.isend === 1) {
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

            let attend = `<a href="/attend_activity.php?title=${item.title}">报名</a>`;
            let nattend = `报名截止`;
            let attendMsg = (!isEnd(item)) ? attend : nattend;

            let option_tpl = `
            <div class="option-wrapper">
                <h3>
                    <a href="/activity_detail.php?activity_id=${item.l_id}">
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
                            <!-- <span class="exist" v-if="detailInfo.exist>0">(已有{{detailInfo.exist}}人参加)</span> -->
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