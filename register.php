<?php
session_start();
require 'db-connect.php';
require 'header.php';
?>
<?php
// UUID生成関数
function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// ソルト生成関数
function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
}

// 現在日時を取得
$now = date('Y-m-d H:i:s');

// 入力チェック
if (!empty($_POST['user_address']) && !empty($_POST['user_password'])) {

    $pdo = new PDO($connect, USER, PASS);

    // すでに同じメールが登録されていないか確認
    $sql = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
    $sql->execute([$_POST['user_address']]);
    if ($sql->fetch()) {
        echo '<p>このメールアドレスはすでに登録されています。</p>';
        require 'footer.php';
        exit;
    }

    // UUID・ソルト・ペッパー生成
    $uuid = generateUUID();
    $salt = generateSalt();
    //$pepperも入るならここ

    // パスワードハッシュ化（パスワード + ソルト + ペッパー）
    $hashed = hash('sha256', $_POST['user_password'] . $salt);// . $pepper

    // usersテーブルへ登録
    $sql = $pdo->prepare('INSERT INTO users (account_id, user_name, user_address, account_name, user_salt, user_password, sign_up_date, user_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $sql->execute([$uuid, '未登録', $_POST['user_address'], '未登録', $salt, $hashed, $now, 0]);

    // 登録されたユーザーIDを取得
    $user_id = $pdo->lastInsertId();

    // user_logsテーブルへ記録
    $log_sql = $pdo->prepare('INSERT INTO user_logs (user_id, target_table, target_id, user_action, log_date) VALUES (?, ?, ?, ?, ?)');
    $log_sql->execute([$user_id, 'users', $user_id, '新規登録', $now]);

    // セッションに保存
    $_SESSION['user_id'] = $user_id;

    echo '<p>登録が完了しました。ログイン画面へ移動します。</p>';
    echo '<meta http-equiv="refresh" content="1;URL=login-input.php">';

} else {
    header("Location: register-input.php?error=" . urlencode("すべて入力してください。"));
}
?>
