<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>パスワードリセット</title>
  <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
  
  <img src="../image/booknest.png" alt="サイトロゴ">

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

    <div class="columns mb-4">
      <div class ="column">
        <form action="customer_home.php" method="POST" class="mt-2 mr-2">
          <input type="hidden" name="action" value="home">
          <button class="button is-dark is-normal">
            <span class="icon"><i class="fas fa-home"></i></span>
            <span>ホームに戻る</span>
          </button>
        </form>
      </div>
    </div>

</body>
</html>
