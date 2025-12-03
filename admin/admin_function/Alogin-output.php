<?php
session_start();
require 'db-connect.php';

$admin_id = htmlspecialchars($_POST['admin_id'], ENT_QUOTES, 'UTF-8');
$admin_password = $_POST['admin_password'] ?? '';

if (!empty($admin_id) && !empty($admin_password)) {
    try {
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->prepare('SELECT * FROM admins WHERE admin_id = ?');
        $sql->execute([$admin_id]);
        $admin = $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $_SESSION['alert_msg'] = $e;
        echo "
            <script>
            window.location.href = 'Alogin-input.php';
            </script>
            ";
        exit;
    }

    if ($admin) {
        if($admin['admin_status'] === 1){
            $_SESSION['alert_msg'] = "IDかパスワードが違います。";
            echo "
            <script>
            window.location.href = 'Alogin-input.php';
            </script>
            ";
            exit;
        }
        // ソルト取得
        $salt = $admin['admin_salt'];
        // 入力パス＋ソルトをハッシュ
        $input_hashed = hash('sha256', $admin_password . $salt);

        if ($input_hashed === $admin['admin_password']) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            header("Location: admin_home.php");
            exit;
        } else {
            $_SESSION['alert_msg'] = "IDかパスワードが違います。";
            echo "
            <script>
            window.location.href = 'Alogin-input.php';
            </script>
            ";
            exit;
        }
    } else {
        $_SESSION['alert_msg'] = "IDかパスワードが違います。";
        echo "
            <script>
            window.location.href = 'Alogin-input.php';
            </script>
            ";
        exit;
    }
} else {
    $_SESSION['alert_msg'] = "入力してください。";
    echo "
        <script>
        window.location.href = 'Alogin-input.php';
        </script>
        ";
    exit;
}
