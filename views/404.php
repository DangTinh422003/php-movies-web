<?php
   header("HTTP/1.0 404 Not Found");
?>

<!DOCTYPE html>
<html>
<head>
   <title>Error 404</title>
   <style>
      body {
         background-image: url('assets/img/404.png');
         background-size: cover;
      }
      .container {
      position: absolute;
      top: 50%;
      left: 25%;
      transform: translate(-50%, -50%);
      width: 40%;
      max-width: 550px;
      height: auto;
      padding: 40px;
      border-radius: 60px;
      background-color: rgba(250,250,250,0.2);
      text-align: center;
   }
   button {
      background-color: #00CC21;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 1vw;
      cursor: pointer;
      margin: 0;
      padding: 0.5vw 1vw;
   }
   button:hover {
      background-color: #555;
   }
   h1 {
      font-size: 5vw;
      margin: 0;
      color: white;
      font-family: bold;
   }
   h2 {
      font-size: 2.5vw;
      margin: 0;
      color: #00CC21;
      font-family: sans-serif;
   }
   p {
      font-size: 1vw;
      margin: 0;
      color: #fff;
   }
   </style>
</head>
<body>
   <div class="container">
      <h1>OOPS!!!</h1>
      <h2>404 NOT FOUND</h2>
      <br><br><br>
      <p>sorry, we can't find the page that </p>
      <p>you are looking for</p>
      <br><br>
      <button onclick="goBack()">Go Back</button>
   </div>
   <script>
      function goBack() {
         window.history.back();
      }
   </script>
</body>
</html>
