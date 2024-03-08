<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/views/SignUp/style2.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <title>Moonvie</title>
</head>

<body>
  <div class="background-image">
    <div class="dark-overlay"></div>
    <div class="green-overlay">
      <div class="blur-background d-flex justify-content-center align-items-center h-100">
        <form>
          <h1>đăng <span style="color:black">ký</span></h1>
          <hr class="line">
          <div class="fullhalf">
            <div class="half1 boxField">
              <div class="name">Họ</div>
              <div class="inputusername">
                <input type="text" autocomplete="off" name="lastName" class="input">
              </div>
              <div class="boxWarning text-danger">
                <p></p>
              </div>
            </div>
            <div class="half2 ms-3 boxField">
              <div class="name">Tên</div>
              <div class="inputfirstname">
                <input type="text" autocomplete="off" name="firstName" class="input">
              </div>
              <div class="boxWarning text-danger">
                <p></p>
              </div>
            </div>
          </div>
          <div class="fullpage mt-2">
            <div class="username boxField">
              <div class="name">Tên tài khoản</div>
              <div class="inputemail">
                <input type="text" autocomplete="off" name="username" class="input">
              </div>
              <div class="boxWarning text-danger">
                <p></p>
              </div>
            </div>
            <div class="username boxField">
              <div class="name">Email</div>
              <div class="inputemail">
                <input type="text" autocomplete="off" name="email" class="input">
              </div>
              <div class="boxWarning text-danger">
                <p></p>
              </div>
            </div>
            <div class="password mt-2 boxField">
              <div class="name">Mật khẩu</div>
              <div class="inputpassword">
                <input type="password" autocomplete="off" name="password" class="input">
              </div>
              <div class="boxWarning text-danger">
                <p></p>
              </div>
            </div>
            <div class="confirm mt-2 boxField">
              <div class="name">Xác nhận mật khẩu</div>
              <div class="confirm-pass">
                <input type="password" autocomplete="off" name="passwordVerify" class="input">
              </div>
              <div class="boxWarning text-danger">
                <p></p>
              </div>
            </div>
            <div class="agreeRule d-flex justify-content-center mt-1">
              <div class="checkbox-wrapper-31 d-flex">
                <input type="checkbox" name="agree">
                <svg class="" viewBox="0 0 35.6 35.6">
                  <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                  <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                  <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                </svg>
              </div>
              <div class="remember ms-2">Tôi đồng ý với các điều khoản & điều kiện</div>
            </div>
          </div>
          <div class="btnLine w-100 d-flex justify-content-center">
            <button class="mt-3" id="submit">
              Đăng ký
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
  <script src="/views/SignUp/index.js"></script>
</body>

</html>