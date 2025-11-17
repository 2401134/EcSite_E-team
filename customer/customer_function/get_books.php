<?php
function getBooks($pdo) {
    $sql = "SELECT book_id, title, synopsis, sample FROM books";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>