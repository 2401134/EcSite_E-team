<?php
session_start();
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);

if (!isset($_SESSION['user_id'])) {
    // ゲストの場合はアラートを出してホームに戻す
    echo "<script>
        alert('ゲストユーザーはお気に入り登録できません。ログインしてください。');
        window.location.href = '../customer_home.php';
    </script>";
    exit; // これ以上処理しない
}

$user_id = $_SESSION['user_id'];
if (!empty($_POST['book_id'])) {
    $book_id = (int)$_POST['book_id'];
} elseif (!empty($_SESSION['book_id'])) {
    $book_id = (int)$_SESSION['book_id'];
} else {
    $book_id = null;
}

if($book_id > 0){
    $stmt = $pdo->prepare("SELECT favorite_id, favorite_status FROM favorites WHERE user_id=? AND book_id=?");
    $stmt->execute([$user_id, $book_id]);
    $fav = $stmt->fetch(PDO::FETCH_ASSOC);

    $now = date('Y-m-d H:i:s');

    if($fav){
        if($fav['favorite_status'] == 0){
            // 現在登録済み → 論理削除（解除）
            $update = $pdo->prepare("UPDATE favorites SET favorite_status=1 WHERE favorite_id=?");
            $update->execute([$fav['favorite_id']]);
            $_SESSION['alert_msg'] ='お気に入り解除しました';
        } else {
            // 論理削除されている → 再登録
            $update = $pdo->prepare("UPDATE favorites SET favorite_status=0, favorite_date=? WHERE favorite_id=?");
            $update->execute([$now, $fav['favorite_id']]);
            $_SESSION['alert_msg'] = 'お気に入り追加しました';
        }
    } else {
        // 新規登録
        $insert = $pdo->prepare("INSERT INTO favorites(user_id, book_id, favorite_date, favorite_status) VALUES(?, ?, ?, 0)");
        $insert->execute([$user_id, $book_id, $now]);
    }
}

// 元のページに戻る
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;