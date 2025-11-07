<?php
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3.顧客用ログアウト画面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            padding: 50px;
            width: 350px;
            max-width: 90%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); 
        }
        .logo {
            font-family: serif;
            font-size: 28px;
            font-style: italic;
            color: #333;
            margin-bottom: 50px;
        }
        .message {
            font-size: 20px;
            margin-bottom: 40px;
            font-weight: bold;
        }
        .re-login-btn {
            padding: 12px 30px;
            background-color: #404040;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }
        .re-login-btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
    <div style="text-align: center;">
        <img src="img/booknest.png" alt="books">    
    </div>

        <p class="message">
            ログアウトしました。
        </p>

        <a href="login-input.php" class="re-login-btn">
            再ログイン
        </a>
    </div>

</body>
</html>