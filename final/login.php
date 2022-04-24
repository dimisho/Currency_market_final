<?php session_start();
if (isset($_SESSION["is-invalid"])){
    $is_invalid = $_SESSION["is-invalid"];
}else{
    $is_invalid = false;
}
?>
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body class="text-center">
    <div class="container">
      <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
          <img src="img/logo.jpg" width="40" height="32" style="margin-right: 10px">
          <span class="fs-4">TripleD Market</span>
        </a>
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">Home</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link active" aria-current="page">Login</a></li>
          <li class="nav-item"><a href="signup.php" class="nav-link" aria-current="page">Sign Up</a></li>
        </ul>
      </header>
    </div>
    <main class="form-signin">
      <div class="justify">
    <form action="includes/login.inc.php" method="post" style="max-width: 500px;
   margin-left: auto;
   margin-right: auto;">
    <h1 class="h3 mb-3 fw-normal">Login</h1>
    <?php
        if (isset($_GET['error'])) {
            require_once "includes/function.inc.php";
            error_handler($_GET['error']);
        }
    ?>
    <div class="form-floating" style="margin: 10px">
      <input type="email" name="user_email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating" style="margin: 10px">
      <input type="password" class="form-control" class="<?php if($is_invalid) echo 'is-invalid"'; $_SESSION["is-invalid"] = false; ?>" name = "user_pass" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Log in</button>
  </form>
</div>
</main>
  <?php $_SESSION["is-invalid"]?>
</body>
</html>
