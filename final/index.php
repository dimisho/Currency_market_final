<?php session_start();

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
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="UTF-8">
    <title>TripleD Market</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  </head>
  <body>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <img src="img/logo.jpg" width="40" height="32" style="margin-right: 10px">
        <span class="fs-4">TripleD Market</span>
      </a>

      <div>
      </div>
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
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
                  echo '<li class="nav-item"><a href="stocks.php" class="nav-link" aria-page="page">Stocks</a></li>';
                  echo '<li class="nav-item"><a href="includes/logout.inc.php" class="nav-link" aria-page="page">Log Out</a></li>';
                }
              }
         ?>
      </ul>
    </header>
  </div>
  <div class="px-4 py-5 my-5 text-center">
      <h1 class="display-5 fw-bold">TripleD Market</h1>
      <div class="col-lg-6 mx-auto">
        <?php if (!isset($_SESSION["is-login"])){
                            echo'
        <p class="lead mb-4">Please register or log in to your account.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <a href="login.php"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Login</button></a>
          <a href="signup.php"><button type="button" class="btn btn-outline-secondary btn-lg px-4">Sign up</button></a>
          </div>';
        }
        if (isset($_SESSION["is-login"])){
                            echo '
          <p class="lead mb-4">Your personal account and a list of stocks available in the top menu.</p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <a href="account.php"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Open My Account</button></a>
          </div>';
                          }
        ?>
      </div>
      <hr color="#0000" size="10" />
      <h2 class="h3 mb-3 fw-normal" style="margin: 20px;">News</h2>
      <div id="News" style="display: flex; flex-direction: row; justify-content: space-between;">
        <div id="Forex market">
          <script type="text/javascript" src="https://www.rssdog.com/index.php?url=http%3A%2F%2Fwww.gazeta.ru%2Fexport%2Frss%2Fbusnews.xml&amp;mode=javascript&amp;showonly=&amp;maxitems=0&amp;showdescs=1&amp;desctrim=0&amp;descmax=0&amp;tabwidth=100%25&amp;showdate=1&amp;utf8=1&amp;linktarget=_blank&amp;bordercol=%23d4d0c8&amp;headbgcol=%23999999&amp;headtxtcol=%23ffffff&amp;titlebgcol=%23f1eded&amp;titletxtcol=%23000000&amp;itembgcol=%23ffffff&amp;itemtxtcol=%23000000&amp;ctl=0">
</script>
<noscript> You apparently do not have JavaScript enabled on your browser lest you would be viewing an RSS Feed here from  </noscript>
        </div>
        <div id="Politics">
          <script type="text/javascript" src="https://www.rssdog.com/index.php?url=http%3A%2F%2Fnews.yandex.ru%2Fpolitics.rss&amp;mode=javascript&amp;showonly=&amp;maxitems=0&amp;showdescs=1&amp;desctrim=0&amp;descmax=0&amp;tabwidth=100%25&amp;showdate=1&amp;utf8=1&amp;linktarget=_blank&amp;bordercol=%23d4d0c8&amp;headbgcol=%23999999&amp;headtxtcol=%23ffffff&amp;titlebgcol=%23f1eded&amp;titletxtcol=%23000000&amp;itembgcol=%23ffffff&amp;itemtxtcol=%23000000&amp;ctl=0">
</script>
<noscript> You apparently do not have JavaScript enabled on your browser lest you would be viewing an RSS Feed here from</noscript>
        </div>
      </div>
    </div>
  </body>
</html>
