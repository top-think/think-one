/**
 * Created by Shuai on 2016/12/20.
 */

/**
 * 导航自动选中
 */
$(function () {
    var activeNav = $('[data-active-nav]').data('active-nav');
    $('.navbar a').each(function () {
        if ($(this).attr('href') == activeNav) {
            $(this).parent('li').addClass('active');
        }
    });

    var activeMenu = $('[data-active-menu]').data('active-menu');
    $('.nav-pills a').each(function () {
        if ($(this).attr('href') == activeMenu) {
            $(this).parent('li').addClass('active');
        }
    });
});

/**
 * ajax异步请求
 */
$(function () {
    $('[data-ajax]').click(function () {
        var btn = $(this);
        var msg = btn.data('confirm');
        if (msg && !confirm(msg)) {
            return false;
        }

        $.ajax({
            url   : btn.data('ajax'),
            method: btn.data('method') ? btn.data('method') : 'get',
            data  : btn.data('value') ? btn.data('value') : ''
        }).done(function (result) {
            if (result && result.error) {
                alert(result.error);
            } else {
                if (btn.data('done')) {
                    location.href = btn.data('done');
                    return;
                } else if (result && result.url) {
                    location.href = result.url;
                    return;
                }
                location.reload();
            }
        });
    });
});