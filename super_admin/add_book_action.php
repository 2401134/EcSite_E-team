<?php
session_start(); // ★ 追加：セッション開始

require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ---- セッションチェック ----
if (!isset($_SESSION['admin_id'])) {
    echo "エラー：管理者としてログインしていません。<br>";
    echo '<a href="Alogin-input.php">ログイン画面へ</a>';
    exit;
}
$admin_id = $_SESSION['admin_id'];


// ---- 入力 ----
$title    = trim($_POST['title'] ?? '');
$author   = trim($_POST['author'] ?? '');
$genre    = trim($_POST['genre'] ?? '');
$price    = $_POST['price'] ?? 0;
$synopsis = trim($_POST['synopsis'] ?? '');


// ---- 必須チェック ----
$errors = [];

if ($title === '')     $errors[] = "タイトルは必須です。";
if ($author === '')    $errors[] = "著者は必須です。";
if ($genre === '')     $errors[] = "ジャンルは必須です。";
if ($price === '' || !is_numeric($price))  $errors[] = "価格は必須です。";
if ($synopsis === '')  $errors[] = "あらすじは必須です。";

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


// 正しいキー名（重要）
$book_image_path = uploadFile($_FILES['book_image'], '../uploads/book_images');
$ebook_path      = uploadFile($_FILES['book_e-book'], '../uploads/ebooks');

// サンプル PDF
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


// ---- 登録した book_id を取得 ----
$book_id = $pdo->lastInsertId();


// ---- 管理者ログへ記録 ----
$log_sql = "INSERT INTO admin_logs
(admin_id, target_table, target_id, admin_action, log_date)
VALUES
(:admin_id, 'books', :target_id, '書籍情報を登録', NOW())";

$log_stmt = $pdo->prepare($log_sql);
$log_stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$log_stmt->bindValue(':target_id', $book_id, PDO::PARAM_INT);
$log_stmt->execute();

?>

<!--完了通知-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録完了</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>

<?php require 'menu.php'?>

<section class="section">
  <div class="container">

    <div class="box has-text-centered">

      <h1 class="title is-4 has-text-success"> 登録が完了しました！</h1>

      <p class="mb-4">書籍の登録が正常に完了しました。</p>

      <div class="buttons is-centered">
        <a href="add_book.php?id=<?= $book_id ?>" class="button is-link">
          編集画面に戻る
        </a>

        <a href="book_list.php" class="button is-dark">
          書籍一覧へ
        </a>
      </div>

    </div>

  </div>
</section>

</body>
</html>
