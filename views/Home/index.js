let countLoader = 0

$(document).ajaxStart(function () {
  if (countLoader < 6) {
    $("body").addClass("fade")
  }
});

$(document).ajaxSuccess(function () {
  if (++countLoader >= 6) {
    $("body").removeClass("fade")
  }
});

// lấy dữ liệu 5 phim đặc biệt cho vào carousel
$(async function () {

  let carousel = $("#carouselCaptions .carousel-inner")

  function renderGenres(listGenre) {
    let html = ""
    listGenre.forEach(function (genre) {
      genreName = ""
      if (genre.name.includes("Phim")) {
        genreName = genre.name.replace("Phim ", "")
      }
      html += `<div class="rounded-pill text-dark genre-block me-2 mb-1 d-flex align-items-center justify-content-center">${genreName}</div>`
    })
    return html
  }

  $.get(`/`, { getSpecialMovie: true }, function (data) {
    data = JSON.parse(data);
    if (data.status) {
      films = data.data
      films.forEach(function (film) {

        let backdrop = "https://image.tmdb.org/t/p/original" + film.backdrop_path
        let thumbnail = `https://img.youtube.com/vi/${film.trailer_key}/maxresdefault.jpg`

        html = `
                <div class="carousel-item position-relative align-items-center align-items-center">
                  <img src="${backdrop}" class="slideBackdrop d-1lock w-100 position-absolute" alt="...">
                  <div class="informationFilm flex-row d-flex align-items-end justify-content-around carousel-caption position-absolute">
                    <div class="blockLeft col-lg-5">
                      <div class="mainInfo d-flex flex-column w-100">
                        <div class="infor d-flex w-100 justify-content-between">
                          <h5 class="filmName text-start">
                            ${film.title.toUpperCase()}
                          </h5>
                        </div>
                        <div class="mb-4 genreGroup d-flex flex-ow align-items-end flex-wrap">
                          ${renderGenres(film.genres)}
                        </div>
                        <div class="mb-3 buttonGroup d-flex flex-row">
                          <button type="button" class="me-2 rounded-pill btn  btn-watch" data-id="${film.id}">
                            <i class="fa-solid fa-play text-light"></i>
                            Xem ngay
                          </button>
                          <button type="button" class="me-2 btn rounded-pill btn-inf " data-id="${film.id}">
                            <i class="fa-solid fa-circle-info"></i>
                            Chi tiết
                          </button>
                        </div>
                      </div>
                      <div class="overview">
                        <p class="">${film.overview}</p>
                      </div>
                    </div>
                    <div class="blockRight col-lg-5 d-flex flex-column justify-content-end align-items-end">
                      <div class="markFilm w-100 g-0 h-100 mb-2 d-flex flex-column align-items-start justify-content-start">
                        <div class="scoreBlock d-flex flex-row me-3">
                          <h5 class="score h-100">${film.score}/10 </h5>
                          <label class="h-100 labelMark rounded ms-2">IMDb</label>
                        </div>
                        <div class="scoreBlock d-flex flex-row mt-2">
                          <h5 class="score h-100">4.3/5</h5>
                          <label class="h-100 labelMark_user rounded ms-2">User score</label>
                        </div>
                      </div>
                      <div class="trailer rounded-pill d-flex flex-column align-items-start">
                        <div class="trailerImg w-100 d-flex position-relative">
                          <div class="overlay visually-hidden position-absolute w-100 h-100">
                            <iframe id="trailerVideo" class="w-100 h-100" src="https://www.youtube.com/embed/${film.trailer_key}" title="YouTube vide text-secondaryo Xem ngayer" frameborder="0" allow="accelerometer; au text-secondarytoXem ngay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                          </div>
                          <img src="${thumbnail}" alt="" class="thumbnail w-100 rounded">
                          <button class="btn position-absolute top-50 start-50 translate-middle trailerBtn rounded-pill">
                            <i class="fa-solid fa-play text-light"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
                `

        carousel.append(html);
        carousel.children(".carousel-item:first-child").addClass("active");

        $(".trailerBtn").click(function (e) {
          let trailer = $(".overlay")
          trailer.removeClass("visually-hidden")
          $(".trailerBtn").addClass("visually-hidden")
        })
        $(".btn-watch").click(function (e) {
          let id=$(e.target).attr("data-id")
          window.location.href = "/watch?id="+id
        })
        $(".btn-inf").click(function (e) {
          let id=$(e.target).attr("data-id")
          window.location.href = "/detail?id="+id
        })
      })
    }
  })


})

$(function () {

  $.get(`/`, { getNewestMovie: true }, function (data) {
    console.log(JSON.parse(data))
    data = JSON.parse(data)
    if (data.status) {
      let listFimls = $(".listFilm")
      data.data.forEach(function (film, index) {
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
                <h5 class="card-title linkToDetail" data-id="${film.id}">${film.title}</h5>
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
        listFimls.append(html)

      })
      $(".listNewest .watchLink").click(function (e) {
        console.log($(e.target).parents(".watchLink"))
        let id=$(e.target).parents(".watchLink").attr("data-id")
        window.location.href = "/watch?id="+id
      })
      $(".linkToDetail").click(function (e) {
        let id=$(e.target).attr("data-id")
        window.location.href = "/detail?id="+id
      })
    }
  })
})


//lấy dữ liệu các phim phổ biến
$(function () {

  $.get(`/`, { getPopularMovie: true }, function (data) {
    data = JSON.parse(data)
    if (data.status) {
      let listFimls = $(".listPopular")

      data.data.forEach(function (film, index) {

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
                <h5 class="card-title linkToDetail" data-id="${film.id}">${film.title}</h5>
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
        listFimls.append(html)

      })

      $(".listPopular .watchLink").click(function (e) {
        let id=$(e.target).parents(".watchLink").attr("data-id")
        window.location.href = "/watch?id="+id
      })
      $(".linkToDetail").click(function (e) {
        let id=$(e.target).attr("data-id")
        window.location.href = "/detail?id="+id
      })
    }
  })
})

//tạo mảng các thể loại người dùng chọn
let listGenres = []
let yearSelected = "none"
let sortType = "none"
let listGenresSelect = ""
let currentPage = 1

//lấy dữ liệu các thể loại, them cac hanh hong vao cac nut
$(function () {
  $(".sortTypeSelect").click(function (e) {
    sortType = $(e.target).attr("data-sort-type")
    $("#selectSortType").text($(e.target).text())
    currentPage = 1
    loadSortFilm(listGenresSelect, yearSelected, sortType, currentPage)
  })

  $(".yearSelect").click(function (e) {
    yearSelected = $(e.target).attr("data-year")
    $("#yearSelector").text($(e.target).text())
    currentPage = 1
    loadSortFilm(listGenresSelect, yearSelected, sortType, currentPage)
  })

  $.get(`/`, { getGenres: true }, function (data) {
    data = JSON.parse(data)
    if (data.status) {

      $(".badge").text(data.data.length)
      let listGenre = $(".listGenre")
      data.data.forEach(function (genre, index) {
        let name = genre.name
        let id = genre.id

        if (name.includes("Phim")) {
          name = name.substring(4)
        }

        let html = `
          <label for="genresSelect[]">
            <input type="checkbox" value="${id}" name="genresSelect[]" class="genresSelect">
            <div class="boxGenre rounded-pill d-flex justify-content-center align-items-center bg-secondary">
              <p class="nameGenre">${name}</p>
            </div>
          </label>
        `
        listGenre.append(html)
      })

      //bắt sự kiện click vào thể loại
      $(".genresSelect").click(filmSortLoader)
    }
  })

  loadSortFilm(listGenresSelect, yearSelected, sortType, currentPage)
})

function filmSortLoader(e = null) {
  let value = ""
  if (e) {
    value = e.target.value
  }

  //kiểm tra thể loại đó đã được chọn hay chưa
  if (!listGenres.includes(value)) {
    listGenres.push(value)
  } else {
    const index = listGenres.indexOf(value);
    if (index > -1) {
      listGenres.splice(index, 1);
    }
  }

  listGenresSelect = ""
  listGenres.forEach(function (genre, index) {
    if (index != listGenres.length)
      listGenresSelect += genre + "-"
    else
      listGenresSelect += genre
  })

  currentPage = 1
  loadSortFilm(listGenresSelect, yearSelected, sortType, currentPage)
}


function loadSortFilm(listGenresSelect, yearSelected, sortType, pageNumber) {
  $.get("/", { getSortMovies: true, listGenresSelect, yearSelected, sortType, pageNumber }, function (data) {
    dataMovie = JSON.parse(data)

    let filmSort = $(".filmSort")
    filmSort.html("")
    dataMovie.data.forEach(function (film, index) {

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
          <h5 class="card-title linkToDetail " data-id="${film.id}">${film.title}</h5>
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

      filmSort.append(html)
    })
    $(".linkToDetail").click(function (e) {
      let id=$(e.target).attr("data-id")
      window.location.href = "/detail?id="+id
    })
    $(".watchLink").click(function (e) {
      let id=$(e.target).parent(".watchLink").attr("data-id")
      console.log(id)
      window.location.href = "/watch?id="+id
    })

    generalPagination(dataMovie.totalPage, pageNumber)
  })
}

function generalPagination(numPage, currentPage) {
  let pageLinks = document.querySelectorAll(".page-link")
  if (numPage >= 5) {
    if (currentPage <= numPage / 2) {

      pageLinks.forEach(function (pageLink, index) {
        $(pageLink).parent().removeClass("hidden")
        switch (index) {

          case 0: {
            if (currentPage > 1) {
              $(pageLink).attr("data-func", "prev").parent()
                .removeClass("disabled")
            } else {
              $(pageLink).attr("data-func", "none").parent()
                .addClass("disabled")
            }
            break
          }

          case 1: {
            if (currentPage == 1) {
              $(pageLink).text(currentPage)
                .attr("data-func", currentPage)
                .parent()
                .addClass("active")
            } else {
              $(pageLink).text(currentPage - 1)
                .attr("data-func", currentPage - 1)
                .parent()
                .removeClass("active")
            }
            break
          }

          case 2: {
            if (currentPage == 1) {
              $(pageLink).parent()
                .removeClass("disabled")
              $(pageLink).text(currentPage + 1)
                .attr("data-func", currentPage + 1)
                .parent()
                .removeClass("active")
            } else {
              $(pageLink).parent()
                .addClass("active")
              $(pageLink).text(currentPage)
                .attr("data-func", currentPage)
            }
            break
          }

          case 3: {
            if (currentPage == 1) {
              $(pageLink).text(currentPage + 2)
                .attr("data-func", currentPage + 2)
            } else {
              $(pageLink).text(currentPage + 1)
                .attr("data-func", currentPage + 1)
            }
            break
          }

          case 4: {
            $(pageLink).text("...")
              .attr("data-func", "none")
              .parent()
              .addClass("disabled")
            break
          }

          case 5: {
            $(pageLink).text(numPage)
              .attr("data-func", numPage)
              .parent()
              .removeClass("active")
            break
          }

          case 6: {
            $(pageLink)
              .attr("data-func", "next")
              .parent()
              .removeClass("disabled")
            break
          }

          default: {

          }
        }
      })
    } else {
      pageLinks.forEach(function (pageLink, index) {
        switch (index) {

          case 6: {
            if (currentPage == numPage) {
              $(pageLink)
                .attr("data-func", "none")
                .parent()
                .addClass("disabled")
            } else {
              $(pageLink).attr("data-func", "next")
                .parent()
                .removeClass("disabled")
            }
            break
          }

          case 5: {
            if (currentPage == numPage) {
              $(pageLink).text(currentPage)
                .attr("data-func", currentPage)
                .parent()
                .addClass("active")
            } else {
              $(pageLink).text(currentPage + 1)
                .attr("data-func", currentPage + 1)
                .parent()
                .removeClass("active")
            }
            break
          }

          case 4: {
            if (currentPage == numPage) {
              $(pageLink).parent().removeClass("disabled")
              $(pageLink).text(currentPage - 1)
                .attr("data-func", currentPage - 1)
                .parent()
                .removeClass("active")
            } else {
              $(pageLink).text(currentPage)
                .attr("data-func", currentPage)
                .parent()
                .addClass("active")
            }
            break
          }

          case 3: {
            if (currentPage == numPage) {
              $(pageLink).text(currentPage - 2)
                .attr("data-func", currentPage - 2)
            } else {
              $(pageLink).text(currentPage - 1)
                .attr("data-func", currentPage - 1)
            }
            break
          }

          case 2: {
            $(pageLink).text("...")
              .attr("data-func", "none")
              .parent()
              .addClass("disabled")
            break
          }

          case 1: {
            $(pageLink).text("1")
              .attr("data-func", 1)
              .parent()
              .removeClass("active")
            break
          }

          case 0: {
            $(pageLink)
              .attr("data-func", "prev")
              .parent()
              .removeClass("disabled")
            break
          }

          default: {

          }
        }
      })
    }
  } else {
    pageLinks.forEach(function (pageLink, index) {
      $(pageLink).parent().removeClass("hidden")
      switch (index) {
        case 0: {
          if (currentPage > 1) {
            $(pageLink).attr("data-func", "prev").parent()
              .removeClass("disabled")
          } else {
            $(pageLink).attr("data-func", "none").parent()
              .addClass("disabled")
          }
          break
        }

        case 6: {
          if (currentPage < numPage) {
            $(pageLink).attr("data-func", "next").parent()
              .removeClass("disabled")
          } else {
            $(pageLink).attr("data-func", "none").parent()
              .addClass("disabled")
          }
          break
        }

        default: {
          $(pageLink).parent().removeClass("disabled")
          if (index > numPage) $(pageLink).parent().addClass("hidden")
          else {
            if (index == currentPage) {
              $(pageLink).text(index)
                .attr("data-func", "none")
                .parent()
                .addClass("active")
            } else {
              $(pageLink).text(index)
                .attr("data-func", index)
                .parent()
                .removeClass("active")
            }
          }
        }
      }
    })
  }
}

//Thêm sự kiện click vào thanh chọn trang
$(function () {
  $(".page-link").click(function (e) {
    let action = $(e.target).attr("data-func")

    if (action == undefined) {
      action = $(e.target).parent().attr("data-func")
    }

    if (action == "next") {
      currentPage = parseInt(currentPage) + 1
    }
    else if (action == "prev") {
      currentPage = parseInt(currentPage) - 1
    }
    else {
      currentPage = action
    }

    loadSortFilm(listGenresSelect, yearSelected, sortType, parseInt(currentPage))
  })
  
})

//lấy dữ liệu các phim recommend
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
          <h5 class="card-title linkToDetail" data-id="${film.id}">${film.title}</h5>
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
    $(".linkToDetail").click(function (e) {
      let id=$(e.target).attr("data-id")
      window.location.href = "/detail?id="+id
    })
    $(".watchLink").click(function (e) {
      let id=$(e.target).parent(".watchLink").attr("data-id")
      console.log(id)
      window.location.href = "/watch?id="+id
    })
  })
})

