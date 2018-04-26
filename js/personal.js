$(function() {
    $('.btn').click(function() {
        $(this).next().toggleClass('show');
    });

    $('.icon-list').click(function () {
        $(this).next().toggleClass('show');
    });

    getData();

    function getData() {
        $.get('verification.php?action=person_info', function(res) {
            res = JSON.parse(res);
            initPage(res);
        })
    }
    function initPage(data) {
        console.log(data)
        let el = {
            avatar: $('#avatar'),
            u_name: $('#u_name'),
            number: $('#number'),
            abstract: $('#abstract'),
            depart: $('#depart'),
            email: $('#email'),
            edit: $('#edit')
        };
        if(data.avatar != '') {
            el.avatar.attr('src', data.avatar);
        }
        el.number.html(data.num);
        el.u_name.html(data.name);
        el.abstract.append('<span>' + data.abstract + '</span>');
        el.depart.html(data.depart);
        el.email.html(data.email);
        el.edit.attr('href', 'edit.php?user_id=' + data.id);
    }
})