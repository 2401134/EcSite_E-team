<?php
session_start();
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ユーザー一覧取得（account_id 追加）
$sql = "SELECT user_id, user_name, account_id FROM users ORDER BY user_id ASC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .user-icon {
            border: 1px solid #4a4a4a;
            border-radius: 45%;
            padding: 1.4em 1.6em;
        }
        .history_browse form {
            display: inline-block;
        }
    </style>
</head>

<body>

<?php require 'menu.php'; ?>

<section class="section">
    <div class="container">
        <h1 class="title">ユーザー管理</h1>

        <?php foreach ($users as $user): ?>
            <div class="box user-info">
                <div class="columns is-vcentered mb-2">

                    <!-- ユーザーアイコン -->
                    <div class="column is-narrow">
                        <span class="icon is-large has-text-grey user-icon">
                            <i class="fas fa-user fa-2x"></i>
                        </span>
                    </div>

                    <!-- ユーザー名・account_id 表示 -->
                    <div class="column is-narrow">
                        <strong><?= htmlspecialchars($user['user_name']) ?></strong>
                    </div>

                    <div class="column is-narrow">
                        <small>(ID：<?= htmlspecialchars($user['account_id']) ?>)</small>
                    </div>

                </div>

                <!-- 購入履歴 / レビュー履歴 ボタン -->
                <div class="history_browse is-flex is-justify-content-flex-end">

                    <!-- 購入履歴 -->
                    <form action="purchase_history.php" method="get" class="mr-4">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <button class="button is-light">
                            <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                            <span>購入履歴</span>
                        </button>
                    </form>

                    <!-- レビュー履歴 -->
                    <form action="user_review_manage.php" method="get">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <button class="button is-light">
                            <span class="icon"><i class="fas fa-comment-dots"></i></span>
                            <span>レビュー履歴</span>
                        </button>
                    </form>

                </div>
            </div>
        <?php endforeach; ?>

        <!-- ホームへ戻る -->
        <div class="has-text-right mt-5">
            <a href="admin_home.php" class="button is-black">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span>ホームに戻る</span>
            </a>
        </div>

    </div>
</section>

<?php require 'footer.php'; ?>

</body>
</html>