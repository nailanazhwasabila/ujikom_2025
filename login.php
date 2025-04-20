<?php 
 session_start();
if(isset($_SESSION["login"])){
  header("Location: index.php");
    exit;

}


  require 'functions.php';

  if(isset($_POST["login"])){
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
  //cek username
  if(mysqli_num_rows($result) === 1){
    //cek password
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])){
      $_SESSION["login"] = true;
      header("Location: index.php");
      exit;
    }
  }
  $error=true; 
}

 ?>


<!doctype html>
<html lang="">
  <head>
   <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Login</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="assets/css/demo.css" />
  <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
  <script src="assets/vendor/js/helpers.js"></script>
  <script src="assets/js/config.js"></script>
  </head>

 <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-text demo text-body fw-bolder">SPIKE LOGIN</span>
              </a>
            </div>
            <!-- /Logo -->
            <form method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="username" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
             
                 <a class="small text-muted" href="#!">Dapatkan kata sandi?</a>
                  <p class="mb-1 " style="color: #393f81;">Tidak Memiliki Akun? <a href="registrasi.php"
                      style="color: #393f81;">Register here</a></p>
              </div>
              <div class="mb-3  ">
                <button class="btn btn-primary d-grid w-100" type="submit" name="login">Sign in</button>
                 <center> <a href="#!" class="small text-muted">Terms of use</a>
                  <a href="#!" class="small text-muted" >Privacy policy</a></center>
            </form>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="js/bootstrap.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script type="text/javascript" src="admin.js"></script>
   
   
  </body>
</html>