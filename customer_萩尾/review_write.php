<?php
session_start();
require_once 'db-connect.php'; 

$msg = ''; // 投稿メッセージ初期化

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = new PDO($connect, USER, PASS);

    $user_id = 1; // 仮ユーザーID（ログイン後は $_SESSION['user_id'] に置き換え）
    $book_id = $_POST['book_id'] ?? 0;
    $review_rank = $_POST['rating'] ?? null;
    $comment_text = $_POST['comment'] ?? null;

    if ($review_rank && $comment_text) {
        $sql = "INSERT INTO reviews (user_id, book_id, review_rank, comment_text, upload_date)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $book_id, $review_rank, $comment_text]);

        $msg = "レビューを投稿しました！";
    } else {
        $msg = "星評価とコメントを入力してください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー投稿</title>
    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .rating {
        direction: rtl;
        display: inline-flex;
    }
    .rating input {
        display: none;
    }
    .rating label {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
    }
    .rating input:checked ~ label i,
    .rating label:hover i,
    .rating label:hover ~ label i {
        color: black;
    }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?>
<section class="section">
<div class="container">
    <h1 class="title">レビューを投稿する</h1>

    <!-- 投稿メッセージ -->
    <?php if (!empty($msg)): ?>
        <div class="notification is-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <!-- hiddenでbook_idを渡す -->
        <input type="hidden" name="book_id" value="<?= htmlspecialchars($_GET['book_id'] ?? 0) ?>">

        <div class="box">
            <div class="field">
                <label class="label">この本の評価は？→</label>
                <div class="control rating">
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5"><i class="fas fa-star"></i></label>
                </div>
            </div>

            <div class="field">
                <label class="label">本文</label>
                <div class="control">
                    <textarea class="textarea" name="comment" rows="10"></textarea>
                </div>
            </div>

            <div class="field is-grouped is-grouped-right mt-5">
                <p class="control">
                    <button type="submit" class="button is-black">
                        <span class="icon"><i class="fas fa-paper-plane"></i></span>
                        <span>投稿</span>
                    </button>
                </p>
                <p class="control">
                    <a href="customer_home.php" class="button is-black">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span>ホームに戻る</span>
                    </a>
                </p>
            </div>
        </div>
    </form>
</div>
</section>
 <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>
