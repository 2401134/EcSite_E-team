<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5.パスワード変更画面</title>
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
        }
        .form-container {
            width: 300px;
            padding: 35px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo-area {
            text-align: center;
            margin-bottom: 30px; 
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .btn {
            width: 100%; 
            padding: 10px; 
            background-color: #444; 
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            display: block;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box; 
        }
        
        .btn-top {
            margin-top: 15px;
            margin-bottom: 10px;
        }
        
        .btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

    <div style="text-align: center;">
        <img src="img/booknest.png" alt="books">    
    </div>
    
    <form action="#" method="post" class="form-container">
        
        <label for="code">認証コード</label>
        <input type="text" id="code" name="code" required>
        
        <label for="password">新しいパスワード</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit" class="btn btn-top">
            パスワード変更
        </button>
        
        <a href="login.html" class="btn">
            ログイン画面へ戻る
        </a>
        
    </form>

</body>
</html>