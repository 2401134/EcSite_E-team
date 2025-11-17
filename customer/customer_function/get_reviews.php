<?php
function getReviews($pdo, $book_id) {
    $sql = "SELECT r.review_id, r.user_id, r.comment_text, r.review_rank, u.user_name
            FROM reviews r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.book_id = :book_id
            ORDER BY r.review_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>