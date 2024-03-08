$(function(){

    let submitBtn = $("button[type='submit']")
    let input = $("input")
    input.keyup(function(e){
        if(e.target.value != ""){
            submitBtn.removeClass("disabled")
        }else{
            $('label').text("Nhập mã xác thực admin")
            input.removeClass("is-invalid")
            submitBtn.addClass("disabled")
        }
    })

    submitBtn.click(function(e){
        $.post("/verify", { verify: true, code : input.val() }, function(data){
            let parseData = JSON.parse(data)

            if(!parseData.status){
                input.addClass("is-invalid")
                $('label').text(parseData.message)
            }else{
                window.location.replace("/admin");
            }
        })
    })
})