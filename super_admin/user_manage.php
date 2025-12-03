<?php
require 'db-connect.php';

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユーザー一覧
    $stmt = $pdo->query("SELECT * FROM users ORDER BY user_id ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    exit("データベース接続失敗: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>


<?php require 'menu.php'; ?>

<section class="section">
    <div class="container">
        <h1 class="title">ユーザー管理</h1>

        <?php foreach ($users as $user): ?>
            <div class="box user-info">
                <div class="columns is-vcentered mb-2">
                    <span class="icon is-large has-text-grey" style="border:1px solid #4a4a4a;border-radius:45%;padding:2em;">
                        <i class="fas fa-user fa-2x"></i>
                    </span>

                    <div class="column is-narrow">
                        <strong><?= htmlspecialchars($user['user_name']) ?></strong>
                    </div>
                    <div class="column is-narrow">
                        <small><?= htmlspecialchars($user['account_id']) ?></small>
                    </div>
                </div>

                <div class="history_browse is-flex is-justify-content-flex-end">

                    <!-- 購入履歴 -->
                    <form action="../admin/purchase_history.php" method="post" class="mr-4">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <button type="submit" class="button is-normal is-light">
                            <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                            <span>購入履歴</span>
                        </button>
                    </form>

                    <!-- レビュー履歴 -->
                    <form action="../user_review_manage.php" method="post" class="mr-4">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                        <button class="button is-normal is-light">
                            <span class="icon"><i class="fas fa-comment-dots"></i></span>
                            <span>レビュー履歴</span>
                        </button>
                    </form>

                    <!-- ★ アカウント停止 / 回復 ボタン（user_statusで切替） -->
                    <form action="super_admin_function/authority_user.php" method="post">
                        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                        <?php if ($user['user_status'] == 0): ?>
                            <button type="submit" class="button is-normal is-danger">
                                <span class="icon"><i class="fas fa-ban"></i></span>
                                <span>アカウントを停止</span>
                            </button>
                        <?php else: ?>
                            <button type="submit" class="button is-normal is-success">
                                <span class="icon"><i class="fas fa-undo"></i></span>
                                <span>アカウントを有効</span>
                            </button>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="has-text-right mt-5">
            <a href="super_admin_home.php" class="button is-black">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span>ホームに戻る</span>
            </a>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
</body>
</html>
