<?php section_start()?>
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
      <!-- ここから繰り返し部分（PHPでループ） -->
       <?php
       for($i=0;$i<3;$i++){?>
      <div class="column is-one-third">
        <div class="card">
          <div class="card-image">
            <figure class="image is-3by4">
              <img src="images/sample.jpg" alt="小説の表紙">
            </figure>
          </div>
          <div class="card-content">
            <p class="title is-6">(小説の題名)</p>
            <p class="subtitle is-7">(簡単なあらすじ)</p>
              <div class="level-right">
                <!--お気に入り登録-->
                 <form action="favorite_add.php" method="POST" style="display:inline;">
                  <button type="submit" name="book_id" value="<?= $i ?>" 
                    class="button is-white is-rounded" title="お気に入り登録">
                    <span class="icon">
                      <i class="far fa-star"></i>
                    </span>
                  </button>
                </form>
                <!--レビュー画面へ遷移-->
                <form action="review.php" method="get" style="display:inline;">
                  <button type="submit" class="button is-white is-normal">
                    <span class="icon">
                      <i class="far fa-comment"></i>
                    </span>
                  </button>
                </form>
               </div>
          </div>
        </div>
      </div>
      <!-- 繰り返しここまで -->
         <?php }?>
    </div>
  </div>
</section>
<?php require 'header.php'; ?>
  <?php require 'menu.php'; ?> 
</body>
</html>
