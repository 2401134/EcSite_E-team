<?php
require 'db-connect.php';

if (!isset($_POST['user_id'])) {
    http_response_code(404);
    exit;
}

$user_id = $_POST['user_id'];

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 現在のステータス取得
    $stmt = $pdo->prepare("SELECT user_status FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $status = $stmt->fetchColumn();

    if ($status === false) {
        $_SESSION['alert_msg'] = '管理者が見つかりません';
        header("Location: ../user_manage.php");
        exit;
    }

    // 0 → 1（停止）、1 → 0（回復）
    $new_status = ($status == 0) ? 1 : 0;

    $update = $pdo->prepare("UPDATE users SET user_status = ? WHERE user_id = ?");
    $update->execute([$new_status, $user_id]);

    // 元のページに戻る
    header("Location: ../user_manage.php");
    exit;

    } catch (PDOException $e) {
    $_SESSION['alert_msg'] = '管理者が見つかりません';
    header("Location: ../user_manage.php");
    exit;
}
