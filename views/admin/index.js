let pageNumber = 1
let numItem = 0

$(function () {
    loadMainPage("movies")

    $(".nav-item").click(function (e) {
        $(".nav-link.active").removeClass("active");
        $(e.target).addClass("active")

        let action = $(e.target).attr("data-action")
        loadMainPage(action)
    })

    $(".inputSearch").keyup(function (e) {
        let q = $(e.target).val()
        searchData(q)
        addOpenDetailpage()
        addDeleteClickEvent()
    })

    $("#deleteBtn").click(function (e) {
        let action = $(e.target).attr("data-delete-type")
        let id = $(e.target).attr("data-id")

        switch (action) {
            case "movie": {
                deleteMovie(id)
                break
            }
        }
    })

    $(".backBtn").click(function (e) {
        loadMainPage("movies")
    })
})

function loadMainPage(action) {
    $(".subPage.show").removeClass("show").addClass("hidden")
    switch (action) {
        case "users": {
            $('.usersPage').removeClass("hidden").addClass("show")
            break
        } case "genres": {
            $('.genresPage').removeClass("hidden").addClass("show")
            break
        } case "movies": {
            $('.moviesPage').removeClass("hidden").addClass("show")
            pageNumber = 1
            $("#tableBody").html("")
            loadData(action)
            break
        } case "comments": {
            $('.commentsPage').removeClass("hidden").addClass("show")
            break
        } case "detail": {
            $('.detailPage').removeClass("hidden").addClass("show")
        }
    }
}

function loadData(action) {
    switch (action) {
        case "users": {

            break
        } case "genres": {

            break
        } case "movies": {
            $.get("/", { getSortMovies: true, listGenresSelect: "", yearSelected: "none", sortType: "none", pageNumber }, function (data) {
                let parseData = JSON.parse(data)

                let bodyTable = $("#tableBody")
                $(".btn-more").remove()
                parseData.data.forEach(function (film) {

                    numItem++

                    let html = `
                        <tr data-id="${film.id}">
                            <td>${numItem}</td>
                            <td>${film.id}</td>
                            <td>${film.title}</td>
                            <td>${film.duration} phút</td>
                            <td>${film.release_date}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn-sm btn-success me-2 inforButton">Thông tin</button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn-sm btn-danger deleteButton">Xóa</button>
                                </div>
                            </td>
                        </tr>
                    `

                    bodyTable.append(html)
                })
                addDeleteClickEvent()
                addOpenDetailpage()
                bodyTable.append(`<tr class="btn-more"><td colspan="6">Xem thêm</td></tr>`)

                $(".btn-more").click(() => loadData("movies"))

                if (pageNumber == 1) {
                    let totalFilm = parseData.totalPage * 18
                    $(".totalSingleFilm h2").text(totalFilm)
                }
                pageNumber++
            })
            break
        } case "comments": {

            break
        }
    }
}

function searchData(q) {
    let bodyTable = $("#tableBody")
    if (q !== "") {
        $.get("/search", { q }, function (data) {
            let parseData = JSON.parse(data)

            bodyTable.html("")
            $(".btn-more").remove()
            numItem = 0

            parseData.data.forEach(function (film) {

                numItem++

                let html = `
                        <tr data-id="${film.id}">
                            <td>${numItem}</td>
                            <td>${film.id}</td>
                            <td>${film.title}</td>
                            <td>${film.duration} phút</td>
                            <td>${film.release_date}</td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn-sm btn-success me-2">Thông tin</button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn-sm btn-danger deleteButton"">Xóa</button>
                                </div>
                            </td>
                        </tr>
                    `

                bodyTable.append(html)
            })
            addDeleteClickEvent()
        })
    } else {
        pageNumber = 1
        numItem = 0
        bodyTable.html("")
        loadMainPage("movies")
    }
}

function addDeleteClickEvent() {
    $(".deleteButton").click(function (e) {

        let id = $(e.target).parents("tr").attr("data-id")
        let title = $(e.target).parents("tr").find("td:nth-child(3)").text()

        $(".subMessage").text("Phim: " + title)
        $(".idMessage").text("Id: " + id)
        $("#deleteBtn").attr("data-delete-type", "movie").attr("data-id", id)

        $('#deleteModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    })
}

function addOpenDetailpage() {
    $(".inforButton").click(function (e) {
        let id = $(e.target).parents("tr").attr("data-id")
        var [dataFilm, genres] = loadDetailData(id)
        loadMainPage("detail")
        console.log(dataFilm, genres)

        $("#editBtn").click(function (e) {
            $("input[name='title']").val(dataFilm.title)
            $("input[name='overview']").val(dataFilm.overview)
            $("input[name='tagline']").val(dataFilm.tagline)
            $("input[name='release_date']").val(dataFilm.release_date)
            $("input[name='country']").val(dataFilm.country)
            $("input[name='duration']").val(dataFilm.duration)

        })
    })
}

function deleteMovie(id) {
    $.post("/admin", { deleteMovie: true, id }, function (data) {
        let parseData = JSON.parse(data)

        if (parseData.status) {
            $(".modal-close").click()
            $(".toast").addClass("show").addClass("bg-success").removeClass("bg-danger")
            $(".message").text(parseData.message)
        } else {
            $("#deleteModal").removeClass("show")
            $(".toast").addClass("show").removeClass("bg-success").addClass("bg-danger")
            $(".message").text(parseData.message)
        }
        $("#tableBody").html("")
        loadData("movies")

        let timer = setTimeout(function () {
            $(".toast").removeClass("show")
        }, 3000)

        $(".toast btn-close").off("click")

        $(".toast btn-close").click(function () {
            $(".toast").removeClass("show")
            clearTimeout(timer)
        })

    })
}

function loadDetailData(id) {
    var a = {dataFilm: "", genres: ""}
    $.get("/admin", { id, detailMovie: true }, function (data) {
        dataFilm = JSON.parse(data)
        a.dataFilm = dataFilm
        $("#name-field").text(dataFilm.title)
        $("#overview-field").text(dataFilm.overview)
        $("#tagline-field").text(dataFilm.tagline)
        $("#release_date").text(dataFilm.release_date)
        $("#country-field").text(dataFilm.country)
        $("#duration-field").text(dataFilm.duration + " phút")

        let poster_path = "https://image.tmdb.org/t/p/w500" + dataFilm.poster_path
        $(".poster img").attr("src", poster_path)
    })
    $.get("/admin", { id, getGenres: true }, function (data) {
        genres = JSON.parse(data)
        a.genres = genres
        let genresContainer = $("#genres-field")
        genresContainer.html("")
        genres.forEach(function (genre) {
            let html = `
                    <span class="badge bg-secondary">${genre.name}</span>
                `
            genresContainer.append(html)
        })
    })
    return [a.dataFilm, a.genres]
}