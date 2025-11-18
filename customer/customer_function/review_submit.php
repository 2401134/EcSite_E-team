<?php
session_start();
require_once '../db/db-connect.php';

// 仮ユーザー
$user_id = 1;

$pdo = new PDO($connect, USER, PASS);

// メッセージ初期化
$msg = "";

// book_id を POST または GET から取得
$book_id = (int)($_POST['book_id'] ?? $_GET['book_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $review_rank = $_POST['rating'] ?? null;
    $comment_text = $_POST['comment'] ?? "";

    // ----------------------------------------
    // ① 書籍の存在チェック
    // ----------------------------------------
    if (!bookExists($pdo, $book_id)) {
        $msg = "エラー: 指定された書籍が存在しません。(book_id=$book_id)";
    } else {
        // ----------------------------------------
        // ② 入力チェック
        // ----------------------------------------
        $msg = validateReview($review_rank, $comment_text);

        if ($msg === "") {
            // ----------------------------------------
            // ③ レビュー登録
            // ----------------------------------------
            if (insertReview($pdo, $user_id, $book_id, $review_rank, $comment_text)) {
                $msg = "レビューを投稿しました！";
            } else {
                $msg = "レビュー投稿に失敗しました。";
            }
        }
    }
}

// ------------------------
// 関数定義
// ------------------------

/**
 * 書籍が存在するかチェック
 */
function bookExists($pdo, $book_id) {
    $sql = "SELECT COUNT(*) FROM books WHERE book_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$book_id]);
    return $stmt->fetchColumn() > 0;
}

/**
 * レビューをデータベースに登録
 */
function insertReview($pdo, $user_id, $book_id, $review_rank, $comment_text) {
    $sql = "INSERT INTO reviews (user_id, book_id, review_rank, comment_text, upload_date)
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_id, $book_id, $review_rank, $comment_text]);
}

/**
 * 入力チェック
 */
function validateReview($review_rank, $comment_text) {

    if (empty($review_rank)) {
        return "星評価を選択してください。";
    }

    if (trim($comment_text) === "") {
        return "コメントを入力してください。";
    }

    return ""; // エラーなし
}
?>
