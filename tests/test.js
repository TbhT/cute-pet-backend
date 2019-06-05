// 新建信息流
$.ajax({
    url: '/tweet/j-create',
    type: 'post',
    data: {
        text: '这是第一条动态'
    },
    success: function (data) {
        console.log(data);
    },
    error: function (error) {
        console.log(error)
    }
});


// 获取所有信息流

$.ajax({
    url: '/tweet/j-all-tweets',
    type: 'post',
    data: {
        offset: 0
    },
    success: function (data) {
        console.log(data)
    },
    error: function (error) {
        console.log(error)
    }
});