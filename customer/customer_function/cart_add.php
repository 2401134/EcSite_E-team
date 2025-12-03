<?php
session_start();
require 'db-connect.php';

// book_id 取得チェック
if (!isset($_POST['book_id'])) {
    echo '<script>
        http_response_code(404);
        history.back();
        </script>';
    exit;
}

$book_id = (int)$_POST['book_id'];

// ▼ ログインしていない場合
if (!isset($_SESSION['user_id'])) {
    $_SESSION['alert_msg'] = "ログインしてください";
    echo "<script>
            window.location.href = '../tryread.php';   // 元の画面へ戻る
          </script>";
    exit;
}

$user_id = (int)$_SESSION['user_id'];

try {
    $pdo = new PDO($connect, USER, PASS);

    // ▼ 今のユーザー＆本の組み合わせが carts に存在するか確認
    $sql = "SELECT cart_id, cart_status FROM carts 
            WHERE user_id = ? AND book_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $book_id]);
    $cart = $stmt->fetch();

    if ($cart) {

        // ▼ cart_status = 1（削除済み）なら復活させる
        if ($cart['cart_status'] == 1) {
            $update = "UPDATE carts SET cart_status = 0, put_in_cart = NOW()
                       WHERE cart_id = ?";
            $stmt = $pdo->prepare($update);
            $stmt->execute([$cart['cart_id']]);

            $_SESSION['alert_msg'] = "カートに再追加しました";
        } else {
            // cart_status = 0 → すでにカートに入っている
            $_SESSION['alert_msg'] = "この商品はすでにカートに入っています";
        }

    } else {
        // ▼ 新規追加（初めてカートに入れる）
        $insert = "INSERT INTO carts (user_id, book_id, put_in_cart, cart_status)
                   VALUES (?, ?, NOW(), 0)";
        $stmt = $pdo->prepare($insert);
        $stmt->execute([$user_id, $book_id]);

        $_SESSION['alert_msg'] = "カートに追加しました";
    }

    // 試し読みへ戻る
    echo "<script>
        window.location.href = '../tryread.php';
        </script>";
    exit;

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    exit;
}
?>
