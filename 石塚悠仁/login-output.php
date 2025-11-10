<?php
session_start();
require 'db-connect.php';
?>

<?php
$user_address = htmlspecialchars($_POST['user_address'], ENT_QUOTES, 'UTF-8');

if (!empty($user_address) && !empty($user_address)) {
    $pdo = new PDO($connect, USER, PASS);

    // メールアドレスが一致するユーザーを取得
    try{
        $sql = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
        $sql->execute([$user_address]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        $_SESSION['alert'] = $e;
        header("Location: login-input.php");
        exit;
    }

    if ($user) {
        // ソルトを取得
        $salt = $user['user_salt'];

        // 入力パス＋ソルトを結合してハッシュ
        $input_hashed = hash('sha256', $_POST['user_password'] . $salt);//ペッパーはのちほど

        // DB上のハッシュと一致チェック
        if ($input_hashed === $user['user_password']) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: home.php");
            exit;
        } else {
            $_SESSION['alert'] = "パスワードが違います。";
            header("Location: login-input.php");
            exit;
        }
    } else {
        $_SESSION['alert'] = "メールアドレスが登録されていません。";
        header("Location: login-input.php");
        exit;
    }
} else {
    $_SESSION['alert'] = "メールアドレスとパスワードが入力されていません。";
    header("Location: login-input.php");
    exit;
}
?>
