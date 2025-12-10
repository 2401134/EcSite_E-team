<?php
session_start();
require 'db-connect.php';

// アラート（1回だけ表示）
if (!empty($_SESSION['alert_msg'])) {
    echo "<script>alert('" . $_SESSION['alert_msg'] . "');</script>";
    unset($_SESSION['alert_msg']); 
}

// ログインチェック
if (!isset($_SESSION['admin_id'])) {
    http_response_code(404);
    exit;
}

// super_admin チェック（0 が総合管理者）
if (!isset($_SESSION['super_admin']) || $_SESSION['super_admin'] != 0) {
    echo '<script>
          alert("総合管理者の権限がありません");
          history.back();
          </script>';
    exit;
}

// user_id チェック
if (!isset($_GET['user_id'])) {
    echo "<script>alert('ユーザーIDがありません'); history.back();</script>";
    exit;
}

$user_id = $_GET['user_id'];

// DB 接続
$pdo = new PDO($connect, USER, PASS);

// 購入履歴取得
$sql = "SELECT p.*, b.title, b.synopsis, b.book_image
        FROM purchases p
        JOIN books b ON p.book_id = b.book_id
        WHERE p.user_id = ?
        ORDER BY p.purchase_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入履歴</title>

    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php require 'menu.php'; ?>

<section class="section">
<div class="container">

<h1 class="title is-left">このユーザーの購入履歴</h1>

<?php if(empty($history)): ?>
    <p>購入履歴はありません。</p>

<?php else: ?>
    <?php foreach ($history as $row): ?>

        <div class="box">
            <div class="columns is-vcentered">

                <!-- 左：表紙画像 -->
                <div class="column is-narrow">
                    <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
                        <img src="<?= htmlspecialchars($row['book_image'] ?: 'images/noimage.jpg', ENT_QUOTES) ?>" alt="表紙">
                    </figure>
                </div>

                <!-- 中央：本の情報 -->
                <div class="column">
                    <p class="title is-6"><?= htmlspecialchars($row['title'], ENT_QUOTES) ?></p>
                    <p class="subtitle is-7"><?= htmlspecialchars($row['synopsis'], ENT_QUOTES) ?></p>
                </div>

                <!-- 右：価格・日時 -->
                <div class="column is-narrow">
                    <div class="has-text-weight-bold mb-2">
                        <?= number_format($row['price']) ?>円
                    </div>

                    <div class="has-text-grey is-size-7">
                        <?= htmlspecialchars($row['purchase_date'], ENT_QUOTES) ?>
                    </div>
                </div>

            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>

<div class="has-text-right mt-5">
    <a href="user_manage.php" class="button is-link">ユーザー一覧へ</a>
    <a href="super_admin_home.php" class="button is-black">
        <span class="icon"><i class="fas fa-home"></i></span>
        ホームへ戻る
    </a>
</div>

</div>
</section>

</body>
</html>
