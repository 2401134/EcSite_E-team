<?php
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);
$book_id = $_GET['book_id'];

$sql = $pdo->prepare("SELECT sample FROM books WHERE book_id = ?");
$sql->execute([$book_id]);
$book = $sql->fetch();

if (!$book) {
    echo '<script>
        alert("本が見つかりません");
        history.back();
        </script>';
    exit;
}

$sample_pdf = '../' . $book['sample'];

header("Location: $sample_pdf");
exit;
?>
