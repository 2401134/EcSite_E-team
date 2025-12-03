<?php
require 'db-connect.php';

if(!isset($_POST['admin_id'])){
    http_response_code(404);
    exit;
}

$admin_id = $_POST['admin_id'];

// DB接続
$pdo = new PDO($connect, USER, PASS);

// 現在の super_admin 状態を取得
$stmt = $pdo->prepare("SELECT super_admin FROM admins WHERE admin_id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

if (!$admin) {
    $_SESSION['alert_msg'] = '管理者が見つかりません';
    header("Location: ../admin_manage.php");
    exit;
}

$current = $admin['super_admin'];

// super_admin の反転（0→1、1→0）
$new_status = ($current == 0) ? 1 : 0;

// 値を更新
$update = $pdo->prepare("UPDATE admins SET super_admin = ? WHERE admin_id = ?");
$update->execute([$new_status, $admin_id]);

// 元の画面に戻る
header("Location: ../admin_manage.php");
exit();
?>
