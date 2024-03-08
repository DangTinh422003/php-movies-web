<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/views/SignIn/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="/views/SignIn/index.js"></script>
  <title>Moonvie</title>
</head>

<body>
  <div class="background-image">
    <div class="dark-overlay"></div>
    <div class="green-overlay d-flex justify-content-center">

      <form>
        <h1>đăng <span style="color:black">nhập</span><br/></h1>
        <hr class="line">
        <div class="warningBox text-warning"></div>
        <div class="name label-input">Username</div>
        <div class="inputusername txt_field">
          <input type="text" autocomplete="off" id="username" name="text" class="input">
        </div>
        <div class="pass label-input">Password</div>
        <div class="inputpassword txt_field">
          <input type="password" autocomplete="off" name="text" id="password" class="input">
        </div>
        <button class="nut" id="submit" >
          Đăng nhập
        </button>
        <div class="d-flex justify-content-between px-5 py-5">
          <div class="d-flex">
            <div class="checkbox-wrapper-31 d-flex align-items-center me-2">
              <input type="checkbox">
              <svg viewBox="0 0 35.6 35.6">
                <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
              </svg>
            </div>
            <div class="remember">Ghi nhớ tôi</div> 
          </div>
          <div class="help">
            <a href="/forgotPass">cần trợ giúp ?</a>
          </div>
        </div>
        <div class="sign-up px-5 text-light">
          Bạn chưa có tài khoản?
          <a href="/register">đăng kí ngay</a>
        </div>
        <hr class="line2 ">
      </form>
    </div>

  </div>
  </div>
</body>

</html>