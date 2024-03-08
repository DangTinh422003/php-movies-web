$(function () {
    let parseData

    updateProfile()
    $(".editProfile").click(function () {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active").text("Thay đổi").removeClass("bg-warning")
            turnOffChangingProfile()
        } else {
            $(this).addClass("active").addClass("bg-warning").text("Hủy")
            turnOnChangingProfile()
        }
    })

    $(".btn[type='submit']").click(function () {
        let firstName = $("#firstName").val().trim()
        let lastName = $("#lastName").val().trim()
        let birthday = $("#birth").val().trim()
        let email = $("#email").val().trim()
        let phone = $("#phoneNumber").val().trim()
        let submitBtn = $(this)
        submitBtn.html('<div class=\"spinner-border\" role=\"status\"><span class="visually-hidden">Loading...</span></div>')

        $.post("/profile", { changeProfile: true, firstName, lastName, birthday, email, phone }, function (data) {
            submitBtn.text("Thay đổi")
            updateProfile()
            turnOffChangingProfile()
        })
    })

    $(".btn-change-pass").click(function () {
        let oldPass = $("#oldPass").val().trim()
        let newPass = $("#newPass").val().trim()
        let newPassc = $("#newPassc").val().trim()

        let isAllright = true
        let check = authentication(oldPass, "name", 0);
        if (!check.status) {
            $("label[for='oldPass'] p").text(check.message)
            isAllright = false
        }else{
            $("label[for='oldPass'] p").text("")
        }

        check = authentication(newPass, "password", 8, newPassc);
        if (!check.status) {
            $("label[for='newPass'] p").text(check.message)
            isAllright = false
        }else{
            $("label[for='oldPass'] p").text("")
        }

        check = authentication(newPassc, "password", 8, newPass);
        if (!check.status) {
            $("label[for='newPassc'] p").text(check.message)
            isAllright = false
        }else{
            $("label[for='oldPass'] p").text("")
        } 

        if(isAllright){
            $.post("/profile", {changePassword: true, oldPass, newPass}, function(response){
                console.log(response)
                let data = JSON.parse(response)
                if(data.status){
                    $("#exampleModal").removeClass("show")
                }else{
                    $("label[for='oldPass'] p").text(data.message)
                }
            })
        }
    })
})

function turnOnChangingProfile() {
    $(".card-body").addClass('active')
    $(".card-body input").attr("disabled", false)
    $(".btn[type='submit']").removeClass("disabled")
}

function turnOffChangingProfile() {
    $(".card-body input").attr("disabled", true)
    $(".btn[type='submit']").addClass("disabled")
    $(".card-body").removeClass('active')
}

function updateProfile() {
    $.get("/profile", { getFullInfor: true }, function (data) {
        parseData = JSON.parse(data);
        let userData = parseData.data

        if (parseData.status) {
            $(".name").text(userData.lastName + " " + userData.firstName)
            $(".username").text('@' + userData.username)
            $("#firstName").val(userData.firstName)
            $("#lastName").val(userData.lastName)
            $("#birth").val(userData.birthday)
            $("#email").val(userData.email)
            $("#phoneNumber").val(userData.phone)
        }
    })
}

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
