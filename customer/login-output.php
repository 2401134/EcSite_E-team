<?php
session_start();
require 'db-connect.php';

$user_address = htmlspecialchars($_POST['user_address'], ENT_QUOTES, 'UTF-8');
$user_password = $_POST['user_password'] ?? '';

if (!empty($user_address) && !empty($user_password)) {
    try {
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
        $sql->execute([$user_address]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $_SESSION['alert'] = "データベースエラー：" . $e->getMessage();
        header("Location: login-input.php");
        exit;
    }

    if ($user) {
        // ソルト取得
        $salt = $user['user_salt'];
        // 入力パス＋ソルトをハッシュ
        $input_hashed = hash('sha256', $user_password . $salt);

        if ($input_hashed === $user['user_password']) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: customer_home.php");
            exit;
        } else {
            //$_SESSION['alert'] = "パスワードが違います。";
            header("Location: login-input.php");
            exit;
        }
    } else {
        //$_SESSION['alert'] = "メールアドレスが登録されていません。";
        header("Location: login-input.php");
        exit;
    }
} else {
    //$_SESSION['alert'] = "メールアドレスとパスワードを入力してください。";
    header("Location: login-input.php");
    exit;
}
