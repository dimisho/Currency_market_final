<?php
    $ip = "127.0.0.1";
    $name = "root";
    $pass = "";
    $name_db = "stock_market";

    $connect = mysqli_connect($ip, $name, $pass, $name_db);

    if ($connect === false)
    {
        echo "ошибка подключения";
    }
    // echo "Соединение успешно";
    // mysqli_close($connect);
?>
