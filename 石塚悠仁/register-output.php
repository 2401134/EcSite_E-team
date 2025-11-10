<?php
session_start();
require 'db-connect.php';
?>
<?php

$user_address = htmlspecialchars($_POST['user_address'], ENT_QUOTES, 'UTF-8');

// ソルト生成関数
function generateSalt($length = 16) {
    return bin2hex(random_bytes($length));
}

// 現在日時を取得
$now = date('Y-m-d H:i:s');

// 入力チェック
if (!empty($user_address) && !empty($_POST['user_password'])) {

    $pdo = new PDO($connect, USER, PASS);

    // すでに同じメールが登録されていないか確認
    try{$sql = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
        $sql->execute([$user_address]);
        if ($sql->fetch()) {
            $_SESSION['alert'] = "このメールアドレスは既に登録されています。";
            exit;
        }
    }catch(PDOException $e){
        //$_SESSION['alert'] = $e;
        header("Location: login-input.php");
        exit;
    }

    // ソルト・ペッパー生成
    $salt = generateSalt();
    //$pepperも入るならここ

    // パスワードハッシュ化（パスワード + ソルト + ペッパー）
    $hashed = hash('sha256', $_POST['user_password'] . $salt);// . $pepper

    // usersテーブルへ登録
    $sql = $pdo->prepare('INSERT INTO users (account_id, user_name, user_address, account_name, user_salt, user_password, sign_up_date, user_status) VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?)');
    $sql->execute(['未登録', $user_address, '未登録', $salt, $hashed, $now, 0]);

    // 登録されたユーザーIDを取得
    $user_id = $pdo->lastInsertId();

    // user_logsテーブルへ記録
    $log_sql = $pdo->prepare('INSERT INTO user_logs (user_id, target_table, target_id, user_action, log_date) VALUES (?, ?, ?, ?, ?)');
    $log_sql->execute([$user_id, 'users', $user_id, '新規登録', $now]);

    // セッションに保存
    $_SESSION['user_id'] = $user_id;

    header("Location: login-input.php");
    exit;

} else {
    //$_SESSION['alert'] = "入力してください。";
    header("Location: register-input.php");
    exit;
}
?>
