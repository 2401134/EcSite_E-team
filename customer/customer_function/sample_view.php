<?php
session_start();
require 'db-connect.php';

if (!isset($_GET['book_id'])) {
    echo '<script>
        http_response_code(404);
        history.back();
        </script>';
    exit;
}

$pdo = new PDO($connect, USER, PASS);
$book_id = $_GET['book_id'];

$sql = $pdo->prepare("SELECT sample FROM books WHERE book_id = ?");
$sql->execute([$book_id]);
$book = $sql->fetch();

if (!$book) {
    $_SESSION['alert_msg'] = "本が存在しません。";
    echo '<script>
        window.location.href = "../tryread.php";
        </script>';
    exit;
}

$sample_pdf = '../' . $book['sample'];

header("Location: $sample_pdf");
exit;
?>
