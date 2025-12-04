<?php
session_start();
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);

// ログインしていない場合はログイン画面へ
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('ログインしてください');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
    echo "<script>history.back()</script>";
    exit();
}

// ログインユーザーID
$user_id = $_SESSION['user_id'] ?? null;

// JOIN で購入書籍一覧を取得
$sql = "SELECT 
          b.book_id,
          b.title,
          b.synopsis,
          b.book_image,
          p.price,
          p.purchase_date
        FROM purchases p
        JOIN books b ON p.book_id = b.book_id
        WHERE p.user_id = ?
        ORDER BY p.purchase_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>