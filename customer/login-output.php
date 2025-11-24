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
        $_SESSION['alert_msg'] = $e;
        echo "
            <script>
            window.location.href = 'login-input.php';
            </script>
            ";
        exit;
    }

    if ($user) {
        if($user['user_status'] === 1){
            $_SESSION['alert_msg'] = "メールアドレスかパスワードが違います。";
            echo "
            <script>
            window.location.href = 'login-input.php';
            </script>
            ";
            exit;
        }
        // ソルト取得
        $salt = $user['user_salt'];
        // 入力パス＋ソルトをハッシュ
        $input_hashed = hash('sha256', $user_password . $salt);

        if ($input_hashed === $user['user_password']) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: customer_home.php");
            exit;
        } else {
            $_SESSION['alert_msg'] = "メールアドレスかパスワードが違います。";
            echo "
            <script>
            window.location.href = 'login-input.php';
            </script>
            ";
            exit;
        }
    } else {
        $_SESSION['alert_msg'] = "メールアドレスかパスワードが違います。";
        echo "
            <script>
            window.location.href = 'login-input.php';
            </script>
            ";
        exit;
    }
} else {
    $_SESSION['alert_msg'] = "入力してください。";
    echo "
        <script>
        window.location.href = 'login-input.php';
        </script>
        ";
    exit;
}
