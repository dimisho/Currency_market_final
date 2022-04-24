<?php
session_start();
include "../MySQL.php";
require_once "function.inc.php";

if (is_empty($_POST)){
    $_SESSION["is-invalid"] = true;
    header("location: ../login.php?error=empty");
    exit();
}
if (is_email($_POST["user_email"])){
    $_SESSION["is-invalid"] = true;
    header("location: ../login.php?error=not-email");
    exit();
}

$result = mysqli_query($connect, "SELECT `id`, `password`, `blocked` FROM `users` WHERE `email`= '{$_POST["user_email"]}'");

if (mysqli_num_rows($result)!=0)
{
    $data = mysqli_fetch_assoc($result);
    if (password_verify($_POST["user_pass"],$data["password"]) && $data["blocked"] == 0)
    {
        $_SESSION['is-login'] = true;
        $_SESSION["user-id"] = $data["id"];
        $_SESSION['start'] = time();
        header("location: ../");
    }else{
        $_SESSION["is-invalid"] = true;
        header("location: ../login.php");
    }
}else{
    $_SESSION["is-invalid"] = true;
    header("location: ../login.php?error=none");
}

?>
