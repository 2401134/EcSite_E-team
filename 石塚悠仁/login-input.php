<?php
session_start();

//if (isset($_SESSION["alert"])) {
//    $message = $_SESSION["alert"];
//    unset($_SESSION["alert"]);
//}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>BOOK NEST ログイン</title>

</head>
<body>

    <div style="text-align: center;">
        <img src="../image/booknest.png" width="100px" height="100px" alt="books">    
    </div>

    <form action="login-output.php" method="post" style="width: 300px; margin: 0 auto; padding: 35px; border: 1px solid #ccc; border-radius: 10px;">
        
        <label for="email">メールアドレス</label><br>
        <input type="email" id="email" name="user_address" style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px;"><br>
        
        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="user_password" style="width: 100%; padding: 8px; margin-bottom: 20px; border-radius: 5px;"><br>
        
        <button type="submit" style="width: 100%; padding: 10px; background-color: #444; color: white; border: none; cursor: pointer; border-radius: 5px;">
            ログイン
        </button>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="#">パスワードを忘れた場合</a>
        </div>
        
    </form>
    
    <div style="width: 300px; margin: 20px auto 0;">
        <a href="#" style="display: block; width: 100%; padding: 12px; background-color: #555; color: white; text-align: center; text-decoration: none; border-radius: 5px;">
            新規登録へ
        </a>
    </div>

</body>
</html>
