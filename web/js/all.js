;(function ($) {
    $(function () {
        $('#me-user-login-validate-code').click(function (event) {
            event.preventDefault();
            event.cancelBubble = true;
            var flag = $('#loginform-login').closest('.form-group').hasClass('has-success');

            if (flag && $(this).hasClass('disabled') === false) {
                $(this).addClass('disabled');

                $.ajax({
                    url: '/user/validate-code',
                    type: 'post',
                    data: {
                        mobile: $('#loginform-login').val()
                    },
                    success: function (data) {
                        console.log(data)
                    },
                    complete: function () {
                        var a = $('#me-user-login-validate-code');
                        a.text('一分钟后重试');
                        setTimeout(function () {
                            a.removeClass('disabled');
                            a.text('发送验证码');
                        }, 60000)
                    }
                })
            }
        })
    })
})(window.jQuery);