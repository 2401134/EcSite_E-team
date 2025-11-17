<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍登録</title>
</head>
<body>

<h1>書籍の新規登録</h1>

<form action="admin_function/add_book_action.php" method="post" enctype="multipart/form-data">
    タイトル：<br>
    <input type="text" name="title" required><br><br>

    著者：<br>
    <input type="text" name="author" required><br><br>

    ジャンル(複数は , 区切り)：<br>
    <input type="text" name="genre" required><br><br>

    価格：<br>
    <input type="number" name="price" required><br><br>

    あらすじ：<br>
    <textarea name="synopsis" rows="5" cols="40" required></textarea><br><br>

    表紙画像：<br>
    <input type="file" name="book_image" accept="image/*" required><br><br>

    サンプルデータ(PDF等)：<br>
    <input type="file" name="sample" required><br><br>

    電子書籍データ(PDF等)：<br>
    <input type="file" name="e_book" required><br><br>

    <button type="submit">登録する</button>
</form>

</body>
</html>