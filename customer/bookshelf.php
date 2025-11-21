<?php require 'customer_function/mybooks.php'?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>本棚</title>
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
      <h1 class="title has-text-left mb-5">本棚</h1>
      <?php if (empty($books)) { ?>
          <p>まだ購入した書籍はありません。</p>
        <?php } ?>

        <?php foreach ($books as $book){ ?>
      <!-- 📘 本のカード -->
      <div class="box">
        <div class="columns is-vcentered">
          
          <!-- 左：表紙画像 -->
          <div class="column is-narrow">
            <figure class="image is-3by4" style="width: 80px;border: 1px solid #4a4a4a;">
              <img src="images/<?= htmlspecialchars($book['book_image'] ?: 'noimage.jpg') ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="has-border">
            </figure>
          </div>

          <!-- 中央：タイトル・あらすじ -->
          <div class="column is-text-centered">
            <p class="title is-6"><?= htmlspecialchars($book['title']) ?></p>
            <p class="subtitle is-7"><?= htmlspecialchars($book['synopsis']) ?></p>
          </div>

          <!-- 右：価格・購入日 -->
          <div class="column is-narrow has-text-right">
            <p><?= htmlspecialchars($book['price']) ?>円</p>
            <p><?= date('Y-m-d', strtotime($book['purchase_date'])) ?>に購入</p>
          </div>
        </div>
        <?php } ?>
      </div>

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
