<?php
session_start();

if (isset($_SESSION["alert_msg"])) {
    echo '<script>alert("' . $_SESSION['alert_msg'] . '");</script>';
    unset($_SESSION["alert_msg"]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>7.管理者用ログイン画面</title>
</head>
<body>

    <div style="text-align: center;">
        <img src="../../uploads/image/booknest.png" alt="books" style="max-width: 200px; height: auto;">    
    </div>
    
    <form action="admin_function/Alogin-output.php" method="post" style="width: 300px; margin: 0 auto; padding: 35px; border: 1px solid #ccc; border-radius: 10px;">
        
        <label for="id">社員ID</label><br>
        <input type="text" id="id" name="admin_id" style="width: 100%; padding: 8px; margin-bottom: 15px;border-radius: 5px;"><br>
        
        <label for="admin_password">パスワード</label><br>
        <input type="password" id="password" name="admin_password" style="width: 100%; padding: 8px; margin-bottom: 20px;border-radius: 5px;"><br>
        
        <button type="submit" style="width: 100%; padding: 10px; background-color: #444; color: white; border: none; cursor: pointer;border-radius: 5px;">
            ログイン
        </button>
        
    </form>

</body>
</html>