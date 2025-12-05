<?php
session_start();
require '../db-connect.php';

// ▼ セッションチェック
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('ログインしてください'); location.href='../login.php';</script>";
    exit;
}

// ▼ purchase_process チェック（1=通常購入, 2=ポイント使用）
if (
    !isset($_SESSION['purchase_process']) ||
    ($_SESSION['purchase_process'] != 1 && $_SESSION['purchase_process'] != 2)
) {
    echo "<script>alert('購入方法が不正です。'); history.back();</script>";
    exit;
}

// ▼ buy モード（0 = 1冊, 1 = 全購入）
if (!isset($_SESSION['buy'])) {
    $_SESSION['alert_msg'] = '不正なアクセスです。';
    echo "<script>history.back();</script>";
    exit;
}

$buy_mode = (int)$_SESSION['buy'];
$user_id = $_SESSION['user_id'];

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ▼ 使用ポイント
$use_point = isset($_POST['use_point']) ? (int)$_POST['use_point'] : 0;
if ($use_point < 0) $use_point = 0;

// ▼ ユーザーの所持ポイント取得
$point_sql = $pdo->prepare("SELECT point FROM users WHERE user_id = ?");
$point_sql->execute([$user_id]);
$my_point = (int)$point_sql->fetchColumn();

// ▼ 購入対象の本を取得
$books = [];
$total_price = 0;

if ($buy_mode == 1) {
    // ▼ カートから全購入
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
    if (!isset($_SESSION['book_id'])) {
        echo "<script>alert('購入する本が指定されていません'); history.back();</script>";
        exit;
    }

    $book_id = (int)$_SESSION['book_id'];

    $sql = $pdo->prepare("SELECT book_id, price FROM books WHERE book_id = ?");
    $sql->execute([$book_id]);
    $b = $sql->fetch(PDO::FETCH_ASSOC);

    if ($b) {
        $books[] = $b;
    }
}

// ▼ 合計金額算出
foreach ($books as $b) {
    $total_price += (int)$b['price'];
}

// ▼ ポイント使用上限
$max_use_point = min($my_point, $total_price);

// ▼ バリデーション
if ($use_point > $max_use_point) {
    echo "<script>alert('使用ポイントが購入金額または所持ポイントを超えています'); history.back();</script>";
    exit;
}

// ▼ 実際に支払う金額
$final_payment = $total_price - $use_point;

// ▼ 重複購入チェック
$chk = $pdo->prepare("SELECT book_id FROM purchases WHERE user_id = ?");
$chk->execute([$user_id]);
$already = array_column($chk->fetchAll(PDO::FETCH_ASSOC), "book_id");

// ▼ トランザクション開始
$pdo->beginTransaction();

try {

    // ▼ 購入履歴に追加
    $now = date("Y-m-d H:i:s");

    $insert = $pdo->prepare("
        INSERT INTO purchases (user_id, book_id, price, purchase_date)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($books as $b) {

        // 購入済みはスキップ
        if (in_array($b['book_id'], $already)) continue;

        $insert->execute([
            $user_id,
            $b['book_id'],
            $b['price'],
            $now
        ]);

        $log = $pdo->prepare("
        INSERT INTO user_logs (user_id, target_table, target_id, user_action, log_date)
        VALUES (?, ?, ?, ?, ?)
        ");

        $action_text = ($buy_mode == 1)
            ? "購入(カート購入)"
            : "購入(個別購入)";

        $log->execute([
            $user_id,
            "purchases",
            $b['book_id'],
            $action_text,
            $now
        ]);
    }

    // ▼ ポイント減算
    if ($use_point > 0) {
        $update_point = $pdo->prepare("
            UPDATE users SET point = point - ? WHERE user_id = ?
        ");
        $update_point->execute([$use_point, $user_id]);
    }

    // ▼ ポイント 1% 付与
    $add_point = floor($final_payment * 0.01);
    if ($add_point > 0) {
        $add_point_sql = $pdo->prepare("
            UPDATE users SET point = point + ? WHERE user_id = ?
        ");
        $add_point_sql->execute([$add_point, $user_id]);
    }

    // ▼ カート論理削除（cart_status = 1）
    if ($buy_mode == 1) {

        // 全購入 → 該当ユーザーのカート全部
        $cart_update = $pdo->prepare("
            UPDATE carts SET cart_status = 1
            WHERE user_id = ? AND cart_status = 0
        ");
        $cart_update->execute([$user_id]);

    } else {

        // 1冊購入 → カートにあればその1冊だけ論理削除
        $cart_update = $pdo->prepare("
            UPDATE carts SET cart_status = 1
            WHERE user_id = ? AND book_id = ? AND cart_status = 0
        ");
        $cart_update->execute([$user_id, $book_id]);
    }

    // ▼ コミット
    $pdo->commit();

    echo "<script>
        alert('購入が完了しました！');
        location.href='../customer_home.php';
    </script>";
    exit;

} catch (Exception $e) {

    $pdo->rollBack();
    echo "<script>alert('購入処理でエラーが発生しました'); history.back();</script>";
    exit;
}

?>