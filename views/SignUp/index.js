$(document).ready(function () {


    let submitBtn = $("#submit")

    $(document).ajaxStart(function () {

        let spinner = `
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `
        submitBtn.html(spinner)
        submitBtn.attr("disabled", "disabled")
    })

    $(".input").keydown(function (e) {
        let input = $(e.target)
        input.parents(".boxField").removeClass("warning")
        input.parents(".boxField").find(".boxWarning p").text("")
    })

    //bắt sự kiện click nút đăng nhập
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()

        //Authentication
        let firstName = $("input[name=firstName]").val().trim()
        let lastName = $("input[name=lastName]").val().trim()
        let username = $("input[name=username]").val().trim()
        let email = $("input[name=email]").val().trim()
        let password = $("input[name=password]").val().trim()
        let passwordVerify = $("input[name=passwordVerify]").val().trim()
        let agreeRule = $("input[name=agree]").is(":checked")

        let isAllright = true
        let check = authentication(firstName, "name", 0);
        if (!check.status) {
            $("input[name=firstName]").parents(".boxField").addClass("warning")
            $("input[name=firstName]").parents(".boxField").find(".boxWarning p").text(check.message)
            isAllright = false
        }

        check = authentication(lastName, "name", 0);
        if (!check.status) {
            $("input[name=lastName]").parents(".boxField").addClass("warning")
            $("input[name=lastName]").parents(".boxField").find(".boxWarning p").text(check.message)
            isAllright = false
        }

        check = authentication(username, "username");
        if (!check.status) {
            $("input[name=username]").parents(".boxField").addClass("warning")
            $("input[name=username]").parents(".boxField").find(".boxWarning p").text(check.message)
            isAllright = false
        }

        check = authentication(email, "email");
        if (!check.status) {
            $("input[name=email]").parents(".boxField").addClass("warning")
            $("input[name=email]").parents(".boxField").find(".boxWarning p").text(check.message)
            isAllright = false
        }

        check = authentication(password, "password", 8, passwordVerify);
        if (!check.status) {
            $("input[name=password]").parents(".boxField").addClass("warning")
            $("input[name=password]").parents(".boxField").find(".boxWarning p").text(check.message)
            isAllright = false
        } else {
            $("input[name=password]").parents(".boxField").find(".boxWarning p").text("")
        }

        check = authentication(passwordVerify, "password", 8, password);
        if (!check.status) {
            $("input[name=passwordVerify]").parents(".boxField").addClass("warning")
            $("input[name=passwordVerify]").parents(".boxField").find(".boxWarning p").text(check.message)
            isAllright = false
        } else {
            $("input[name=passwordVerify]").parents(".boxField").find(".boxWarning p").text("")
        }

        if(!agreeRule){
            $(".remember").addClass("shake-horizontal")
            setTimeout(function(){
                $(".remember").removeClass("shake-horizontal")
            }, 500)
            isAllright = false
        }


        if (isAllright) {
            console.log("all ok")
            //call api đăng kí tài khoản
            $.post(`/register`, { username, password, email, firstName, lastName, submit: true }, function (data) {

                if (!data.status) {
                    //không thành công thì hiện lỗi
                    // $(".warningBox").text(data.message).addClass("shake-horizontal")
                    // $(".txt_field").addClass('warning')
                } else {
                    //nếu thành công chuyển hướng đến trang thông báo
                    window.location.replace("/register/notification");
                }
            }, "json");

        }

    })

    function authentication(string, type, num = 5, passwordVerify = null) {
        if (string == "") {
            return {
                status: false,
                message: "Vui lòng nhập trường này."
            }
        }
        if (string.length < num) {
            return {
                status: false,
                message: "Trường này phải có tối thiểu " + num + " kí tự."
            }
        }

        if (type == "password") {
            if (string !== passwordVerify) {
                return {
                    status: false,
                    message: "Mật khẩu và mật khẩu xác nhận phải trùng khớp."
                }
            }
        }

        return {
            status: true,
        }
    }
})