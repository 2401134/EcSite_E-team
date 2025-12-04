<?php
require 'db-connect.php';
session_start();
$uri = $_SESSION['uri'];

if (!isset($_POST['cart_id'])) {
    echo '<script>
        http_response_code(404);
        history.back();
        </script>';
    exit;
}

$cart_id = $_POST['cart_id'];

try {
    $pdo = new PDO($connect, USER, PASS);

    // cart_status を 1 に変更
    $sql = $pdo->prepare("UPDATE carts SET cart_status = 1 WHERE cart_id = ?");
    $sql->execute([$cart_id]);

    // JavaScript でアラートを出して cart.php に戻る
    $_SESSION['alert_msg'] = "削除しました。";
    echo "
    <script>
        window.location.href = '". $uri ."';
    </script>
    ";
    exit;

} catch (Exception $e) {
    $_SESSION['alert_msg'] = "エラーが発生により削除できませんでした。";
    echo "
    <script>
        window.location.href = '". $uri ."';
    </script>
    ";
    exit;
}
