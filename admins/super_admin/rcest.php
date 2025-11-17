<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理者登録 | Book Nest</title>
  <style>
    body {
      font-family: "Yu Gothic", "Hiragino Kaku Gothic ProN", sans-serif;
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      display: flex;
      flex-direction: column; 
      align-items: center;
      justify-content: center;
      gap: 30px; 
    }

    .logo img {
      width: 160px; 
      height: auto;
      display: block;
    }

    .form-box {
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 30px 40px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      width: 350px;
      background-color: #fff;
    }

    .form-box label {
      display: block;
      font-size: 15px;
      margin-bottom: 6px;
      font-weight: bold;
    }

    .form-box input[type="text"],
    .form-box input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 18px;
      font-size: 15px;
    }

    .form-box .checkbox {
      margin-bottom: 20px;
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-box input[type="checkbox"] {
      width: 16px;
      height: 16px;
    }

    .form-box button {
      width: 100%;
      background-color: #222;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form-box button:hover {
      background-color: #000;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="images/logo.png" alt="Book Nest ロゴ">
    </div>

    <form class="form-box" action="insert-admin.php" method="post">
      <label for="admin_name">管理者名</label>
      <input type="text" id="admin_name" name="admin_name" required>

      <label for="employee_id">社員ID</label>
      <input type="text" id="employee_id" name="employee_id" required>

      <label for="password">パスワード</label>
      <input type="password" id="password" name="password" required>

      <div class="checkbox">
        <input type="checkbox" id="role" name="role" value="1">
        <label for="role">総合管理者権限を付与</label>
      </div>

      <button type="submit">登録</button>
    </form>
  </div>
</body>
</html>
