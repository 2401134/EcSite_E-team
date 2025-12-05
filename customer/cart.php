<?php
require 'db-connect.php';
session_start();
?>

<?php
if (!empty($_SESSION['alert_msg'])) {
    echo "<script>alert('" . $_SESSION['alert_msg'] . "');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
}
?>

<?php
// ログインしていない場合はログイン画面へ
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('ログインしてください');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
    echo "<script>history.back()</script>";
    exit();
}

$pdo = new PDO($connect, USER, PASS);
$user_id = $_SESSION['user_id'];

$sql = $pdo->prepare("
    SELECT c.cart_id, c.put_in_cart, c.cart_status,
           b.book_id, b.title, b.synopsis, b.price, b.book_image
    FROM carts c
    JOIN books b ON c.book_id = b.book_id
    WHERE c.user_id = ? AND c.cart_status = 0
    ORDER BY c.put_in_cart DESC
");
$sql->execute([$user_id]);
$cart_items = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

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
          <input type="hidden" name="buy" value="1">
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

        <!-- カートに何も入れていない、削除して何もない場合 -->
        <?php if (count($cart_items) === 0): ?>
        <div class="notification is-info has-text-centered">
            カートに本を追加しましょう　=(
        </div>
        <?php endif; ?>

        <?php foreach ($cart_items as $item): ?>

        <div class="box">
          <div class="columns is-vcentered">

    <!-- 表紙画像 -->
            <div class="column is-2">
              <figure class="image is-3by4">
                <img src="<?php echo htmlspecialchars($item['book_image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
              </figure>
            </div>

            <div class="column">

      <!-- タイトル -->
              <h2 class="title is-5"><?php echo htmlspecialchars($item['title']); ?></h2>

      <!-- あらすじ -->
              <p><?php echo nl2br(htmlspecialchars($item['synopsis'])); ?></p>

              <div class="columns is-mobile is-vcentered is-justify-content-flex-end mb-2">
                <div class="column is-narrow">
          <!-- 価格 -->
                  <h2 class="title is-5 mb-0"><?php echo $item['price']; ?>円</h2>
                </div>

        <!-- 購入ボタン -->
                <div class="column is-narrow">
                  <form action="purchase.php" method="post">
                    <input type="hidden" name="book_id" value="<?php echo $item['book_id']; ?>">
                    <input type="hidden" name="buy" value="0">
                    <button type="submit" class="button is-primary">
                      <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                      <span>購入する</span>
                    </button>
                  </form>
                </div>
              </div>

      <!-- お気に入り/レビュー/削除 -->
              <div class="buttons is-right">

        <!-- お気に入り -->
                <form action="customer_function/favarit.php" method="POST" style="display:inline;">
                  <input type="hidden" name="book_id" value="<?= $book_id ?>">
                  <button type="submit" class="button is-white is-rounded" title="お気に入り登録">
                    <span class="icon">
                      <i class='far fa-star'></i>
                    </span>
                  </button>
                </form>

        <!-- レビュー -->
                <form action="review.php" method="post">
                  <input type="hidden" name="book_id" value="<?php echo $item['book_id']; ?>">
                  <button type="submit" class="button is-light is-rounded">
                    <span class="icon"><i class="fas fa-comment-alt"></i></span>
                  </button>
                </form>

        <!-- カートから削除 -->
                <form action="customer_function/cart_delete.php" method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                  <button type="submit" class="button is-danger is-light is-rounded">
                    <span class="icon"><i class="fas fa-trash"></i></span>
                  </button>
                </form>

              </div>
            </div>
          </div>
        </div>

        <?php endforeach; ?>


        <!-- ホームに戻る -->
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