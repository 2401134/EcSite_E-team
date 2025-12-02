<?php
session_start(); // セッション開始

require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ---- セッションチェック ----
if (!isset($_SESSION['admin_id'])) {
    echo "エラー：管理者としてログインしていません。<br>";
    echo '<a href="../Alogin-input.php">ログイン画面へ</a>';
    exit;
}

$admin_id = $_SESSION['admin_id'];

// ---- 入力受け取り ----
$book_id  = $_POST['book_id'];
$title    = $_POST['title'];
$author   = $_POST['author'];
$genre    = $_POST['genre'];
$price    = $_POST['price'];
$synopsis = $_POST['synopsis'];
$status   = $_POST['book_status'];

// ---- アップロード処理 ----
function uploadFile($file, $dir, $oldPath) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return $oldPath;
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

// ---- 元データ取得（旧ファイルパス利用のため） ----
$sql = "SELECT * FROM books WHERE book_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $book_id);
$stmt->execute();
$old = $stmt->fetch(PDO::FETCH_ASSOC);

// ---- アップロード（変更があった場合のみ差し替え） ----
$book_image = uploadFile($_FILES['book_image'], 'uploads/book_images', $old['book_image']);
$sample     = uploadFile($_FILES['sample'],     'uploads/samples',     $old['sample']);
$ebook      = uploadFile($_FILES['e_book'],     'uploads/ebooks',      $old['e_book']);

// ---- SQL更新 ----
$sql = "UPDATE books SET
            title = :title,
            author = :author,
            genre = :genre,
            price = :price,
            synopsis = :synopsis,
            book_image = :book_image,
            sample = :sample,
            e_book = :e_book,
            book_status = :status
        WHERE book_id = :book_id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':title', $title);
$stmt->bindValue(':author', $author);
$stmt->bindValue(':genre', $genre);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':synopsis', $synopsis);
$stmt->bindValue(':book_image', $book_image);
$stmt->bindValue(':sample', $sample);
$stmt->bindValue(':e_book', $ebook);
$stmt->bindValue(':status', $status, PDO::PARAM_INT);
$stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);

$stmt->execute();

// ---- 管理者ログへ記録 ----
$log_sql = "INSERT INTO admin_logs
            (admin_id, target_table, target_id, admin_action, log_date)
            VALUES
            (:admin_id, 'books', :target_id, '書籍情報を更新', NOW())";

$log_stmt = $pdo->prepare($log_sql);
$log_stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
$log_stmt->bindValue(':target_id', $book_id, PDO::PARAM_INT);
$log_stmt->execute();

// ---- 完了メッセージ ----
echo "更新が完了しました！<br>";
echo "ログも記録しました。<br>";
echo '<a href="edit_book.php?id=' . $book_id . '">戻る</a>';