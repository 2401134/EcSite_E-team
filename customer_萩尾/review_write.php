<?php
session_start();
require_once 'db-connect.php'; 

$msg = ''; // 投稿メッセージ初期化

try {
    // DB接続
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // book_idをGETとPOSTの両方から取得
    $book_id = (int)($_POST['book_id'] ?? $_GET['book_id'] ?? 0);

    // POSTで送信された場合のみ処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 仮のユーザーID（ログイン実装後は $_SESSION['user_id'] に変更）
        $user_id = 1;
        $review_rank = $_POST['rating'] ?? null;
        $comment_text = trim($_POST['comment'] ?? '');

        // book_idが指定されているかチェック
        if ($book_id === 0) {
            $msg = "エラー: book_idが指定されていません。";
        } else {
            // 対応する本がbooksテーブルに存在するか確認
            $check_sql = "SELECT COUNT(*) FROM books WHERE book_id = ?";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->execute([$book_id]);
            $exists = $check_stmt->fetchColumn();

            if ($exists == 0) {
                $msg = "エラー: 指定された書籍が存在しません。(book_id=$book_id)";
            } 
            // 星評価とコメントがある場合のみ投稿
            elseif ($review_rank && $comment_text) {
                $sql = "INSERT INTO reviews (user_id, book_id, review_rank, comment_text, upload_date)
                        VALUES (?, ?, ?, ?, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user_id, $book_id, $review_rank, $comment_text]);

                $msg = "レビューを投稿しました！";
            } else {
                $msg = "星評価とコメントを入力してください。";
            }
        }
    }
} catch (PDOException $e) {
    $msg = "データベースエラー: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー投稿</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .rating { direction: rtl; display: inline-flex; }
    .rating input { display: none; }
    .rating label { font-size: 2rem; color: #ccc; cursor: pointer; }
    .rating input:checked ~ label i,
    .rating label:hover i,
    .rating label:hover ~ label i { color: black; }
    </style>
</head>
<body>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<section class="section">
<div class="container">
    <h1 class="title">レビューを投稿する</h1>

    <?php if (!empty($msg)) { ?>
        <div class="notification is-info"><?= htmlspecialchars($msg) ?></div>
    <?php } ?>

    <form action="" method="POST">
        <!-- hiddenでbook_idを確実に渡す -->
        <input type="hidden" name="book_id" value="<?= $book_id ?>">

        <div class="box">
            <div class="field">
                <label class="label">この本の評価は？→</label>
                <div class="control rating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1"><i class="fas fa-star"></i></label>
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
