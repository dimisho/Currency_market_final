<?php
session_start();
require_once "function.inc.php";
$user_name = $_POST["user_name"];
$user_email =  $_POST["user_email"];
$user_pass = $_POST["user_pass"];
$sub_pass = $_POST["sub_pass"];
include "../MySQL.php";
   
if (is_empty($_POST)){
    $_SESSION["is-invalid"] = true;
    header("location: ../signup.php?error=empty");
    exit();
}
if (is_email($_POST["user_email"])){
    $_SESSION["is-invalid"] = true;
    header("location: ../signup.php?error=not-email");
    exit();
}
if (user_exist($_POST["user_email"])){
    $_SESSION["is-invalid"] = true;
    header("location: ../signup.php?error=email_exist");
    exit();
}
if ($user_pass != $sub_pass)
{
    $_SESSION["is-invalid"] = true;
    header("location: ../signup.php?error=pass_not_confirm");
    exit();
}
    $hash_pass = password_hash($user_pass, PASSWORD_DEFAULT);
    $result = mysqli_query($connect, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('{$user_name}','{$user_email}','{$hash_pass}')");
    if (!$result){
        echo "Что то пошло не так";
    }
    header("location: ../")
?>