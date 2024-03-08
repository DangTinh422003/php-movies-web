$(function () {
    var lastScrollTop = 0;
    window.onscroll = function (e) {
        headerChange(this)
    }

    // sử dụng khi DOM vừa load xong
    getUserData()

    //sự kiện khi scroll chuột, thanh header sẻ thay đổi tùy tình huống
    function headerChange(e) {
        var st = window.pageYOffset || document.documentElement.scrollTop
        //cuộn xuống
        if (st > lastScrollTop) {
            $(".header").removeClass("slide-in-top")
            $(".header").addClass("slide-out-top")
            changeBgHeader()
        }
        //cuộn lên
        else if (st < lastScrollTop) {
            $(".header").removeClass("slide-out-top")
            $(".header").addClass("slide-in-top")
            changeBgHeader()
        }
        lastScrollTop = st <= 0 ? 0 : st;
    }

    // hàm thay đổi background của header
    function changeBgHeader() {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            $(".header").removeClass("bg-transparent")
            $(".header").addClass("bg-dark")
        } else {
            $(".header").removeClass("bg-dark")
            $(".header").addClass("bg-transparent")
        }
    }

    //hàm gọi đến server yêu cầu đăng xuất và reload lại trang
    function logOut() {
        $.get(`/`, { logOut: true }, function () {
            location.reload()
        }, "json");
    }

    function showResult(e) {
        let value = e.target.value
        let searchResult = $(".search-result")
        searchResult.addClass("show")
        searchResult.html("")
        if (value != "") {
            $.get("/search", { q: value }, function (data) {
                let result = JSON.parse(data)

                if (result.status) {

                    result.data.forEach(function (film) {
                        let release_date = new Date(film.release_date)

                        let html = `
                            <div data-id="${film.id}" class="result-item rounded"><p>${film.title}<b>(${release_date.getFullYear()})</b></p></div>
                        `

                        searchResult.append(html)
                    })
                    $(".result-item").click(function (e) {
                        
                        let id=$(e.target)
                        window.location.href = "/detail?id="+id
                        console.log(id)

                    })
                    

                    if (result.data.length == 0) {
                        searchResult.append(`<div class="result-item rounded"><p>Không tìm thấy dữ liệu</p></div>`)
                    }
                }
            })
        }

    }

    $("input[type='search']").keyup(showResult);

    //hàm lấy dữ liệu người dùng đã đăng nhập
    function getUserData() {
        $.get(`/`, { getUserInf: true }, function (data) {
            let endContent = $("#end-content")

            let dataUser = data.data
            if (data.status) {
                let html = `<div class="userBlock d-flex align-items-center">
                                <div class="nav-item dropdown">
                                    <a class="containerAvatar nav-link" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                                        <img src="/assets/img/poster.jpg" alt="" width="35" height="35" class="avatar">
                                    </a>
                                    <ul class="slide-in-top-drop-down dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/profile">Trang cá nhân</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a id="logOutBtn" class="dropdown-item text-danger" href="#">Đăng xuất</a></li>
                                    </ul>
                                </div>
                                <h5 class="nameUser text-light fs-6">Greeting, Hải!</h5>
                            </div>`
                endContent.append(html)

                //bắt sự kiện click nút đăng xuất và gọi hàm
                $("#logOutBtn").click(logOut)
            } else {
                let html = `<button class="loginBtn btn rounded-pill">Đăng nhập</button>`
                endContent.append(html)

                //bắt sự kiện click nút đăng nhập và chuyển hướng
                $(".loginBtn").on("click", (e) => {
                    e.preventDefault()
                    window.location.href = "/login"
                })
            }
        }, "json");
    }
})