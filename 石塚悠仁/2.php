<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>2.顧客用ログイン画面</title>
</head>
<body>

    <div style="text-align: center;">
        <img src="img/booknest.png" alt="books">    
    </div>
    
    <form action="#" method="post" style="width: 300px; margin: 0 auto; padding: 35px; border: 1px solid #ccc; border-radius: 10px;">
        
        <label for="email">メールアドレス</label><br>
        <input type="email" id="email" name="email" style="width: 100%; padding: 8px; margin-bottom: 15px;border-radius: 5px;"><br>
        
        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="password" style="width: 100%; padding: 8px; margin-bottom: 20px;border-radius: 5px;"><br>
        
        <button type="submit" style="width: 100%; padding: 10px; background-color: #444; color: white; border: none; cursor: pointer;border-radius: 5px;">
            ログイン
        </button>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="#">パスワードを忘れた場合</a>
        </div>
        
    </form>
    
    <div style="width: 300px; margin: 20px auto 0;">
        <a href="#" style="display: block; width: 100%; padding: 12px; background-color: #555; color: white; text-align: center; text-decoration: none;border-radius: 5px;">
            新規登録へ
        </a>
    </div>

</body>
</html>