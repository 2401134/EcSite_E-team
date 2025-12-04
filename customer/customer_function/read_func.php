<?php
session_start();
require 'db-connect.php';

if (!isset($_POST['book_id'])) {
    http_response_code(404);
    echo '<script>history.back();</script>';
    exit;
}

$pdo = new PDO($connect, USER, PASS);
$book_id = $_POST['book_id'];

$sql = $pdo->prepare("SELECT e_book FROM books WHERE book_id = ?");
$sql->execute([$book_id]);
$book = $sql->fetch();

if (!$book) {
    $_SESSION['alert_msg'] = "本が存在しません。";
    echo '<script>window.location.href = "../bookshelf.php";</script>';
    exit;
}

$book_pdf = '../' . $book['e_book'];

if (!file_exists($book_pdf)) {
    $_SESSION['alert_msg'] = "ファイルが存在しません。";
    echo '<script>window.location.href = "../bookself.php";</script>';
    exit;
}

header("Location: $book_pdf");
exit;
?>
