$(document).ready(function () {
    let submitBtn = $("#submit")
    //bắt sự kiện click nút đăng nhập
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let username = $("#username").val()
        let password = $("#password").val()

        //call api kiểm tra đăng nhập
        $.post(`/login`, { username, password, submit: true }, function (data) {
            console.log(data)
            if(!data.status){
                //không thành công thì hiện lỗi
                $(".warningBox").text(data.message).addClass("shake-horizontal")
                $(".txt_field").addClass('warning')
                $(".label-input").addClass('text-warning')
            }else{
                //kiểm tra quyền hạn của người đăng nhập
                if(data.role == 1){
                    //nếu thành công chuyển hướng đến trang chủ
                    window.location.replace("/");
                }else if(data.role == 0){
                    window.location.replace("/verify");
                }
            }
        }, "json");
    })

    $(".txt_field input").keydown(function () {
        $(".warningBox").text("").removeClass("shake-horizontal")
        $(".label-input").removeClass('text-warning')
        $(".txt_field").removeClass('warning')
    })
})