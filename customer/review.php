<?php
require 'customer_function/review1_function.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>レビュー画面</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
     .review-card {
        border: 1px solid #dbdbdb;
        padding: 1.5em;
        margin-bottom: 1.5em;
        border-radius: 10px;
     }
     .review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.8em;
     }
     .review-report {
        text-align: right;
        margin-top: 0.5em;
     }
     .review-stars {
    margin-left: 0;/* 左寄せ */
    margin-right: 55em;
    margin-top: 0.5em; /* 少し余白 */
  }
  </style>
</head>
<body>
  <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?> 

  <section class="section">
    <div class="container">
      <h1 class="title has-text-left">この作品のレビュー</h1>
      <div class="has-text-left mb-4">
          <?php if(!$user_id){ ?>
             <button class="button is-dark is-medium" disabled>
          <span class="icon"><i class="fas fa-lock"></i></span>
          <span>ログインしてください</span>
        </button>

      <?php }elseif (!$is_purchased){ ?>
        <button class="button is-dark is-medium" disabled>
          <span class="icon"><i class="fas fa-ban"></i></span>
          <span>購入者のみレビュー可能</span>
        </button>

      <?php }else{ ?>

      <!-- レビューを書くボタン -->
      <div class="has-text-left mb-4">
        <form action="review_write.php" method="POST"> 
          <input type="hidden" name="book_id" value="<?= htmlspecialchars($book_id) ?>">
          <button type="submit" class="button is-black is-medium">
            <span class="icon"><i class="fas fa-pen"></i></span>
            <span>レビューを書く</span>
          </button>
        </form>
        <?php } ?>
      </div>

      <!-- 🔹 レビュー一覧表示 -->
      <?php if (!empty($reviews)){ ?>
        <?php foreach ($reviews as $review){ ?>
          <div class="box review-card">
            
            <div class="review-header">
              <!-- ユーザーアイコンと名前 -->
              <div style="margin-left: 0.3em;">
                <span class="icon is-large has-text-grey" style="border: 1px solid #4a4a4a; border-radius:45%;padding:1em;">
                  <i class="fas fa-user fa-lg"></i>
                </span>
              </div>
              
              <!-- 星評価 -->
               <div class="review-stars">
                  <?php for ($i = 1; $i <= 5; $i++){ ?>
                    <span class="icon <?= ($i <= (int)$review['review_rank']) ? 'has-text-dark' : 'has-text-grey-light' ?>">
                      <i class="fas fa-star"></i>
                    </span>
                  <?php } ?>
               </div>
              </div>

            <!-- コメント本文 -->
            <p class="mt-2 text" style="text-align: center;">
              <?= nl2br(htmlspecialchars($review['comment_text'])) ?>
            </p>

            <!-- 通報ボタン -->
            <div class="review-report">
              <button class="button is-light is-normal is-rounded">
                <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
              </button>
              <p><span class="is-size-6">通報</span></p>
              <p class="is-size-7 mt-1">ユーザーID: <?= htmlspecialchars($review['user_id']) ?></p>
            </div>

          </div>
        <?php } ?>

      <?php }else{ ?>
        <p>まだレビューはありません。</p>
      <?php } ?>

      <!-- ホームに戻る -->
      <div class="has-text-right mt-5">
        <a href="customer_home.php" class="button is-black">
          <span class="icon"><i class="fas fa-home"></i></span>
          <span>ホームに戻る</span>
        </a>
      </div>
    </div>
  </section>

  <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>