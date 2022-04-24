<?php
session_start();
if(isset($_POST['num_buy'])){
    require '../db_conn.php';

    $num = $_POST['num_buy'];
    $price =  $_POST['price'];
    $ticker =  $_POST['ticker'];
    $user_id = $_SESSION["user-id"];

    $final_sum = $num*$price;

    if(empty($num)){
        header("Location: ../stocks.php?mess=error");
    }else {
      $list = $conn->query("SELECT * FROM users WHERE id='{$_SESSION["user-id"]}'");
        while($acc = $list->fetch(PDO::FETCH_ASSOC)) {
            $balance = $acc['account'];
         }
         if ($balance >= $final_sum){
            $stmt = $conn->prepare("UPDATE users SET account=account-:final_sum WHERE id='{$_SESSION["user-id"]}'");
            $params = [
            ':final_sum' => $final_sum ];
            $res = $stmt->execute($params);

            $list2 = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
              AND ticker='$ticker' ");
              if ($list2->rowCount() == 0){
                  $stmt2 = $conn->prepare("INSERT INTO user_stock(user_id, ticker, amount) VALUE(:user_id, :ticker, :amount)");
                  $params2 = [
                  ':user_id' => $user_id,
                  ':ticker' => $ticker,
                  ':amount' => $num ];
                  $res2 = $stmt2->execute($params2);
                }
              else {
                $stmt3 = $conn->prepare("UPDATE user_stock SET amount=amount+:num WHERE user_id='{$_SESSION["user-id"]}'
                AND ticker='$ticker' ");
                $params3 = [
                ':num' => $num ];
                $res3 = $stmt3->execute($params3);
              }

            if($res and ($res2 or $res3)){
                header("Location: ../stocks.php?mess=success");
            }else {
                header("Location: ../stocks.php");
            }
            $conn = null;
            exit();
          }
          else{
            echo "<script>alert('Not enough money on your balance')</script>";
            echo "<meta http-equiv='refresh' content='0; url=../stocks.php'>";
          }
    }
}else {
    header("Location: ../stocks.php?mess=error");
}
