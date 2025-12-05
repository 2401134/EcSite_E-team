<?php
session_start();
require 'db-connect.php';

// フォームから値を取得
$pdo = new PDO($connect, USER, PASS);
$admin_name     = $_POST['admin_name'];
$admin_password = $_POST['admin_password'];
$employee_id    = $_POST['employee_id'];
$role           = isset($_POST['role']) ? 1 : 0; // チェックされていたら 1

$check = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE employee_id = ?");
$check->execute([$employee_id]);
$count = $check->fetchColumn();

if ($count > 0) {
    // 同じ employee_id が存在 → 登録拒否
    $_SESSION['alert_msg'] = "登録に失敗しました。";
    header("Location: ../rcest.php");
    exit();
}

// --- super_admin の判定 ---
// チェックなし → super_admin = 1
// チェックあり → super_admin = 0
$super_admin = ($role == 1) ? 0 : 1;

// --- パスワードハッシュ用のソルト作成 ---
$salt = bin2hex(random_bytes(16)); // 32文字
$hashed_password = hash('sha256', $admin_password . $salt);

// データベースへINSERT
$sql = "INSERT INTO admins 
        (admin_name, admin_password, admin_salt, sign_up_date, super_admin, admin_status, employee_id)
        VALUES 
        (?, ?, ?, NOW(), ?, 0, ?)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $admin_name,
        $hashed_password,
        $salt,
        $super_admin,
        $employee_id
    ]);

    //admin_logsに追加
    $admin_id = $pdo->prepare("SELECT admin_id FROM admins WHERE employee_id = ?");
    $admin_id->execute([$_SESSION['employee_id']]);//操作している管理者ID

    $new_admin = $pdo->prepare("SELECT admin_id FROM admins WHERE employee_id = ?");
    $new_admin->execute([$employee_id]);//新しく追加された管理者ID

    $sql = "INSERT INTO admin_logs 
        (admin_id, target_table, target_id, admin_action, log_date)
        VALUES 
        ($)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $admin_id,
        "admins",
        $new_admin,
        "新規管理者の追加",
        now()
    ])

    // 登録成功 → ホームへ移動
    $_SESSION['alert_msg'] = "登録しました";
    header("Location: ../admin_manage.php");
    exit();

} catch (Exception $e) {

    // エラー内容をセッションに入れてもよい
    $_SESSION['alert_msg'] = "登録に失敗しました: " . $e->getMessage();
    header("Location: ../rcest.php"); // エラー時は戻す
    exit();
}
?>
