<?php
session_start();
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);

$user_id = $_SESSION['user_id'] ?? null;

// モデルからお気に入り一覧取得
$favorites = getFavoriteList($pdo, $user_id);

function getFavorites($pdo, $user_id) {
    $sql = "
        SELECT b.book_id, b.title, b.synopsis, b.sample, b.price, p.purchase_date
        FROM favorites f
        JOIN books b ON f.book_id = b.book_id
        LEFT JOIN purchases p ON p.book_id = f.book_id AND p.user_id = f.user_id
        WHERE f.user_id = ?
          AND f.favorite_status = 0
          AND b.public_status = 0
        ORDER BY f.favorite_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>