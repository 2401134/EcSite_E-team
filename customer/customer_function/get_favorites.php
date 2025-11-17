<?php
function getFavorites($pdo, $user_id) {
    $sql = "SELECT book_id FROM favorites WHERE user_id = ? AND favorite_status = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>