<?php
session_start();
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// ================
// 1. purchase_process の確認
// ================
if (!isset($_SESSION['purchase_process']) ||
    !in_array($_SESSION['purchase_process'], [1, 2])) {

    echo "<script>alert('購入手続きが正しくありません。'); history.back();</script>";
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "<script>alert('ログイン情報がありません。'); history.back();</script>";
    exit;
}

// ================
// 2. carts の取得（cart_status = 0 のみ）
// ================
$sql = "SELECT carts.*, books.price
        FROM carts
        INNER JOIN books ON carts.book_id = books.book_id
        WHERE carts.user_id = :user_id
        AND carts.cart_status = 0";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$carts = $stmt->fetchAll();

if (!$carts) {
    echo "<script>alert('購入可能な商品がカートにありません。'); history.back();</script>";
    exit;
}

try {
    $pdo->beginTransaction();

    foreach ($carts as $cart) {

        // -------------------------
        // purchases に購入品登録
        // -------------------------
        $insertPurchase = "
            INSERT INTO purchases(user_id, book_id, price, purchase_date)
            VALUES(:user_id, :book_id, :price, NOW())
        ";
        $stmtP = $pdo->prepare($insertPurchase);
        $stmtP->execute([
            ':user_id' => $user_id,
            ':book_id' => $cart['book_id'],
            ':price'   => $cart['price']
        ]);

        $purchase_id = $pdo->lastInsertId();

        // -------------------------
        // user_logs にログ記録
        // -------------------------
        $insertLog = "
            INSERT INTO user_logs(user_id, target_table, target_id, user_action, log_date)
            VALUES(:user_id, 'purchases', :target_id, 'purchase', NOW())
        ";
        $stmtL = $pdo->prepare($insertLog);
        $stmtL->execute([
            ':user_id'   => $user_id,
            ':target_id' => $purchase_id
        ]);
    }

    // -------------------------
    // carts を論理削除 cart_status = 1
    // -------------------------
    $updateCart = "
        UPDATE carts
        SET cart_status = 1
        WHERE user_id = :user_id
        AND cart_status = 0
    ";
    $stmtU = $pdo->prepare($updateCart);
    $stmtU->execute([':user_id' => $user_id]);

    $pdo->commit();

    header("Location: test_purchase_complete.php");
    exit;

} catch (Exception $e) {

    $pdo->rollBack();

    echo "<script>alert('購入処理中にエラーが発生しました。'); history.back();</script>";
    exit;
}