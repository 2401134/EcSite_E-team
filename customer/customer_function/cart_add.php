<?php
session_start();
require 'db-connect.php';

// book_id 取得チェック
if (!isset($_GET['book_id'])) {
    echo "商品が指定されていません。";
    exit;
}

$book_id = (int)$_GET['book_id'];

// ▼ ログインしていない場合
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('ログインしてください');
            history.back();   // 元の画面へ戻る
          </script>";
    exit;
}

$user_id = (int)$_SESSION['user_id'];

try {
    $pdo = new PDO($connect, USER, PASS);

    $sql = "INSERT INTO carts (user_id, book_id, put_in_cart, cart_status)
            VALUES (?, ?, NOW(), 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $book_id]);

    // カートページへ
    header("Location: cart.php");
    exit;

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    exit;
}
?>
