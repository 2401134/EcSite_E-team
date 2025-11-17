<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f9f9f9;
      font-family: sans-serif;
    }

    img {
      width: 170px; 
      margin-bottom: 30px;
    }

    
    .register-container {
      background: white;
      padding: 50px 60px; 
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      width: 420px; /
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      font-size: 15px;
      color: #333;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 14px;
    }

    button {
      margin-top: 30px;
      width: 100%;
      background-color: #000;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      font-size: 15px;
    }

    button:hover {
      background-color: #696969;
    }

    .login-link {
      text-align: center;
      margin-top: 20px;
    }
  
  </style>
</head>
<body>
  <img src="../image/booknest.png" alt="サイトロゴ">

  <div class="register-container">
    <form action="register.php" method="post">
      <label for="email">メールアドレス</label>
      <input type="email" id="email" name="email" required>

      <label for="password">パスワード</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">新規登録</button>
    </form>

    <div class="login-link">
      <p><a href="login.html">ログイン画面へ</a></p>
    </div>
  </div>
</body>
</html>