$(document).ready(function () {

  let comment_area = $("#comment_area").val()
  let id = $("#data-id").attr("data-id");
  let user = $("#data-id").attr("data-user");
  $.get(`/detail`, { id, getcmt: true, type: "send" }, function (data) {
    if (data.status) {
      data.data.forEach(function (cmt, index) {
        html = `<div class="row cmt_row">
                        <div class="col-lg-1 col-md-1 col-3 float-center float-lg-end">
                            <img class="float center" width="100%" src="/assets/img/Layer_1-2.png">
                        </div>
                        <div class="col-lg-6 col-8 col-md-10 cmtsection">
                            <p id="username">${cmt.name}</p>
                            <p id="usercmt">${cmt.comment}</p>
                        </div>
                        <div class="col-lg-5 col-md-5 col-1"></div>
                   </div>`

        $("#cmt").append(html);
      })
    } else {
      console.log("Failed")
    }
  }, "json");

  let submitBtn = $(".comment_btn");
  submitBtn.click(function (e) {
    e.preventDefault()
    let comment_area = $("#comment_area").val()
    $("#cmt").empty();
    $("#comment_area").val("");
    if (user != "") {
      $.post(`/detail`, { id: id, username: user, comment: comment_area, type: "insert" }, function (data) {
        if (data.status) {
          console.log(data);
          data.data.forEach(function (cmt, index) {
            html = `<div class="row cmt_row">
                                <div class="col-lg-1 col-md-1 col-3 float-center float-lg-end">
                                    <img class="float center" width="100%" src="/assets/img/Layer_1-2.png">
                                </div>
                                <div class="col-lg-6 col-8 col-md-10 cmtsection">
                                    <p id="username">${cmt.name}</p>
                                    <p id="usercmt">${cmt.comment}</p>
                                </div>
                                <div class="col-lg-5 col-md-5 col-1"></div>
                           </div>`

            $("#cmt").append(html);
          })
        } else {
          console.log("Failed")
        }
      }, "json");
    }

  })

  $(".play_icon").click(
    function (e) {
      let id = $(e.target).parent("#play_btn").attr("data-id")
      window.location.href = "/watch?id=" + id
    }
  )
})
$(function () {
  $.get("/", { getRecommendMovies: true }, function (data) {
    let filmsData = JSON.parse(data)

    let recommendFilmsContainer = $(".recommendFilmsContainer")
    filmsData.data.forEach(function (film) {

      let poster = "https://image.tmdb.org/t/p/w500" + film.poster_path
      let release_date = new Date(film.release_date)

      let html = `
        <div class="col-lg-2 text-light">
        <div class="bg-transparent card me-1 g-0 w-100" style="width: 18rem;">
          <div class="watchLink position-relative" data-id="${film.id}">
            <img src="${poster}" class="card-img-top rounded watchThumbnail" alt="...">
            <h3 class="position-absolute top-50 start-50 translate-middle text-light">Xem ngay</h3>
          </div>
          <div class="card-body">
            <h5 class="card-title linkToDetail style="color:white" data-id="${film.id}">${film.title}</h5>
            <div class="card-subInf d-flex justify-content-between">
              <p class="card-text text-secondary">${release_date.getFullYear()}</p>
              <div class="favouriteTotal d-flex">
                <i class="fa-solid fa-heart me-2"></i>
                <p>lượt thích:</p>
                <b>50</b>
              </div>
            </div>
          </div>
        </div>
      </div>
        `
      recommendFilmsContainer.append(html)

    })
    $(".watchLink").click(function (e) {
      let id = $(e.target).parent(".watchLink").attr("data-id")
      console.log(id)
      window.location.href = "/watch?id=" + id
    })
    $(".linkToDetail").click(function (e) {
      let id = $(e.target).attr("data-id")
      window.location.href = "/detail?id=" + id
    })
  })
})
