<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/views/SignUp/style2.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
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
        <form action="/login">
          <h3 class="title-Notic text-light">Đăng kí thành công <i class="fa-sharp fa-solid fa-circle-check text-success"></i></h3>
          <h5 class="title-Notic text-light loginDirect rounded-pill mt-3"><i class="fa-solid fa-arrow-left text-success me-2"></i>Quay về đăng nhập</h3>
        </form>
      </div>

    </div>
  </div>
  <script src="/views/SignUp/index.js"></script>
  <script>
    $(function(){
      $(".loginDirect").click(function(){
        $("form").submit()
      })
    })
  </script>
</body>

</html>