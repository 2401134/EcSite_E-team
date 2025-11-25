<?php
require 'customer_function/customer_home_func.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>顧客ホーム画面</title>
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
      <div class="columns is-multiline">
        <!-- 🔁 繰り返し -->
        <?php foreach ($books as $row){ 
          $book_id = (int)$row['book_id'];
          $title = $row['title'];
          $synopsis =$row['synopsis'];
          $image_path = !empty($row['sample']) ? $row['sample']: 'images/sample.jpg';
          $is_fav = in_array($book_id, $favorites);
        ?>
        <div class="column is-one-third">
          <div class="card">
            <div class="card-image">
              <figure class="image is-3by4">
                <img src="<?= $image_path ?>" alt="小説の表紙">
              </figure>
            </div>
            <div class="card-content">
              <p class="title is-6"><?= $title ?></p>
              <p class="subtitle is-7"><?= $synopsis ?></p>

              <div class="level-right">
                <!-- 🔹お気に入り登録フォーム -->
                <form action="customer_function/favarit.php" method="POST" style="display:inline;">
                  <input type="hidden" name="book_id" value="<?= $book_id ?>">
                  <button type="submit" class="button is-white is-rounded" title="お気に入り登録">
                    <span class="icon">
                      <i class="<?= $is_fav ? 'fas fa-star has-text-dark' : 'far fa-star' ?>"></i>
                    </span>
                  </button>
                </form>

                <!-- 🔹レビュー画面へ -->
                <form action="review.php" method="get" style="display:inline;">
                  <input type="hidden" name="book_id" value="<?= $book_id ?>">
                  <button type="submit" class="button is-white is-normal" title="レビューを見る">
                    <span class="icon">
                      <i class="far fa-comment"></i>
                    </span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>
