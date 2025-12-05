<?php
// セッション開始 & DB接続
session_start();
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);
$user_id = $_SESSION['user_id'] ?? null;
$book_id = $_GET['book_id'] ?? $_POST['book_id'] ?? 0;

/* ---------------------------------------------------------
   🔹 指定ユーザーが指定の書籍を購入しているかチェック
--------------------------------------------------------- */
function checkPurchased($pdo, $user_id, $book_id) {
    $sql = "SELECT 1 FROM purchases WHERE user_id = ? AND book_id = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $book_id]);
    return $stmt->fetchColumn() ? true : false;
}

/* ---------------------------------------------------------
   🔹 書籍のレビューを取得
--------------------------------------------------------- */
function getReviews($pdo, $book_id) {
    $sql = "SELECT r.review_id, r.user_id, r.comment_text, r.review_rank, r.review_status, u.user_name
            FROM reviews r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.book_id = :book_id
              AND r.review_status = 0
            ORDER BY r.review_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ---------------------------------------------------------
   🔹 指定レビューを通報済みか判定（user_logs を利用）
--------------------------------------------------------- */
function alreadyReported($pdo, $user_id, $review_id) {
    $sql = "SELECT 1 FROM user_logs
            WHERE user_id = ?
              AND target_table = 'reviews'
              AND target_id = ?
              AND user_action = 'report'
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $review_id]);
    return $stmt->fetchColumn() ? true : false;
}

/* ---------------------------------------------------------
   🔹 レビュー通報を user_logs に記録
--------------------------------------------------------- */
function reportReview($pdo, $user_id, $review_id) {
    $sql = "INSERT INTO user_logs (user_id, target_table, target_id, user_action, log_date)
            VALUES (?, 'reviews', ?, 'report', NOW())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_id, $review_id]);
}

/* ---------------------------------------------------------
   🔹 通報処理（POSTで実行）
--------------------------------------------------------- */
if (isset($_POST['report_review_id'])) {

    $review_id = (int)$_POST['report_review_id'];

    if (!$user_id) {
        echo "<script>alert('ログインしてください'); history.back();</script>";
        exit;
    }

    // 二重通報防止
    if (alreadyReported($pdo, $user_id, $review_id)) {
        echo "<script>alert('このレビューは既に通報済みです'); history.back();</script>";
        exit;
    }

    // 通報記録
    reportReview($pdo, $user_id, $review_id);

    echo "<script>alert('通報が完了しました'); history.back();</script>";
    exit;
}

/* ---------------------------------------------------------
   データ取得
--------------------------------------------------------- */
$reviews = getReviews($pdo, $book_id);
$is_purchased = $user_id ? checkPurchased($pdo, $user_id, $book_id) : false;

?>