<?php
if (isset($_GET['price'])) // Проверка существования переменной
{
    $priZ = $_GET['price'];
    echo $_GET['price'];
}
if (isset($_GET['ticker']))
{
    $tiK = $_GET['ticker'];
    echo $_GET['ticker'];
}
