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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード変更画面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            width: 300px;
            padding: 35px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo-area {
            text-align: center;
            margin-bottom: 30px; 
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .btn {
            width: 100%; 
            padding: 10px; 
            background-color: #444; 
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            display: block;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box; 
        }
        
        .btn-top {
            margin-top: 15px;
            margin-bottom: 10px;
        }
        
        .btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

    <div style="text-align: center;">
        <img src="../image/booknest.png"  width="100px" height="100px" alt="books">    
    </div>
    
    <?php if ($error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php elseif ($success): ?>
        <p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
    <?php else: ?>
        <form action="pass-change.php?id=<?= htmlspecialchars($url_token, ENT_QUOTES, 'UTF-8') ?>" class="form-container" method="post">
            認証コード<br>
            <input type="text" name="code" required><br>
                新しいパスワード<br>
            <input type="password" name="pass" required><br>
            <button type="submit" class="btn btn-top">
                パスワード変更
            </button>
            <a href="login-input.php" class="btn">
                ログイン画面へ戻る
            </a>
        </form>
    <?php endif; ?>

</body>
</html>