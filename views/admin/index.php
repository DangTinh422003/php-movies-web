<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/views/admin/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/views/admin/index.js"></script>
    <title>Admin</title>
</head>

<body>
    <div class="container-fluid g-0 h-100 d-flex">
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-light h-100" style="width: 280px;">
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <span class="fs-4">Chào mừng trở lại! Admin</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" data-action="movies" class="nav-link link-dark active">
                        Phim
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-action="genres" class="nav-link link-dark">
                        Thể loại phim
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-action="users" class="nav-link link-dark" aria-current="page">
                        Người dùng
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-action="comments" class="nav-link link-dark">
                        Bình luận
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" class="rounded-circle me-2" width="32" height="32">
                    <strong>admin</strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
        <div class="mainPage w-100 h-100 p-5">
            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xóa phim</h5>
                            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn xóa
                            <p class="subMessage"></p>
                            <p class="idMessage"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" id="deleteBtn" data-id="" data-delete-type="" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="toast hide align-items-center text-white position-fixed mb-3 bg-success showing border-0 bottom-0 start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body w-100">
                        <p class="w-100 message text-center m-0">
                            Đã xóa dữ liệu
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="moviesPage subPage show">
                <h1>Tổng quan</h1>
                <div class="overview d-flex rounded my-3 p-4">
                    <div class="overview-box d-flex justify-content-center align-items-center me-5">
                        <div class="icon">
                            <i class="fa-solid fa-film-simple"></i>
                        </div>
                        <div class="text totalSingleFilm d-flex flex-column align-items-center">
                            <h2>loading...</h2>
                            <span>Tổng số phim lẻ</span>
                        </div>
                    </div>
                    <div class="overview-box d-flex justify-content-center align-items-center me-5">
                        <div class="icon">
                            <i class="fa-solid fa-film-simple"></i>
                        </div>
                        <div class="text d-flex flex-column align-items-center">
                            <h2>0</h2>
                            <span>Tổng số phim bộ</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="title-1 m-b-25">Danh sách phim </h2>
                        <div class="group my-3">
                            <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                                <g>
                                    <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                                </g>
                            </svg>
                            <input placeholder="Tìm kiếm phim" type="search" class="inputSearch">
                        </div>
                        <div class="table-responsive rounded table--no-card mt-3">
                            <table class="table">
                                <thead class="bg-dark text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Tựa đề</th>
                                        <th>Thời lượng</th>
                                        <th>Ngày chiếu</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">

                                    <tr class="btn-more">
                                        <td colspan="6">loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="genresPage hidden subPage">
                <h1>Quản lí thể loại</h1>
            </div>
            <!-- trang chi tiết phim -->
            <div class="detailPage hidden subPage">
                <div class="contain bg-light rounded p-5">
                    <div class="w-100 h4 text-primary">
                        <i class="backBtn fa-solid fa-arrow-left"></i>
                    </div>
                    <div class="row mt-4">
                        <div class="poster me-3 rounded col-lg-2 g-0">
                            <img class="rounded" src="" alt="">
                        </div>
                        <div class="col-lg-9">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Tên phim</h6>
                                        </div>
                                        <div id="name-field" class="col-sm-9 text-secondary">
                                            Kenneth Valdez
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">overview</h6>
                                        </div>
                                        <div id="overview-field" class="col-sm-9 text-secondary">
                                            fip@jukmuh.al
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">tagline</h6>
                                        </div>
                                        <div id="tagline-field" class="col-sm-9 text-secondary">
                                            (239) 816-9029
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Ngày khởi chiếu</h6>
                                        </div>
                                        <div id="release_date" class="col-sm-9 text-secondary">
                                            (320) 380-4539
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Quốc gia</h6>
                                        </div>
                                        <div id="country-field" class="col-sm-9 text-secondary">
                                            Bay Area, San Francisco, CA
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Thời lượng</h6>
                                        </div>
                                        <div id="duration-field" class="col-sm-9 text-secondary">
                                            Bay Area, San Francisco, CA
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Thể loại</h6>
                                        </div>
                                        <div id="genres-field" class="col-sm-9 text-secondary">
                                            <span class="badge bg-secondary">Hành động</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" id="editBtn" class="btn btn-info">Chỉnh sửa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Tên phim</label>
                                        <input type="text" class="form-control" id="recipient-name" name="title">
                                    </div>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Overview</label>
                                        <input type="text" class="form-control" id="recipient-name" name="overview">
                                    </div>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Tagline</label>
                                        <input type="text" class="form-control" id="recipient-name" name="tagline">
                                    </div>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Ngày khởi chiếu</label>
                                        <input type="text" class="form-control" id="recipient-name" name="release_date">
                                    </div>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Quốc gia</label>
                                        <input type="text" class="form-control" id="recipient-name" name="country">
                                    </div>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Thời lượng</label>
                                        <input type="text" class="form-control" id="recipient-name" name="duration">
                                    </div>
                                    <div class="">
                                        <label for="recipient-name" class="col-form-label">Thể loại</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="usersPage hidden subPage">
                    <h1>Quản lí người dùng</h1>
                </div>
                <div class="commentsPage hidden subPage">
                    <h1>Quản lí bình luận</h1>
                </div>
            </div>
        </div>

</body>

</html>