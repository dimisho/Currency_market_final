<?php
    session_start();
    if (!isset($_SESSION["is-login"])){
        header("location: /login.php");
    }
    if (isset($_SESSION['start']))
    {
        $now = time();
        $time_limit = 1800;
        if ($now > $_SESSION['start'] +  $time_limit  )
        {
            $_SESSION = array();
            session_destroy();
        }
        else {    $_SESSION['start'] = time();    }
    }
?>
<?php
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
      /* p{
        text-align:left;
      } */
      .NameAndEmail{

      }
      .Name{

        display:flex;
        flex-direction: row;
        align-items: center;

      }
      .Email{
        display:flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
      }
    </style>
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
        <?php if (!isset($_SESSION["is-login"])){
        echo '<li class="nav-item"><a href="login.php" class="nav-link" aria-current="page">Login</a></li>
        <li class="nav-item"><a href="signup.php" class="nav-link" aria-current="page">Sign Up</a></li>';
        }
        if (isset($_SESSION["is-login"])){
         $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");
           while($acc = $list->fetch(PDO::FETCH_ASSOC)) {
                  if ($acc['status'] == 'admin')
                  {
                    echo '<li class="nav-item"><a href="admin.php" class="nav-link" aria-page="page">Administrator</a></li>';
                  }
                  echo '<li class="nav-item"><a href="account.php" class="nav-link active" aria-page="page">Account</a></li>';
                  echo '<li class="nav-item"><a href="stocks.php" class="nav-link" aria-page="page">Stocks</a></li>';
                  echo '<li class="nav-item"><a href="includes/logout.inc.php" class="nav-link" aria-page="page">Log Out</a></li>';
                }
              }
         ?>
      </ul>
    </header>
  </div>
       <main class="form-signin" style="margin: 50px;">
         <div class="justify">
       <form action="app/add.php" method="post" style="max-width: 500px;
      margin-left: auto;
      margin-right: auto;">
      <h1><span style="color: #056efd; font-size: 2em">P</span>ersonal <span style="color: #056efd; font-size: 2em">A</span>ccount</h1>
      <?php $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");?>
         <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
       <h1 class="h3 mb-3 fw-normal">Your Balance: <?php echo $acc['account']; ?> rub.</h1>
       <div class="form-floating" style="margin: 10px">
         <input type="sum" class="form-control" class="<?php if($is_invalid) echo 'is-invalid"'; $_SESSION["is-invalid"] = false; ?>"
         <?php if ($acc['status'] == 'only read'){ echo 'disabled=true'; } ?> name = "sum" placeholder="balance">
         <label for="floatingPassword">Top up your balance</label>
       </div>
       <button <?php if ($acc['status'] == 'only read'){ echo 'disabled=true'; } ?> class="w-100 btn btn-lg btn-primary" type="submit">Top Up</button>
       <p style="color: red;"><?php if ($acc['status'] == 'only read'){ echo 'Only read'; } ?> </p>
       <?php } ?>
     </form>
   </div>
   </main>
   <main class="form-signin" style="margin: 50px;">
     <div class="justify">
   <form action="app/change_name.php" method="post" style="max-width: 500px;
  margin-left: auto;
  margin-right: auto;">
  <?php $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");?>
    <div class="NameAndEmail">
    <div class="Name">
    <?php while($name = $list->fetch(PDO::FETCH_ASSOC)) { ?>
   <p style="font-size: 20px" class="h3 mb-3 fw-normal">Name: <?php echo $name['name'] ?></p>
    <input style="margin: 20px" <?php if ($name['status'] == 'only read'){ echo 'disabled=true'; } ?> type="newname" class="form-control" name = "newname" placeholder="New Name">
    <button <?php if ($name['status'] == 'only read'){ echo 'disabled=true'; } ?> class="w-20 btn  btn-secondary" type="submit">Change</button>
        <?php } ?>
    </div>
</div>
 </form>
</div>
</main>
<main class="form-signin" style="margin: 50px;">
  <div class="justify">
<form action="app/change_email.php" method="post" style="max-width: 500px;
margin-left: auto;
margin-right: auto;">
<?php $list2 = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");?>
 <div class="NameAndEmail">
 <div class="Email">
 <?php while($email = $list2->fetch(PDO::FETCH_ASSOC)) { ?>
<p style="font-size: 20px" class="h3 mb-3 fw-normal">Email: <?php echo $email['email'] ?></p>
 <input style="margin: 20px" <?php if ($email['status'] == 'only read'){ echo 'disabled=true'; } ?> type="email" class="form-control"  id="floatingInput" name = "newemail" placeholder="New Email">
 <button <?php if ($email['status'] == 'only read'){ echo 'disabled=true'; } ?> class="w-20 btn  btn-secondary" type="submit">Change</button>
     <?php } ?>
 </div>
</div>
</form>
</div>
</main>
</body>
</html>
