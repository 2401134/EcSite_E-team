<?php require 'customer_function/favorite_controller.php' ;

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('ログインしてください');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
    echo "<script>history.back()</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?> 

<section class="section">
<div class="container">
  <h1 class="title has-text-left mb-5">お気に入り</h1>

  <?php if (!empty($favorites)) { ?>

      <?php foreach ($favorites as $book) { ?>
      <div class="box">
        <div class="columns is-vcentered">

          <!-- 左：表紙 -->
          <div class="column is-narrow">
            <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
              <img src="<?= htmlspecialchars($book['sample'] ?? 'images/sample.jpg') ?>" alt="小説の表紙">
            </figure>
          </div>

          <!-- 中央：タイトルとあらすじ -->
          <div class="column">
            <p class="title is-6"><?= htmlspecialchars($book['title']) ?></p>
            <p class="subtitle is-7"><?= htmlspecialchars($book['synopsis']) ?></p>
          </div>

          <!-- 右：購入情報 -->
          <div class="column is-narrow has-text-right">

            <?php if (!empty($book['purchase_date'])) { ?>

                <!-- 購入済み表示 -->
                <p class="is-size-5"><strong><?= htmlspecialchars($book['price']) ?>円</strong></p>
                <p class="is-size-7"><?= htmlspecialchars(date('Y年m月d日', strtotime($book['purchase_date']))) ?>に購入</p>

                <!-- 横並び：解除のみ -->
                <div style="margin-top: 10px; display: flex; gap: 8px; justify-content: flex-end;">
                    <form action="customer_function/favarit.php" method="POST">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                        <button class="button is-light">
                            <span class="icon"><i class="fa-solid fa-trash"></i></span>
                            <span>解除</span>
                        </button>
                    </form>
                </div>

            <?php } else { ?>

                <!-- 未購入表示 -->
                <p class="is-size-6"><?= htmlspecialchars($book['price']) ?>円</p>
                <p class="is-size-6">この商品は未購入です</p>

                <!-- 購入ボタン -->
                <form action="purchase.php" method="POST">
                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                    <button class="button is-dark"><span>購入する</span></button>
                </form>

                <!-- カート + 解除 横並び -->
                <div style="margin-top: 10px; display: flex; gap: 8px; justify-content: flex-end;">

                    <!-- カート -->
                    <form action="customer_function/cart_add.php" method="POST">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                        <button class="button is-info">
                            <span class="icon"><i class="fa-solid fa-cart-shopping"></i></span>
                            <span>カート</span>
                        </button>
                    </form>

                    <!-- 解除 -->
                    <form action="customer_function/favarit.php" method="POST">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                        <button class="button is-light">
                            <span class="icon"><i class="fa-solid fa-trash"></i></span>
                            <span>解除</span>
                        </button>
                    </form>

                </div>

            <?php } ?>

          </div><!-- /右 -->

        </div><!-- /columns -->
      </div><!-- /box -->
      <?php } ?><!-- /foreach -->

  <?php } else { ?>
      <p>お気に入りはまだ登録されていません。</p>
  <?php } ?>

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
