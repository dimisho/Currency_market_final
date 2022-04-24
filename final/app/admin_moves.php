<?php
session_start();
if( isset( $_POST['block'] ) )
{
    if(isset($_POST['email'])){
        require '../db_conn.php';

        $id = $_POST['user_id'];

        $res = $conn->query("UPDATE users SET blocked=1 WHERE id=$id");

        if($res){
            header("Location: ../admin.php?mess=success");
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }else {
        header("Location: ../admin.php?mess=error");
    }
}

if( isset( $_POST['unlock'] ) )
{
    if(isset($_POST['email'])){
        require '../db_conn.php';

        $id = $_POST['user_id'];

        $res = $conn->query("UPDATE users SET blocked=0 WHERE id=$id");

        if($res){
            header("Location: ../admin.php?mess=success");
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }else {
        header("Location: ../admin.php?mess=error");
    }
}

if( isset( $_POST['onlyRead'] ) )
{
    if(isset($_POST['email'])){
        require '../db_conn.php';

        $id = $_POST['user_id'];

        $res = $conn->query("UPDATE users SET status='only read' WHERE id=$id");

        if($res){
            header("Location: ../admin.php?mess=success");
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }else {
        header("Location: ../admin.php?mess=error");
    }
}

if( isset( $_POST['client'] ) )
{
    if(isset($_POST['email'])){
        require '../db_conn.php';

        $id = $_POST['user_id'];

        $res = $conn->query("UPDATE users SET status='client' WHERE id=$id");

        if($res){
            header("Location: ../admin.php?mess=success");
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }else {
        header("Location: ../admin.php?mess=error");
    }
}

if( isset( $_POST['admin'] ) )
{
    if(isset($_POST['email'])){
        require '../db_conn.php';

        $id = $_POST['user_id'];

        $res = $conn->query("UPDATE users SET status='admin' WHERE id=$id");

        if($res){
            header("Location: ../admin.php?mess=success");
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }else {
        header("Location: ../admin.php?mess=error");
    }
}

if( isset( $_POST['newbalance'] ) )
{
    if(isset($_POST['email'])){
        require '../db_conn.php';

        $id = $_POST['user_id'];
        $new = $_POST['newbalance'];

        $stmt = $conn->prepare("UPDATE users SET account=:new WHERE id=$id");
        $params = [
        ':new' => $new
];
        $res = $stmt->execute($params);

        if($res){
            header("Location: ../admin.php?mess=success");
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }else {
        header("Location: ../admin.php?mess=error");
    }
}
