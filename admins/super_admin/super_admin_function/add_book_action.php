<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ---- 入力受け取り ----
$title    = $_POST['title'] ?? '';
$author   = $_POST['author'] ?? '';
$genre    = $_POST['genre'] ?? '';
$price    = $_POST['price'] ?? 0;
$synopsis = $_POST['synopsis'] ?? '';


// ---- ファイルアップロード処理 ----
function uploadFile($file, $dir) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // 保存先ディレクトリがなければ作成
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $ext;
    $path = $dir . "/" . $filename;

    move_uploaded_file($file['tmp_name'], $path);

    return $path; // DBには保存先パスを保存
}

$book_image_path = uploadFile($_FILES['book_image'], 'uploads/book_images');
$sample_path      = uploadFile($_FILES['sample'], 'uploads/samples');
$ebook_path       = uploadFile($_FILES['e_book'], 'uploads/ebooks');


// ---- SQL登録 ----
$sql = "INSERT INTO books
        (title, author, genre, price, synopsis, book_image, sample, e_book, register_date, book_status)
        VALUES
        (:title, :author, :genre, :price, :synopsis, :book_image, :sample, :e_book, NOW(), 0)";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':title', $title);
$stmt->bindValue(':author', $author);
$stmt->bindValue(':genre', $genre);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':synopsis', $synopsis);
$stmt->bindValue(':book_image', $book_image_path);
$stmt->bindValue(':sample', $sample_path);
$stmt->bindValue(':e_book', $ebook_path);

$stmt->execute();

// 完了メッセージ
echo "書籍の登録が完了しました！<br>";
echo '<a href="../add_book.php">戻る</a>';