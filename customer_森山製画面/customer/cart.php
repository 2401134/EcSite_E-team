<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php require 'header.php'; ?>
    <?php require 'menu.php'; ?>
    <section class="cart section">
      <div class="container">
        <h1 class="title">カート</h1>

        <!--一括購入ボタン。購入画面に遷移-->

        <div class ="allbuy has-text-right mb-6">
        <form action="purchase.php" method = "post">
          <button type="submit" class="button is-success is-large">
          <span class="icon">
            <i class="fas fa-credit-card"></i>
          </span>
          <span>全て購入する</span>
          <span class="icon">
            <i class="fas fa-shopping-cart"></i>
          </span>
          </button>
        </form>
        </div>

        <!--小説の詳細とか-->

        <div class="box">
          <div class="columns is-vcentered">

            <div class="column is-2">
              <figure class="image is-3by4">
                <img src="images/hyousi1.png" alt="雨とパレット">
              </figure>
            </div>

            <div class="column">
              <h2 class="title is-5">(小説の題名)</h2>
              <p>(簡単なあらすじ)</p>

              <div class="columns is-mobile is-vcentered is-justify-content-flex-end mb-2">
                <div class="column is-narrow">
                  <h2 class="title is-5 mb-0">〇〇〇〇円</h2>
                </div>

                <!--購入ボタン。購入画面に遷移-->

                <div class="column is-narrow">
                  <form action = "purchase.php" method = "post">
                  <button type="submit" class="button is-primary">
                  <span class="icon">
                    <i class="fas fa-shopping-cart"></i>
                  </span>
                  <span>購入する</span>
                  </button>
                  </form>
                </div>

              </div>

              <!--お気に入りに遷移-->

              <div class="buttons is-right">

                <form action ="favorite.php" method="post">
                <button type ="submit" class="button is-light is-rounded">
                  <span class="icon">
                    <i class="fas fa-star"></i>
                  </span>
                </button>
                </form>

                <!--レビュー画面に遷移-->

                <form action ="review.php" method ="post">
                <button type="submit" class="button is-light is-rounded">
                  <span class="icon">
                    <i class="fas fa-comment-alt"></i>
                  </span>
                </button>
                </form>

                <!--カートから削除-->

                <form action="#" method="post">
                <button type="submit" class="button is-danger is-light is-rounded">
                  <span class="icon">
                    <i class="fas fa-trash"></i>
                  </span>
                </button>
                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <?php require 'footmenu.php'; ?>
    <?php require 'footer.php'; ?>
  </body>
</html>