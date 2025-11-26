<?php
    session_start();
    require 'db-connect.php';
    $pdo = new PDO($connect, USER, PASS);
    // 仮ユーザーID（ログイン機能ができたら $_SESSION['user_id'] に置き換え）
    $user_id = $_SESSION['user_id'] ?? null;

    // 🔹 書籍データ取得
    function getBooks($pdo){
    $sql = "SELECT book_id, title, synopsis, sample ,price FROM books";
    $stmt = $pdo->query($sql);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 お気に入り一覧取得
    function getFavorites($pdo, $user_id) {
    $sql = "SELECT book_id FROM favorites WHERE user_id = ? AND favorite_status = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}
    $books=getBooks($pdo);
    $favorites=getFavorites($pdo,$user_id);
?>