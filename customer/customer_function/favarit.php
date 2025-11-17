<?php
session_start();
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);

$user_id = $_SESSION['user_id'] ?? 1;
$book_id = $_POST['book_id'] ?? 0;

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
        } else {
            // 論理削除されている → 再登録
            $update = $pdo->prepare("UPDATE favorites SET favorite_status=0, favorite_date=? WHERE favorite_id=?");
            $update->execute([$now, $fav['favorite_id']]);
        }
    } else {
        // 新規登録
        $insert = $pdo->prepare("INSERT INTO favorites(user_id, book_id, favorite_date, favorite_status) VALUES(?, ?, ?, 0)");
        $insert->execute([$user_id, $book_id, $now]);
    }
}

// 元のページに戻る
header("Location: customer_home.php");
exit;
