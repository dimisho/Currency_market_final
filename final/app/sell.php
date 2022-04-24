<?php
session_start();
if(isset($_POST['num_sell'])){
    require '../db_conn.php';

    $num = $_POST['num_sell'];
    $price =  $_POST['price2'];
    $ticker =  $_POST['ticker2'];
    $user_id = $_SESSION["user-id"];

    $final_sum = $num*$price;

    if(empty($num)){
        header("Location: ../stocks.php?mess=error");
    }else {
      $listok = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'
        AND ticker='$ticker' ");
        if ($listok->rowCount() != 0){
                      $list = $conn->query("SELECT * FROM user_stock WHERE user_id='{$_SESSION["user-id"]}'");
                        while($acc = $list->fetch(PDO::FETCH_ASSOC)) {
                            $amount = $acc['amount'];
                         }
                         if ($amount >= $num){
                            $stmt = $conn->prepare("UPDATE users SET account=account+:final_sum WHERE id='{$_SESSION["user-id"]}'");
                            $params = [
                            ':final_sum' => $final_sum ];
                            $res = $stmt->execute($params);

                            $stmt2 = $conn->prepare("UPDATE user_stock SET amount=amount-:num WHERE user_id='{$_SESSION["user-id"]}'
                            AND ticker='$ticker' ");
                            $params2 = [
                            ':num' => $num ];
                            $res2 = $stmt2->execute($params2);


                            if($res and $res2){
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
          else{
            echo "<script>alert('Not enough money on your balance')</script>";
            echo "<meta http-equiv='refresh' content='0; url=../stocks.php'>";
          }
    }
}else {
    header("Location: ../stocks.php?mess=error");
}
