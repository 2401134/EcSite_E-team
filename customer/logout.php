<?php
session_start();
$_SESSION = [];
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログアウト</title>
  <meta http-equiv="refresh" content="3;URL=login-input.php"> <!-- 3秒後にログインへ -->
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      background-color: #fff;
      font-family: "Yu Gothic", "Hiragino Kaku Gothic ProN", sans-serif;
    }

    .logo img {
      width: 220px; /* ロゴサイズ調整 */
      height: auto;
      margin-bottom: 40px;
    }

    h1 {
      font-size: 36px;       /* 👈 大きく */
      font-weight: bold;     /* 👈 太字 */
      color: #222;
      margin-bottom: 40px;
      letter-spacing: 2px;   /* 少し文字間を広げる */
    }

    a {
      display: inline-block;
      background-color: #222;
      color: #fff;
      padding: 14px 35px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 18px;
      transition: background-color 0.3s, transform 0.2s;
    }

    a:hover {
      background-color: #000;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="logo">
    <img src="../image/booknest.png" alt="ロゴ">
  </div>
  <h1>ログアウトしました。</h1>
  <a href="login-input.php">再ログイン</a>
</body>
</html>
