<link rel="stylesheet" href="/views/UserDetail/index.css">
<script src=" https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js "></script>
<link href=" https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css " rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<main>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thay đổi mật khẩu</h5>
          <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="oldPass" class="col-form-label">Nhập mật khẩu cũ <p class="text-warning"></p></label>
              <input type="password" class="form-control" id="oldPass">
            </div>
            <div class="mb-3">
              <label for="newPass" class="col-form-label">Mật khẩu mới <p class="text-warning"></p></label>
              <input type="password" class="form-control" id="newPass">
            </div>
            <div class="mb-3">
              <label for="newPassc" class="col-form-label">Xác nhận mật Khẩu mới <p class="text-warning"></p></label>
              <input type="password" class="form-control" id="newPassc">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn rounded-pill btn-change-pass btn-primary">Lưu</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container px-5">
    <div class="row d-flex justify-content-between">
      <div class="col-lg-3 ">
        <div class="tab">
          <a href="#" class="tablinks rounded" onclick="openEvent(event,'Profile')" id="defaultOpen"><i class="fa-regular fa-user"></i> &ensp; Cài đặt thông tin</a>
          <a href="#" class="tablinks mt-2 rounded" onclick="openEvent(event,'Lan&cur')"><i class="fa-solid fa-globe"></i> &ensp; Ngôn ngữ và tiền tệ</a>
          <a href="#" class="tablinks mt-2 rounded" onclick="openEvent(event,'Movie_set')"><i class="fa-solid fa-film"></i> &ensp; Cài đặt phim</a>
          <a href="#" class="tablinks mt-2 rounded" onclick="openEvent(event,'fb_acc')"><i class="fa-brands fa-facebook"></i> &ensp; Tài khoản Facebook</a>
          <a href="#" class="tablinks mt-2 rounded" onclick="openEvent(event,'tw_acc')"><i class="fa-brands fa-square-twitter"></i> &ensp; Tài khoản Twitter</a>
        </div>
      </div>
      <div class="card col-lg-8">
        <div id="Profile" class="tabcontent">
          <div class="card-header d-flex flex-row justify-content-start alight-items-center">
            <img class="avatar-profile" src="assets/img/Layer_1-2.png" alt="Gamer" width="30%" height="30%">
            <div class="inforRight d-flex flex-column justify-content-between py-2">
              <div>
                <p class="name"></p>
                <p class="username"></p>
              </div>
              <button class="editProfile btn color-button rounded-pill">Chỉnh sửa</button>
            </div>
          </div>

          <div class="card-body">
            <form class="d-flex flex-wrap justify-content-between">
              <div class="form-group me-3">
                <label for="firstName">Tên</label>
                <input type="text" class="rounded" disabled id="firstName">
              </div>
              <div class="form-group">
                <label for="lastName">Họ</label>
                <input type="text" class="rounded" disabled id="lastName">
              </div>
              <div class="form-group">
                <label for="Birth">Ngày sinh</label>
                <input type="date" class="rounded" disabled id="birth">
              </div>
              <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input type="email" class="rounded" disabled id="email">
              </div>
              <div class="form-group">
                <label for="phoneNumber">Số điện thoại</label>
                <input type="text" class="rounded" disabled id="phoneNumber">
              </div>
            </form>
            <button type="submit" class="btn color-button disabled rounded-pill">Lưu thay đổi</button>
            <button class="btn btn-ch-pass color-button rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal">Đổi mật khẩu</button>
          </div>
        </div>

        <div id="Lan&cur" class="tabcontent card-header">
          <label for="language-select">Chọn ngôn ngữ </label>
          <select id="language-select">
            <option value="en">Tiếng Anh</option>
            <option value="fr">Tiếng Pháp</option>
            <option value="es">Tiếng Tây Ban Nha</option>
          </select>
          &emsp;
          <i class="fa fa-language" aria-hidden="true"></i>
          <script>
            const languageSelect = document.getElementById("language-select");
            languageSelect.addEventListener("change", function() {
              const selectedLanguage = languageSelect.value;
              document.documentElement.lang = selectedLanguage;
            });
          </script>


          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <h4>Change your currency:</h4>
                <form id="currency-converter-form">
                  <div class="input-group mb-3">
                    <input type="number" class="form-control" placeholder="Amount" id="amount-input">
                    <select class="form-select" id="currency-from">
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="JPY">JPY</option>
                    </select>
                  </div>
                  <div class="input-group mb-3">
                    <select class="form-select" id="currency-to">
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="JPY">JPY</option>
                    </select>
                    <button class="btn btn-primary" type="button" id="convert-btn">Convert</button>
                  </div>
                </form>
              </div>
              <div class="col-lg-6">

                <div id="result-container">
                  <!-- Converted amount will be displayed here -->
                </div>
              </div>
            </div>
            <script>
              // Define exchange rate for each currency
              const exchangeRates = {
                USD: {
                  EUR: 0.84,
                  JPY: 110.59,
                },
                EUR: {
                  USD: 1.19,
                  JPY: 130.84,
                },
                JPY: {
                  USD: 0.009,
                  EUR: 0.008,
                },
              };

              // Define function to convert currency
              function convertCurrency(amount, currencyFrom, currencyTo) {
                const rate = exchangeRates[currencyFrom][currencyTo];
                const convertedAmount = amount * rate;
                return convertedAmount.toFixed(2);
              }

              // Define event listener for convert button
              const convertBtn = document.getElementById("convert-btn");

              convertBtn.addEventListener("click", function() {
                const amountInput = document.getElementById("amount-input");
                const currencyFrom = document.getElementById("currency-from").value;
                const currencyTo = document.getElementById("currency-to").value;
                const resultContainer = document.getElementById("result-container");

                // Check if amount input is valid
                if (!amountInput.checkValidity()) {
                  alert("Please enter a valid amount.");
                  return;
                }

                // Convert currency and display result
                const amount = amountInput.value;
                const convertedAmount = convertCurrency(amount, currencyFrom, currencyTo);
                resultContainer.innerHTML = `${amount} ${currencyFrom} = ${convertedAmount} ${currencyTo}`;
              });
            </script>
          </div>
        </div>
        <div id="Movie_set" class="tabcontent card-header">
          <div class="container">
            <h2>Phim Settings</h2>
            <form action="" method="post">
              <div class="form-group w-100">
                <label for="resolution" class="color_text">Độ phân giải:</label>
                <select class="form-control" id="resolution" name="resolution">
                  <option value="360p">360p</option>
                  <option value="480p">480p</option>
                  <option value="720p">720p</option>
                  <option value="1080p">1080p</option>
                </select>
              </div>
              <div class="form-group w-100">
                <label for="subtitles" class="color_text">Phụ đề:</label>
                <select class="form-control" id="subtitles" name="subtitles">
                  <option value="on" class="color_text">Bật</option>
                  <option value="off" class="color_text">Tắt</option>
                </select>
              </div>
              <div class="form-group w-100">
                <label for="playback-speed" class="color_text">Tốc độ phát:</label>
                <select class="form-control" id="playback-speed" name="playback-speed">
                  <option value="1.0">1.0</option>
                  <option value="1.25">1.25</option>
                  <option value="1.5">1.5</option>
                  <option value="2.0">2.0</option>
                </select>
              </div>
              <div class="form-group w-100">
                <label for="volume" class="color_text">Âm lượng tổng:</label>
                <input type="range" class="form-control-range" id="volume" name="volume" min="0" max="100">
              </div>
              <div class="form-group w-100">
                <label for="mode" class="color_text">Chế độ phim:</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="mode" id="normal-mode" value="normal-mode" checked>
                  <label class="form-check-label color_text" for="normal-mode">
                    Bình thường
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="mode" id="theater-mode" value="theater-mode">
                  <label class="form-check-label color_text" for="theater-mode">
                    Rạp chiếu phim
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
          </div>
        </div>

        <div id="fb_acc" class="tabcontent card-header">
          <h2>Tài Khoản Facebook</h2>
          <a href="#" class="fb btn">
            <i class="fa fa-facebook fa-fw"></i> Liên kết với tài khoản Facebook</a>
        </div>
        <div id="tw_acc" class="tabcontent card-header">
          <h2>Tài khoản Twitter</h2>
          <a href="#" class="twitter btn">
            <i class="fa-brands fa-twitter"></i> Liên kết với tài khoản twitter</a>
        </div>
      </div>
    </div>
  </div>
  <script>
    function openEvent(evt, evtName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(evtName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </script>
  <script src="/views/UserDetail/index.js"></script>
</main>