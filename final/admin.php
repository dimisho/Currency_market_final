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
    <title>Administrator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
      p{
        text-align:left;
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
                    echo '<li class="nav-item"><a href="admin.php" class="nav-link active" aria-page="page">Administrator</a></li>';
                  }
                  echo '<li class="nav-item"><a href="account.php" class="nav-link" aria-page="page">Account</a></li>';
                  echo '<li class="nav-item"><a href="stocks.php" class="nav-link" aria-page="page">Stocks</a></li>';
                  echo '<li class="nav-item"><a href="includes/logout.inc.php" class="nav-link" aria-page="page">Log Out</a></li>';
                }
              }
         ?>
      </ul>
    </header>
  </div>
      <h1>Administrator</h1>
      <div style="display: flex; flex-direction: row; margin-bottom: 20px; position: absolute; right: 0;">
        <input class="btn btn-lg btn-warning" type="submit" name="add" value="Add a user" onClick="window.location='adduser.php'" style="margin-right: 30px;"/>
      </div>
      <?php
      include "MySQL.php";
      $result = mysqli_query($connect, "SELECT `id` FROM `users` WHERE `id` != 3");
      echo "Total registered users: ".mysqli_num_rows($result);
      ?>
      <!-- <div style="display: flex; flex-direction: row; margin-bottom: 20px; position: absolute; right: 0;">
        <input class="btn btn-lg btn-warning" type="submit" name="sort" value="Sort by balance" onClick="window.location='adduser.php'" style="margin-right: 30px;"/>
      </div> -->
      <?php $list = $conn->query("SELECT * FROM users WHERE id!='{$_SESSION["user-id"]}'");?>
         <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
       <form action="app/admin_moves.php" method="POST" style="margin-bottom: 20px;">
       <input type="hidden" class="form-control" name = "user_id" placeholder="user_id" value="<?php echo $acc['id'] ?>">
       <p class="h3 mb-3 fw-normal">Name: <?php echo $acc['name'] ?></p>
       <input type="hidden" class="form-control" name = "name" placeholder="name" value="<?php echo $acc['name'] ?>">
       <p class="h3 mb-3 fw-normal">Email: <?php echo $acc['email'] ?></p>
       <input type="hidden" class="form-control" name = "email" placeholder="email" value="<?php echo $acc['email'] ?>">
       <p class="h3 mb-3 fw-normal">Balance: <?php echo $acc['account'] ?></p>
       <input type="hidden" class="form-control" name = "account" placeholder="account" value="<?php echo $acc['account'] ?>">
       <p class="h3 mb-3 fw-normal">Blocked: <?php if ($acc['blocked'] == 0){echo "No";}
       else {echo "Yes";} ?></p>
       <p class="h3 mb-3 fw-normal">Status: <?php if ($acc['status'] == 'only read'){echo "Only read";}
       else if ($acc['status'] == 'client'){echo "Client";}  else if ($acc['status'] == 'admin'){echo "Admin";}?></p>
       <div style="display: flex; flex-direction: row; margin-bottom: 20px;">
         <input class="btn btn-lg btn-danger" type="submit" name="block" value="Block" <?php if ($acc['blocked'] == 1){
           echo 'disabled=true';}  ?> style="margin: 5px;"/>
         <input class=" btn btn-lg btn-success" type="submit" name="unlock" value="Unlock" <?php if ($acc['blocked'] == 0){
           echo 'disabled=true';}  ?> style="margin: 5px; margin-right: 30px;"/>

         <input class=" btn btn-lg btn-secondary" type="submit" name="onlyRead" value="Only read" <?php if ($acc['status'] == "only read"){
           echo 'disabled=true';}  ?> style="margin: 5px;"/>
         <input class=" btn btn-lg btn-secondary" type="submit" name="client" value="Client" <?php if ($acc['status'] == "client"){
           echo 'disabled=true';}  ?> style="margin: 5px;" />
         <input class=" btn btn-lg btn-secondary" type="submit" name="admin" value="Admin" <?php if ($acc['status'] == "admin"){
           echo 'disabled=true';} ?> style="margin: 5px;"/>'
       </div>
       <div style="display: flex; flex-direction: row; margin-bottom: 20px;">
       <input style="margin: 20px; width: 200px;" type="newbalance" class="form-control" name = "newbalance" placeholder="New Balance">
       <button class="w-20 btn  btn-secondary" type="submit">Change balance</button>
     </div>
        </form>
        <hr color="#0000" size="10" />
        <?php } ?>
</body>
</html>
