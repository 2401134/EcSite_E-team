<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 検索機能（必要なければ削除OK）
$keyword = $_GET['keyword'] ?? '';

// 全件 or 部分一致検索
if ($keyword === '') {
    $sql = "SELECT * FROM books ORDER BY register_date DESC";
    $stmt = $pdo->query($sql);
} else {
    $sql = "SELECT * FROM books 
            WHERE title LIKE :kw 
               OR author LIKE :kw
               OR genre LIKE :kw
            ORDER BY register_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':kw', '%' . $keyword . '%');
    $stmt->execute();
}

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍一覧</title>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    padding: 8px;
    border-bottom: 1px solid #ccc;
}
</style>
</head>
<body>

<h1>書籍一覧</h1>

<!-- 検索フォーム（必要に応じて削除可能） -->
<form method="get">
    検索：<input type="text" name="keyword" value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
    <button type="submit">検索</button>
</form>

<br>

<table>
    <tr>
        <th>ID</th>
        <th>タイトル</th>
        <th>著者</th>
        <th>価格</th>
        <th>ステータス</th>
        <th>登録日</th>
        <th>編集</th>
    </tr>

    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= $book['book_id'] ?></td>
        <td><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?></td>
        <td><?= $book['price'] ?>円</td>
        <td>
            <?= $book['book_status'] == 0 ? '販売中' : '停止中' ?>
        </td>
        <td><?= $book['register_date'] ?></td>
        <td>
            <a href="../edit_book.php?id=<?= $book['book_id'] ?>">編集</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>