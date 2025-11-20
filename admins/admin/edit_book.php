<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// URLパラメータから id を取得
$book_id = $_GET['id'] ?? null;

if (!$book_id) {
    echo "IDが指定されていません。";
    exit;
}

// データベースから該当書籍を取得
$sql = "SELECT * FROM books WHERE book_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $book_id, PDO::PARAM_INT);
$stmt->execute();

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo "書籍が見つかりません。";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍編集</title>
</head>
<body>

<h1>書籍の編集</h1>

<form action="update_book_action.php" method="post" enctype="multipart/form-data">

    <!-- 編集対象のID -->
    <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">

    タイトル：<br>
    <input type="text"
           name="title"
           value="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>"
           required><br><br>

    著者：<br>
    <input type="text"
           name="author"
           value="<?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?>"
           required><br><br>

    ジャンル（カンマ区切り）：<br>
    <input type="text"
           name="genre"
           value="<?= htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8') ?>"
           required><br><br>

    価格：<br>
    <input type="number"
           name="price"
           value="<?= $book['price'] ?>"
           required><br><br>

    あらすじ：<br>
    <textarea name="synopsis" rows="5" cols="40" required><?= htmlspecialchars($book['synopsis'], ENT_QUOTES, 'UTF-8') ?></textarea><br><br>

    【現在の表紙画像】：<br>
    <?php if (!empty($book['book_image'])): ?>
        <img src="<?= $book['book_image'] ?>" width="150"><br>
    <?php endif; ?>
    新しい表紙画像（変更する場合のみ）：<br>
    <input type="file" name="book_image" accept="image/*"><br><br>

    【現在のサンプルデータ】：<br>
    <?= htmlspecialchars($book['sample'], ENT_QUOTES, 'UTF-8') ?><br>
    新しいサンプルデータ（変更する場合のみ）：<br>
    <input type="file" name="sample"><br><br>

    【現在の電子書籍】：<br>
    <?= htmlspecialchars($book['e_book'], ENT_QUOTES, 'UTF-8') ?><br>
    新しい電子書籍データ（変更する場合のみ）：<br>
    <input type="file" name="e_book"><br><br>

    販売ステータス：<br>
    <select name="book_status">
        <option value="0" <?= ($book['book_status'] == 0) ? 'selected' : '' ?>>販売中</option>
        <option value="1" <?= ($book['book_status'] == 1) ? 'selected' : '' ?>>停止中</option>
    </select><br><br>

    <button type="submit">更新する</button>

</form>

</body>
</html>