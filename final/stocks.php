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
<?php
require 'view_text.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stocks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.stock.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/api.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="papaparse.min.js"></script>
<!--    бИБЛИОТЕКА ГРАФИКА-->
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js" type="text/javascript"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-stock.min.js" type="text/javascript"></script>
    <script src="https://cdn.anychart.com/csv-data/msft-daily-short.js" type="text/javascript"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css"/>
    <style>
      .main{
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        display: flex;
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
                  echo '<li class="nav-item"><a href="account.php" class="nav-link" aria-page="page">Account</a></li>';
                  echo '<li class="nav-item"><a href="stocks.php" class="nav-link active" aria-page="page">Stocks</a></li>';
                  echo '<li class="nav-item"><a href="includes/logout.inc.php" class="nav-link" aria-page="page">Log Out</a></li>';
                }
              }
         ?>
      </ul>
    </header>
  </div>
<div class="main" style="display: flex; justify-content: space-around;">
  <div id="chartik" style="height: 450px; width: 50%; margin: 50px;">
    <select id="list" name="select2">
        <option selected="selected">Choose a currency</option>
        <option value="901">USD</option>
        <option value="66860">EUR</option>
        <option value="498844">UAH</option>
        <option value="456495">BYN</option>
        <option value="399725">GBP</option>
    </select>
    <button id="btn1">Upload a 7-day history</button>
    <input id="btn" type="hidden" style="background-color: chartreuse; border-radius: 10px; color: #ffffff"></input>
    <div id="container"></div>
  </div>
  <div id="Buy-Sell" style="margin-right: 100px;">
    <main class="form-signin">
      <div class="justify">
        <form  action="app/buy.php" method="post" style="max-width: 500px;
           margin-left: auto;
           margin-right: auto;">
           <?php $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");?>
              <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
                <h1 class="h3 mb-3 fw-normal">Your Balance: <?php echo $acc['account']; ?> rub.</h1>
                 <?php } ?>
                 <div style="outline: 2px solid #000; display: flex; flex-direction: row; justify-content: space-around;; align-items: center;
                 margin-bottom: 10px;">
                   <div>
                      <h2 class="h3 mb-3 fw-normal">You have </h2>
                   </div>
                  <div>
                 <?php $list = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
                   AND ticker='USD' ");
                   if ($list->rowCount() != 0){?>
                    <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
                <h2 class="h3 mb-3 fw-normal"><?php echo $acc['amount']; ?> USD.</h2>
              <?php } } else{ ?>
              <h2 class="h3 mb-3 fw-normal">0 USD.</h2>
            <?php } ?>

            <?php $list = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
                  AND ticker='EUR' ");
                  if ($list->rowCount() != 0){?>
                   <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
               <h2 class="h3 mb-3 fw-normal"><?php echo $acc['amount']; ?> EUR.</h2>
             <?php } } else{ ?>
             <h2 class="h3 mb-3 fw-normal">0 EUR.</h2>
           <?php } ?>

           <?php $list = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
                 AND ticker='UAH' ");
                 if ($list->rowCount() != 0){?>
                  <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
              <h2 class="h3 mb-3 fw-normal"><?php echo $acc['amount']; ?> UAH.</h2>
            <?php } } else{ ?>
            <h2 class="h3 mb-3 fw-normal">0 UAH.</h2>
          <?php } ?>

          <?php $list = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
                AND ticker='BYN' ");
                if ($list->rowCount() != 0){?>
                 <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
             <h2 class="h3 mb-3 fw-normal"><?php echo $acc['amount']; ?> BYN.</h2>
           <?php } } else{ ?>
           <h2 class="h3 mb-3 fw-normal">0 BYN.</h2>
         <?php } ?>

         <?php $list = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
               AND ticker='GBP' ");
               if ($list->rowCount() != 0){?>
                <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
            <h2 class="h3 mb-3 fw-normal"><?php echo $acc['amount']; ?> GBP.</h2>
          <?php } } else{ ?>
          <h2 class="h3 mb-3 fw-normal">0 GBP.</h2>
        <?php } ?>
      </div>
    </div>

                <h2 class="h3 mb-3 fw-normal">Price: <p id="p" style="color: blue;"><span id="span"> rub.</span></p></h2>
                <?php $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");?>
                   <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="form-floating" style="margin: 10px">
              <input type="num_buy" <?php if ($acc['status'] == 'only read'){ echo 'disabled=true'; } ?> class="form-control" class="<?php if($is_invalid) echo 'is-invalid"'; $_SESSION["is-invalid"] = false; ?>" name = "num_buy" placeholder="number">
              <label for="floatingPassword">Enter the quantity</label>
            </div>
            <button <?php if ($acc['status'] == 'only read'){ echo 'disabled=true'; } ?>  class="w-100 btn btn-lg btn-success" type="submit">Buy</button>
          <?php } ?>
            <input id="myPrice" type="hidden" name="price">
            <input id="myTicker" type="hidden" name="ticker">
          </form>

          <form  action="app/sell.php" method="post" style="max-width: 500px;
             margin-left: auto;
             margin-right: auto;">
             <?php $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");?>
                <?php while($acc = $list->fetch(PDO::FETCH_ASSOC)) { ?>
              <div class="form-floating" style="margin: 10px">
                <input <?php if ($acc['status'] == 'only read'){ echo 'disabled=true'; } ?> type="num_sell" class="form-control" class="<?php if($is_invalid) echo 'is-invalid"'; $_SESSION["is-invalid"] = false; ?>" name = "num_sell" placeholder="number">
                <label for="floatingPassword">Enter the quantity</label>
              </div>
              <button <?php if ($acc['status'] == 'only read'){ echo 'disabled=true'; } ?> class="w-100 btn btn-lg btn-danger" type="submit">Sell</button>
            <?php } ?>
              <input id="myPrice2" type="hidden" name="price2">
              <input id="myTicker2" type="hidden" name="ticker2">
            </form>
      </div>
  </main>
  </div>
</div>
</body>
<script src="script.js"></script>
</html>
