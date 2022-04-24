<?php
session_start();
if(isset($_POST['sum'])){
    require '../db_conn.php';

    $sum = $_POST['sum'];
    $user_id = $_SESSION["user-id"];

    if(empty($sum)){
        header("Location: ../account.php?mess=error");
    }else {
        $stmt = $conn->prepare("UPDATE users SET account=account+:sum WHERE id='{$_SESSION["user-id"]}'");
        $params = [
        ':sum' => $sum
];
        $res = $stmt->execute($params);

        if($res){
            header("Location: ../account.php?mess=success");
        }else {
            header("Location: ../account.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../account.php?mess=error");
}
