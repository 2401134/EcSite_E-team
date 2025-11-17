<?php
function insertReview($pdo, $user_id, $book_id, $review_rank, $comment_text) {
    $sql = "INSERT INTO reviews (user_id, book_id, review_rank, comment_text, upload_date)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$user_id, $book_id, $review_rank, $comment_text]);
}
?>