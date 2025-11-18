<?php
// -------------------------
// セッション開始 & DB接続
// -------------------------
session_start();
require '../db/db-connect.php';

$pdo = new PDO($connect, USER, PASS);
$user_id = $_SESSION['user_id'] ?? null;
$book_id = $_GET['book_id'] ?? 0;

// -------------------------
// 関数定義
// -------------------------

/**
 * 指定ユーザーが指定の書籍を購入しているかチェック
 */
function checkPurchased($pdo, $user_id, $book_id) {
    $sql = "SELECT 1 FROM purchases WHERE user_id = ? AND book_id = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $book_id]);
    return $stmt->fetchColumn() ? true : false;
}

/**
 * 書籍のレビューを取得
 */
function getReviews($pdo, $book_id) {
    $sql = "SELECT r.review_id, r.user_id, r.comment_text, r.review_rank, u.user_name
            FROM reviews r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.book_id = :book_id
            ORDER BY r.review_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// -------------------------
// データ取得
// -------------------------
$reviews = getReviews($pdo, $book_id);
$is_purchased = $user_id ? checkPurchased($pdo, $user_id, $book_id ): false;
?>
