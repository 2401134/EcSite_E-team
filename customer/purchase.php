<?php
session_start();
require 'db-connect.php';

// ▼ 決済方法が未選択の場合（purchase_process が 1 または 2 でない）
if (
    !isset($_SESSION['purchase_process']) ||
    ($_SESSION['purchase_process'] != 1 && $_SESSION['purchase_process'] != 2)
) {
    echo "<script>alert('購入方法が選択されていません。'); history.back();</script>";
    exit;
}

// ▼ buy が POST されていない → このページに来てはいけない
if (!isset($_POST['buy'])) {
    echo "<script>alert('購入方法が不正です。'); history.back();</script>";
    exit;
}

// ▼ buy モードを保存
$_SESSION['buy'] = (int)$_POST['buy'];

// ▼ 個別購入のときだけ book_id を保存
if ($_SESSION['buy'] === 0 && isset($_POST['book_id'])) {
    $_SESSION['book_id'] = (int)$_POST['book_id'];
}

$pdo = new PDO($connect, USER, PASS);
$user_id = $_SESSION['user_id'];

$buy_mode = $_SESSION['buy'];   // 1 = 全部購入, 0 = 1冊購入

$books = [];

if ($buy_mode == 1) {
    // 全て購入 → carts の中からデータを取得
    $sql = $pdo->prepare("
        SELECT b.book_id, b.title, b.synopsis, b.price, b.book_image
        FROM carts c
        JOIN books b ON c.book_id = b.book_id
        WHERE c.user_id = ? AND c.cart_status = 0
        ORDER BY c.put_in_cart DESC
    ");
    $sql->execute([$user_id]);
    $books = $sql->fetchAll(PDO::FETCH_ASSOC);

    $chk = $pdo->prepare("
        SELECT book_id 
        FROM purchases 
        WHERE user_id = ?
    ");
    $chk->execute([$user_id]);
    $bought_ids = array_column($chk->fetchAll(PDO::FETCH_ASSOC), "book_id");

    // ▼ 購入済み book_id を除外する
    $books = array_filter($books, function ($b) use ($bought_ids) {
        return !in_array($b['book_id'], $bought_ids);
    });

    // ▼ 表示する本が無くなったら前のページへ戻す
    if (count($books) === 0) {
        echo "<script>alert('すでに購入済みのため、購入できる本がありません'); history.back();</script>";
        exit;
    }

} else {
    // 個別購入 → セッションの book_id から 1冊取得
    if (!isset($_SESSION['book_id'])) {
        echo "<script>alert('購入する本が指定されていません'); history.back();</script>";
        exit;
    }

    $book_id = $_SESSION['book_id'];

    $sql = $pdo->prepare("
        SELECT book_id, title, synopsis, price, book_image
        FROM books
        WHERE book_id = ?
    ");
    $sql->execute([$book_id]);

    $books[] = $sql->fetch(PDO::FETCH_ASSOC);

    // purchases に存在する本をチェック
    $chk = $pdo->prepare("
        SELECT book_id 
        FROM purchases 
        WHERE user_id = ?
    ");
    $chk->execute([$user_id]);
    $bought_ids = array_column($chk->fetchAll(PDO::FETCH_ASSOC), "book_id");

    // 購入済み book_id を除外
    $books = array_filter($books, function ($b) use ($bought_ids) {
        return !in_array($b['book_id'], $bought_ids);
    });

    // ▼ 表示する本が 0 件なら前のページへ戻す
    if (count($books) === 0) {
        echo "<script>alert('すでに購入済みのため購入できる本がありません'); history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入手続き</title>
    <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <?php require 'menu.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title is-left">購入手続き</h1>

            <?php foreach($books as $b): ?>
            <div class="box">
                <div class="columns is-vcentered">

                    <!-- 左：表紙画像 -->
                    <div class="column is-narrow">
                        <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
                            <img src="<?php echo htmlspecialchars($b['book_image']); ?>">
                        </figure>
                    </div>

                    <div class="column">
                        <p class="title is-6"><?php echo htmlspecialchars($b['title']); ?></p>
                        <p class="subtitle is-7"><?php echo nl2br(htmlspecialchars($b['synopsis'])); ?></p>
                    </div>

                    <div class="column is-narrow">
                        <div class="is-flex is-align-items-center mb-2">
                            <div class="has-text-weight-bold mr-2">
                                <?php echo htmlspecialchars($b['price']); ?>円
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>

            <div class="buttons is-centered mt-4 ">
                <form action="payment_method.php" method="POST">
                    <button class="button is-light is-medium">決済方法選択へ</button>
                </form>

                <form action="customer_function/purchase_buy.php" method="POST">
                    <button class="button is-light is-medium">購入確定</button>
                </form>
            </div>
     
            <div class="has-text-right mt-5">
                <form action="customer_home.php" method="POST">
                    <input type="hidden" name="action" value="home">
                    <button class="button is-dark">
                        <span>ホームに戻る</span>
                    </button>
                </form>
            </div>
        </div>
    </section> 

    <?php require 'footmenu.php'; ?>
    <?php require 'footer.php'; ?>
</body>
</html>