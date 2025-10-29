<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>パスワードリセット</title>
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
      background: #fff;
      padding: 50px 60px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 420px;
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

    p {
      margin-top: 15px;
      font-size: 14px;
      color: #555;
      line-height: 1.6;
    }

    button {
      margin-top: 25px;
      width: 100%;
      background-color: #000;
      color: #fff;
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
  </style>
</head>
<body>
  
  <img src="img/logo.png" alt="サイトロゴ">

  <div class="register-container">
      <label for="email">メールアドレス</label>
      <input type="email" id="email" name="email" required>
      
      <p>
        記入されたメールアドレス宛に、<br>
        パスワード再設定用のURLを送信いたします。
      </p>

      <button type="submit">送信</button>
    </form>  
  </div>
</body>
</html>
