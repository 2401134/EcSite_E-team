<?php
session_start();
require 'db-connect.php'; // DB接続情報

$pdo = new PDO($connect, USER, PASS);

// ログインユーザーID
$user_id = $_SESSION['user_id'] ?? null;

// お気に入り一覧取得
function getFavoriteList($pdo, $user_id) {
    if (!$user_id) return []; // 未ログインなら空配列

    $sql = "SELECT 
                b.book_id, 
                b.title, 
                b.synopsis, 
                b.sample,
                b.price,
                b.book_image,
                p.purchase_date
            FROM favorites f
            JOIN books b ON f.book_id = b.book_id
            LEFT JOIN purchases p 
                ON f.book_id = p.book_id 
                AND p.user_id = f.user_id
            WHERE f.user_id = :user_id
              AND f.favorite_status = 0
            ORDER BY f.favorite_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
