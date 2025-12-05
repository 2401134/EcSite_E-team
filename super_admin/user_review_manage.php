<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ------------------------------
// GET: user_id を受け取る
// ------------------------------
$user_id = $_GET['user_id'] ?? '';

if ($user_id === '' || !ctype_digit($user_id)) {
    echo "不正な user_id です。";
    exit;
}

// ------------------------------
// レビュー一覧取得（該当ユーザーのみ）
// ------------------------------
$sql = "
    SELECT r.*, u.user_name, u.account_id, b.title, b.author, b.book_image
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    JOIN books b ON b.book_id = r.book_id
    WHERE r.user_id = :uid
    ORDER BY r.upload_date DESC
";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":uid", $user_id, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ------------------------------
// 表示 / 非表示 トグル処理
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

    // 更新後に自ページへ戻る
    header("Location: user_review_manage.php?user_id=" . urlencode($user_id));
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
    <title>ユーザーレビュー管理</title>

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

    <h1 class="title">ユーザー「<?= htmlspecialchars($user_id) ?>」のレビュー一覧</h1>

    <?php if (empty($reviews)): ?>
        <p>このユーザーのレビューはありません。</p>

    <?php else: ?>
        <?php foreach ($reviews as $r): ?>
            <?php $isHidden = ((int)$r['review_status'] === 1); ?>

            <div class="box review-card <?= $isHidden ? 'review-hidden' : '' ?>">

                <!-- 書籍情報 -->
                <div class="book-label">
                    <strong>[対象書籍]</strong>
                    <?= htmlspecialchars($r['title']) ?>（<?= htmlspecialchars($r['author']) ?>）
                </div>

                <br>

                <!-- ユーザーアイコン + 星評価 -->
                <span class="icon is-large has-text-grey"
                      style="border: 1px solid #4a4a4a; border-radius:45%; padding:2em;">
                    <i class="fas fa-user fa-2x"></i>
                </span>

                <span><?= starRating((int)$r['review_rank']) ?></span>

                <br>

                <p class="has-text-centered">
                    <strong><?= htmlspecialchars($r['comment_text']) ?></strong>
                </p>

                <!-- 投稿日 -->
                <div class="is-size-7 mb-2">
                    投稿日：<?= htmlspecialchars($r['upload_date']) ?>
                </div>

                <!-- レビューの表示 / 非表示ボタン -->
                <div class="review-delete has-text-right">

                    <form action="user_review_manage.php?user_id=<?= urlencode($user_id) ?>"
                          method="POST" style="display:inline;">
                        <input type="hidden" name="toggle_review_id" value="<?= $r['review_id'] ?>">
                        <input type="hidden" name="current_status" value="<?= $r['review_status'] ?>">

                        <button class="button is-light is-rounded">
                            <span class="icon"><i class="fas fa-trash"></i></span>
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
        <a href="user_manage.php" class="button is-link">ユーザー一覧へ</a>
        <a href="admin_home.php" class="button is-black">
            <span class="icon"><i class="fas fa-home"></i></span>
            ホームへ戻る
        </a>
    </div>

</div>
</section>

</body>
</html>