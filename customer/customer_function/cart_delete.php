<?php
require 'db-connect.php';
session_start();

if (!isset($_POST['cart_id'])) {
    exit("不正なアクセスです。");
}

$cart_id = $_POST['cart_id'];

try {
    $pdo = new PDO($connect, USER, PASS);

    // cart_status を 1 に変更
    $sql = $pdo->prepare("UPDATE carts SET cart_status = 1 WHERE cart_id = ?");
    $sql->execute([$cart_id]);

    // JavaScript でアラートを出して cart.php に戻る
    echo "
    <script>
        alert('削除しました');
        window.location.href = '../cart.php';
    </script>
    ";
    exit;

} catch (Exception $e) {
    echo "エラー：" . $e->getMessage();
}
