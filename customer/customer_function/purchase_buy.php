<?php
session_start();
require '../db-connect.php';

// --------------------------------------------------
// 0. セッションチェック（最低限）
// --------------------------------------------------

// 購入モードが無い → 不正アクセス
if (!isset($_SESSION['buy'])) {
    echo "<script>alert('購入手続きが正しく行われていません。'); history.back();</script>";
    exit;
}

// 個別購入なのに book_id が無い
if ($_SESSION['buy'] == 0 && !isset($_SESSION['book_id'])) {
    echo "<script>alert('購入対象の本が指定されていません。'); history.back();</script>";
    exit;
}

$pdo = new PDO($connect, USER, PASS);
$user_id = $_SESSION['user_id'];
$buy_mode = $_SESSION['buy'];


// --------------------------------------------------
// 1. 購入対象の本一覧を取得
// --------------------------------------------------
$books = [];

if ($buy_mode == 1) {
    // ▼ カートの全てを購入
    $sql = $pdo->prepare("
        SELECT b.book_id, b.price
        FROM carts c
        JOIN books b ON c.book_id = b.book_id
        WHERE c.user_id = ? AND c.cart_status = 0
    ");
    $sql->execute([$user_id]);
    $books = $sql->fetchAll(PDO::FETCH_ASSOC);

} else {
    // ▼ 個別購入
    $book_id = $_SESSION['book_id'];

    $sql = $pdo->prepare("SELECT book_id, price FROM books WHERE book_id = ?");
    $sql->execute([$book_id]);
    $book = $sql->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        $books[] = $book;
    } else {
        echo "<script>alert('購入対象の本が見つかりません'); history.back();</script>";
        exit;
    }
}


// --------------------------------------------------
// 2. purchases に登録（重複 book_id はスキップ）
// --------------------------------------------------
$insert = $pdo->prepare("
    INSERT INTO purchases (user_id, book_id, price, purchase_date)
    SELECT ?, ?, ?, NOW()
    WHERE NOT EXISTS (
        SELECT 1 FROM purchases 
        WHERE user_id = ? AND book_id = ?
    )
");

foreach ($books as $b) {
    $insert->execute([
        $user_id,
        $b['book_id'],
        $b['price'],
        $user_id,
        $b['book_id']
    ]);
}


// --------------------------------------------------
// 3. カート購入の場合、cart_status を購入済みに更新
// --------------------------------------------------
if ($buy_mode == 1) {
    $sql = $pdo->prepare("UPDATE carts SET cart_status = 1 WHERE user_id = ?");
    $sql->execute([$user_id]);
}


// --------------------------------------------------
// 4. 完了画面へ遷移（purchase_complete.php）
// --------------------------------------------------
header("Location: ../purchase_complete.php");
exit;