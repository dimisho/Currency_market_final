<?php
session_start();
if(isset($_POST['newemail'])){
    require '../db_conn.php';

    $new = $_POST['newemail'];
    $user_id = $_SESSION["user-id"];

    if(empty($new)){
        header("Location: ../account.php?mess=error");
    }else {
        $stmt = $conn->prepare("UPDATE users SET email=:new WHERE id='{$_SESSION["user-id"]}'");
        $params = [
        ':new' => $new
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
