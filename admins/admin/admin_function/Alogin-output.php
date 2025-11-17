<?php
session_start();
require 'db-connect.php';

$admin_address = htmlspecialchars($_POST['admin_id'], ENT_QUOTES, 'UTF-8');
$admin_password = $_POST['admin_password'] ?? '';

if (!empty($admin_id) && !empty($admin_password)) {
    try {
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->prepare('SELECT * FROM admins WHERE admin_id = ?');
        $sql->execute([$admin_id]);
        $admin = $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        header("Location: Alogin-input.php");
        exit;
    }

    if ($admin) {
        if($admin['admin_status'] === 1){
            header("Location: Alogin-input.php");
            exit;
        }
        // ソルト取得
        $salt = $admin['admin_salt'];
        // 入力パス＋ソルトをハッシュ
        $input_hashed = hash('sha256', $admin_password . $salt);

        if ($input_hashed === $admin['admin_password']) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            header("Location: home.php");
            exit;
        } else {
            header("Location: Alogin-input.php");
            exit;
        }
    } else {
        header("Location: Alogin-input.php");
        exit;
    }
} else {
    header("Location: Alogin-input.php");
    exit;
}
