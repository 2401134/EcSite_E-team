<?php
function bookExists($pdo, $book_id) {
    $sql = "SELECT COUNT(*) FROM books WHERE book_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$book_id]);
    return $stmt->fetchColumn() > 0;
}
?>