<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ------------------------------
// GET: book_id で検索（空なら全件）
// ------------------------------
$search_book_id = $_GET['book_id'] ?? '';

// book_id が入力されている → その本のレビューのみ取得
// 空 → 全レビュー表示
if ($search_book_id !== '') {

    // 入力が数字でなければ検索不能
    if (!ctype_digit($search_book_id)) {
        $notFound = true;
        $reviews = [];
    } else {

        // 書籍情報を取得
        $sqlBook = "SELECT book_id, title, author, book_image FROM books WHERE book_id = :id";
        $stmtB = $pdo->prepare($sqlBook);
        $stmtB->bindValue(":id", $search_book_id, PDO::PARAM_INT);
        $stmtB->execute();
        $bookInfo = $stmtB->fetch(PDO::FETCH_ASSOC);

        if (!$bookInfo) {
            // book_id があるが該当なし
            $notFound = true;
            $reviews = [];
        } else {
            $notFound = false;

            // 該当本のレビュー取得
            $sql = "
                SELECT r.*, u.user_name, u.account_id, b.title, b.author, b.book_image
                FROM reviews r
                JOIN users u ON r.user_id = u.user_id
                JOIN books b ON b.book_id = r.book_id
                WHERE r.book_id = :bid
                ORDER BY r.upload_date DESC
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":bid", $search_book_id, PDO::PARAM_INT);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

} else {

    // ------------------------------
    // 全件レビュー取得
    // ------------------------------
    $notFound = false;

    $sql = "
        SELECT r.*, u.user_name, u.account_id, b.title, b.author, b.book_image
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        JOIN books b ON b.book_id = r.book_id
        ORDER BY r.upload_date DESC
    ";
    $reviews = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// ------------------------------
// POST: レビュー表示/非表示トグル
// ------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_review_id'])) {

    $rid = (int)$_POST['toggle_review_id'];
    $cur = (int)$_POST['current_status'];
    $new = ($cur === 0 ? 1 : 0);

    $sqlU = "UPDATE reviews SET review_status = :st WHERE review_id = :id";
    $stmtU = $pdo->prepare($sqlU);
    $stmtU->bindValue(":st", $new, PDO::PARAM_INT);
    $stmtU->bindValue(":id", $rid, PDO::PARAM_INT);
    $stmtU->execute();

    // GET に戻す
    $redir = "review_manage.php";
    if ($search_book_id !== '') {
        $redir .= "?book_id=" . urlencode($search_book_id);
    }
    header("Location: $redir");
    exit;
}

// ------------------------------
// 星表示（1〜5）
// ------------------------------
function starRating(int $rank): string {
    $rank = max(0, min(5, $rank));
    return str_repeat("★", $rank) . str_repeat("☆", 5 - $rank);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レビュー管理</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .review-card { border: 1px solid #dbdbdb; }
        .book-label { font-size: 0.85rem; color: #777; }
        .review-hidden { opacity: 0.5; background: #fafafa; }
    </style>
</head>
<body>

<?php require 'menu.php'; ?>

<section class="section">
<div class="container">

    <h1 class="title">レビュー管理</h1>

    <!-- ▼ book_id検索フォーム -->
    <form method="get" class="mb-5">
        <div class="field has-addons">
            <div class="control is-expanded">
                <input class="input" type="text" name="book_id"
                    placeholder="book_id を入力"
                    value="<?= htmlspecialchars($search_book_id) ?>">
            </div>
            <div class="control">
                <button class="button is-info">
                    <i class="fas fa-search"></i>&nbsp;検索
                </button>
            </div>
        </div>
    </form>

    <?php if ($search_book_id !== '' && $notFound): ?>
        <div class="notification is-warning">
            指定された book_id「<?= htmlspecialchars($search_book_id) ?>」の書籍は見つかりませんでした。
        </div>
    <?php endif; ?>

    <?php if (empty($reviews)): ?>
        <p>レビューがありません。</p>
    <?php else: ?>

        <?php foreach ($reviews as $r): ?>
            <?php $isHidden = ((int)$r['review_status'] === 1); ?>

            <div class="box review-card <?= $isHidden ? 'review-hidden' : '' ?>">

                <!-- 書籍情報（全件表示時にも明示する） -->
                <div class="book-label">
                    <strong>[対象書籍]</strong>
                    <?= htmlspecialchars($r['title']) ?>（<?= htmlspecialchars($r['author']) ?>）
                </div>

                <br>

                <!-- ユーザーアイコン＋評価 -->
                <span class="icon is-large has-text-grey"
                      style="border: 1px solid #4a4a4a; border-radius:45%; padding:2em;">
                    <i class="fas fa-user fa-2x"></i>
                </span>

                <!-- 星 -->
                <span><?= starRating((int)$r['review_rank']) ?></span>

                <br>
                <p class="has-text-centered"><strong><?= htmlspecialchars($r['comment_text']) ?></strong></p>

                <!-- 投稿日 -->
                <div class="is-size-7 mb-2">
                    投稿日：<?= htmlspecialchars($r['upload_date']) ?>
                </div>

                <!-- レビュー削除/非表示 -->
                <div class="review-delete has-text-right">

                    <form action="review_manage.php<?= ($search_book_id !== '' ? '?book_id=' . urlencode($search_book_id) : '') ?>"
                          method="POST" style="display:inline;">
                        <input type="hidden" name="toggle_review_id" value="<?= $r['review_id'] ?>">
                        <input type="hidden" name="current_status" value="<?= $r['review_status'] ?>">

                        <button class="button is-normal is-light is-rounded">
                            <span class="icon is-normal">
                                <i class="fas fa-trash"></i>
                            </span>
                        </button>
                    </form>

                    <br>

                    <span class="is-size-7 mt-1">
                        <?= $isHidden ? '【非表示中】' : '【表示中】' ?>
                    </span><br>

                    <span class="is-size-7">
                        <strong>(ユーザーID：<?= htmlspecialchars($r['account_id']) ?>)</strong>
                    </span>
                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <div class="has-text-right mt-5">
        <a href="book_list.php" class="button is-link">書籍一覧へ</a>
        <a href="super_admin_home.php" class="button is-black">
            <span class="icon mr-1"><i class="fas fa-home"></i></span>
            ホームへ戻る
        </a>
    </div>

</div>
</section>

</body>
</html>