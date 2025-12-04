<?php
session_start();
require 'db-connect.php';
?>

<?php
if (!empty($_SESSION['alert_msg'])) {
    echo "<script>alert('" . $_SESSION['alert_msg'] . "');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
}
?>

<?php
// books 全件取得
$pdo = new PDO($connect, USER, PASS);
$stmt = $pdo->prepare("SELECT * FROM books WHERE book_status = 0 ORDER BY book_id ASC");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>試し読み</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<section class="tryread section">

    <div class="container">

        <h1 class="title has-text-left mb-6">
            試し読みできる小説
        </h1>

        <p class="has-text-left mb-6">
            指定されたページまで試し読みできます！<br>
            気になったらぜひ購入してみてください！
        </p>

        <!-- ▼ DB の books を全てループ表示 -->
        <?php foreach ($books as $book): ?>

        <?php
        // 試し読み用 PDF が「準備中」の場合はスキップ
        if ($book['sample'] === '../uploads/samples/preparation.pdf') {
            continue;
        }
        ?>

        <div class="box">
            <div class="columns is-vcentered">

                <!-- 画像（Bulmaそのまま） -->
                <div class="column is-2">
                    <figure class="image is-3by4">
                        <img src="<?= htmlspecialchars($book['book_image']) ?>"
                             alt="<?= htmlspecialchars($book['title']) ?>">
                    </figure>
                </div>

                <div class="column">

                    <!-- 小説タイトル -->
                    <h2 class="title is-5">
                        <?= htmlspecialchars($book['title']) ?>
                    </h2>

                    <!-- あらすじ -->
                    <p><?= nl2br(htmlspecialchars($book['synopsis'])) ?></p>

                    <div class="columns is-mobile is-vcentered is-justify-content-flex-end mb-2">

                        <!-- 試し読みボタン -->
                        <div class="column is-narrow">
                            <form action="customer_function/sample_view.php" method="post" target="_blank">
                                <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                                <button class="button is-dark">
                                    <span class="icon">
                                        <i class="fas fa-book-open"></i>
                                    </span>
                                    <span>試し読みする</span>
                                </button>
                            </form>
                        </div>

                        <!-- カートボタン -->
                        <div class="column is-narrow">
                            <form action="customer_function/cart_add.php" method="post">
                                <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                                <button  class="button is-primary">
                                    <span class="icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                    <span>カートに追加</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- お気に入り & レビュー -->
                    <div class="buttons is-right">
                        <form action="customer_function/favarit.php" method="post">
                            <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                            <button  class="button is-light is-rounded">
                                <span class="icon">
                                    <i class="fas fa-star"></i>
                                </span>
                            </button>
                        </form>
                        <form action="review.php" method="post">
                            <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                            <button  class="button is-light is-rounded">
                                <span class="icon">
                                    <i class="fas fa-comment-alt"></i>
                                </span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <!-- ▲ ループここまで -->

        <!-- ▼ ホームへ戻る -->
        <div class="has-text-right mt-5">
            <form action="customer_home.php" method="POST">
                <button class="button is-dark">
                    <span class="icon"><i class="fas fa-home"></i></span>
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
