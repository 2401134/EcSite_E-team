<?php
require 'customer_function/favorite_controller.php' ;
$favorites = getFavoriteList($pdo, $_SESSION['user_id'] ?? 1);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り</title>
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
      <h1 class="title has-text-left mb-5">お気に入り</h1>
    <?php if (!empty($favorites)){ ?>
    <?php foreach ($favorites as $book){ ?>
    <div class="box">
        <div class="columns is-vcentered">

            <!-- 左：表紙画像 -->
            <div class="column is-narrow">
                <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
                    <img src="<?= htmlspecialchars($book['sample'] ?? 'images/sample.jpg') ?>" alt="小説の表紙">
                </figure>
            </div>

            <!-- 中央：タイトル・あらすじ -->
            <div class="column">
                <p class="title is-6"><?= htmlspecialchars($book['title']) ?></p>
                <p class="subtitle is-7"><?= htmlspecialchars($book['synopsis']) ?></p>
            </div>

            <!-- 右：購入情報 -->
            <div class="column is-narrow has-text-right">
                <?php if (!empty($book['purchase_date'])){ ?>
                    <p class="is-size-5"><strong><?= htmlspecialchars($book['price'] ?? '') ?>円</strong></p>
                    <p class="is-size-7"><?= htmlspecialchars(date('Y年m月d日', strtotime($book['purchase_date']))) ?>に購入</p>
                <?php }else{ ?>
                    <p class="is-size-7"><?= htmlspecialchars($book['price'] ?? '') ?>円</p>
                    <p class="is-size-7">この商品は未購入です</p>
                    <form action="purchase.php" method="POST">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                        <button class="button is-dark">
                            <span>購入する</span>
                        </button>
                    </form>
                <?php } ?>
            </div>

        </div>
    </div>
<?php } ?>
<?php } ?>


      <!-- 🏠 ホームに戻る -->
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