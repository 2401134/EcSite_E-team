<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// URLに含まれるトークン
$url_token = $_GET['id'] ?? null;

// エラーメッセージ用
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code = $_POST['code'] ?? '';
    $new_pass = $_POST['pass'] ?? '';

    // トークンがURLに存在しない
    if (!$url_token || !$code || !$new_pass) {
        $error = '認証に失敗しました。もう一度お試しください。エラー1';
    } else {

        try {
            $sql = "SELECT * FROM password_resets WHERE used = 0 AND reset_limit >= NOW()";
            $stmt = $pdo->query($sql);
            $resets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $reset = null;
            
            foreach ($resets as $i) {
                if (password_verify($url_token, $i['url_token'])) {
                    $reset = $i;
                    break;
                }
            }

            if ($reset && password_verify($code, $reset['token'])) {

                //トランザクション開始
                $pdo->beginTransaction();

                // 新しいソルトとパスワードを生成
                function generateSalt($length = 32) {
                    return bin2hex(random_bytes($length / 2));
                }

                $salt = generateSalt();
                $hashed = hash('sha256', $new_pass . $salt);

                //usersテーブルを更新
                $update_user = $pdo->prepare('UPDATE users SET user_password = ?, user_salt = ? WHERE user_id = ?');
                $update_user->execute([$hashed, $salt, $reset['user_id']]);

                //password_resetsを使用済みにする
                $update_reset = $pdo->prepare('UPDATE password_resets SET used = 1 WHERE reset_id = ?');
                $update_reset->execute([$reset['reset_id']]);

                //user_logsに記録
                $insert_log = $pdo->prepare('INSERT INTO user_logs (user_id, target_table, target_id, user_action, log_date)
                                             VALUES (?, ?, ?, ?, NOW())');
                $insert_log->execute([
                    $reset['user_id'],
                    'users',
                    $reset['user_id'],
                    'パスワード変更'
                ]);

                $pdo->commit();
                $success = 'パスワードを変更しました。ログイン画面から新しいパスワードでログインしてください。';

            } else {
                // トークン不一致、コード不一致、有効期限切れ すべて共通メッセージ
                $error = '認証に失敗しました。もう一度お試しください。エラー2';
            }

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = '処理中にエラーが発生しました。時間をおいて再度お試しください。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワードリセット</title>
</head>
<body>
    <h2>パスワードリセット</h2>

    <?php if ($error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php elseif ($success): ?>
        <p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
    <?php else: ?>
        <form action="reset.php?id=<?= htmlspecialchars($url_token, ENT_QUOTES, 'UTF-8') ?>" method="post">
            認証コード<br>
            <input type="text" name="code" required><br><br>
            新しいパスワード<br>
            <input type="password" name="pass" required><br><br>
            <input type="submit" value="パスワード変更">
        </form>
    <?php endif; ?>
</body>
</html>