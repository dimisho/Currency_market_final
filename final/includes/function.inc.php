<?php
include "./MySQL.php";
function is_empty($fields){

    foreach($fields as $field){
        if ($field === ""){
            return true;
            break;
        }

    }
    return false;
}

function is_password($password){
    $result = false;
    $value = str_split($password);
    if ( $value === "")
    {
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function is_email($email){
    $value = str_split($email);
    if ( in_array("@", $value)){
        return false;
    }else{
        return true;
    }
}



function error_handler($error){
    switch ($error) {
        case "empty":
            echo "<span style='color:red'>Вы заполнили не все поля!</span>";
            break;
        case "not-email":
            echo "<span style='color:red'>Некорректная эл. почта!</span>";
            break;
        case "email_exist":
            echo "Пользователь с такой эл. почтой существует! <a href = ./login.php>Авторизуйтесь...</a>";
            break;
        case "not-password":
            echo "<span style='color:red'>Некорректный пароль</span>";
            break;
        case "pass_not_confirm":
            echo "<span style='color:red'>Пароли не совпадают</span>";
            break;


}

}

function user_exist($email){
    $ip = "127.0.0.1";
    $name = "root";
    $pass = "";
    $name_db = "stock_market";

    $connect = mysqli_connect($ip, $name, $pass, $name_db);

    $result = mysqli_query($connect, "SELECT `id` FROM `users` WHERE `email`= '{$email}'");
    if (mysqli_num_rows($result)===0){
        return false;
    }else{
        return true;
    }
}



?>
