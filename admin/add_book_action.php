<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ---- 入力 ----
$title    = trim($_POST['title'] ?? '');
$author   = trim($_POST['author'] ?? '');
$genre    = trim($_POST['genre'] ?? '');
$price    = $_POST['price'] ?? 0;
$synopsis = trim($_POST['synopsis'] ?? '');


// ---- 必須チェック（サンプル以外）----
$errors = [];

if ($title === '')     $errors[] = "タイトルは必須です。";
if ($author === '')    $errors[] = "著者は必須です。";
if ($genre === '')     $errors[] = "ジャンルは必須です。";
if ($price === '' || !is_numeric($price))  $errors[] = "価格は必須です。";
if ($synopsis === '')  $errors[] = "あらすじは必須です。";

// 表紙・電子書籍ファイルの必須チェック
if ($_FILES['book_image']['error'] === UPLOAD_ERR_NO_FILE) 
    $errors[] = "表紙画像は必須です。";

if ($_FILES['book_e-book']['error'] === UPLOAD_ERR_NO_FILE) 
    $errors[] = "電子書籍データは必須です。";

if (!empty($errors)) {
    foreach ($errors as $e) echo $e . "<br>";
    echo '<a href="add_book.php">戻る</a>';
    exit;
}


// ---- ファイルアップロード処理 ----
function uploadFile($file, $dir) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $ext;
    $path = $dir . "/" . $filename;

    move_uploaded_file($file['tmp_name'], $path);
    return $path;
}


// 正しいキー名に修正！（重要）
$book_image_path = uploadFile($_FILES['book_image'], '../uploads/book_images');
$ebook_path      = uploadFile($_FILES['book_e-book'], '../uploads/ebooks');

// サンプルは任意 → アップされてなければ固定の準備中PDF
if ($_FILES['book_sample']['error'] === UPLOAD_ERR_NO_FILE) {
    $sample_path = '../uploads/samples/preparation.pdf';
} else {
    $sample_path = uploadFile($_FILES['book_sample'], '../uploads/samples');
}


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

echo "書籍の登録が完了しました！<br>";
echo '<a href="add_book.php">戻る</a>';