<?php
function checkPurchased($pdo, $user_id, $book_id) {
    $sql = "SELECT 1 FROM purchases 
            WHERE user_id = ? AND book_id = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $book_id]);

    return $stmt->fetchColumn() ? true : false;
}
?>