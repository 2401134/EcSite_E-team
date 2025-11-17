<?php
    $pdo = new PDO($connect, USER, PASS);
    // 仮ユーザーID（ログイン機能ができたら $_SESSION['user_id'] に置き換え）
    $user_id = 1;

    // 🔹 書籍データ取得
    $sql = "SELECT book_id, title, synopsis, sample FROM books";
    $stmt = $pdo->query($sql);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 🔹 お気に入り一覧取得
    $fav_sql = "SELECT book_id FROM favorites WHERE user_id = ?";
    $fav_stmt = $pdo->prepare($fav_sql);
    $fav_stmt->execute([$user_id]);
    $favorites = $fav_stmt->fetchAll(PDO::FETCH_COLUMN);
?>