<?php 
session_start();
if (!empty($_SESSION['alert_msg'])) {
    echo "<script>alert('" . $_SESSION['alert_msg'] . "');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
}
?>

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

  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="../../uploads/image/booknest.png" alt="Book Nest ロゴ">
    </div>

    <form class="form-box" action="super_admin_function/insert_admin.php" method="post">
      <label for="admin_name">管理者名</label>
      <input type="text" id="admin_name" name="admin_name" required>

      <label for="employee_id">社員ID</label>
      <input type="text" id="employee_id" name="employee_id" required maxlength="8" pattern="[A-Za-z0-9]+" title="半角英数字(a~z,A~Z,0~9)で8文字以内で入力してください">

      <label for="password">パスワード</label>
      <input type="password" id="admin_password" name="admin_password" required maxlength="255" pattern="[A-Za-z0-9]+">

      <div class="checkbox">
        <input type="checkbox" id="role" name="role" value="1">
        <label for="role">総合管理者権限を付与</label>
      </div>

      <button type="submit">登録</button>
    </form>

    <div class="has-text-right mt-5 mb-5">
    <a href="super_admin_home.php" class="button is-black">
    <span class="icon"><i class="fas fa-home"></i></span>
    <span>ホームに戻る</span>
    </a>
  </div>
  </div>

</body>
</html>
