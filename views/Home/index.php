<link rel="stylesheet" href="/views/Home/index.css">
<!-- carousel  -->

<div id="carouselCaptions" class="slide carousel slideMain">
  <div class="carousel-inner">

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</div>

<div class="container">
  <div class="row mt-5">
    <h3 class="row px-4 text-light">
      Phim Lẻ Mới
    </h3>
    <div class="carousel row listFilm listNewest">

    </div>
  </div>
  <div class="row mt-5">
    <h3 class="row px-4 text-light">
      Phim lẻ phổ biến
    </h3>
    <div class="carousel row listFilm listPopular">

    </div>
  </div>
</div>
<div class="mt-5 container-fluid listFilmSort">
  <div class="container pt-5 pb-3 ">
    <form action="/aa" method="post">
      <h3 class="titleGenre text-light">Chọn Thể Loại <span class="badge bg-secondary rounded-pill"></span></h3>
      <div class="listGenre row d-flex flex-row flex-nowrap pb-5 mt-4">

      </div>
    </form>
    <h3 class="titleGenre text-light mt-3">Sắp xếp</h3>
    <div class="sortGroup d-flex flex-row mt-4">
      <div class="dropdown me-4">
        <a id="yearSelector" class="btn btn-secondary dropdown-toggle rounded-pill" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          Năm
        </a>
        <ul class="dropdown-menu" id="selectYear" aria-labelledby="dropdownMenuLink">
          <li><a class='dropdown-item yearSelect' data-year="none">Không chọn</a></li>
          <?php
          for ($i = date("Y"); $i >=  1990; $i--) {
            echo "<li><a class='dropdown-item yearSelect' data-year='$i'>$i</a></li>";
          }
          ?>
        </ul>
      </div>
      <div class="dropdown me-4">
        <a id="selectSortType" class="btn btn-secondary dropdown-toggle rounded-pill" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          None
        </a>
        <ul class="dropdown-menu sortSelect" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item sortTypeSelect" data-sort-type="asc">A - Z</a></li>
          <li><a class="dropdown-item sortTypeSelect" data-sort-type="desc">Z - A</a></li>
          <li><a class="dropdown-item sortTypeSelect" data-sort-type="none">None</a></li>
        </ul>
      </div>
    </div>
    <div class="row filmSort my-5">

    </div>
    <nav aria-label="..." class="pagination-container">
      <ul class="pagination rounded-pill justify-content-center text-light">
        <li class="page-item">
          <span data-page="prev" class="page-link stepButton bg-dark"><i class="fa-solid fa-angle-right fa-rotate-180"></i></i></span>
        </li>
        <li class="page-item "><a class="page-link bg-dark" >1</a></li>
        <li class="page-item active">
          <a class="page-link bg-dark">2</a>
        </li>
        <li class="page-item "><a class="page-link bg-dark" >3</a></li>
        <li class="page-item"><a class="page-link bg-dark" >...</a></li>
        <li class="page-item "><a class="page-link bg-dark" >99</a></li>
        <li class="page-item">
          <a data-func="next" class="page-link stepButton bg-dark" ><i class="fa-solid fa-angle-right"></i></a>
        </li>
      </ul>
    </nav>
  </div>
</div>
</div>
<div class="container py-5">
  <h3 class="titleGenre text-light">Phim đề xuất</h3>
  <div class="row mt-5 recommendFilmsContainer">
    
  </div>
</div>
<script src="/views/Home/index.js"></script>