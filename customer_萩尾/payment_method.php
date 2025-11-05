<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>決済方法</title>
  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?>
  <section class="section">
    <div class="container">
      <div class="level">
        <div class="level-left">
          <h1 class="title">マイページ - 決済方法</h1>
        </div>
        <!--ポイント-->
        <div class="level-right">
          <h2 class="subtitle">0pt</h2>
        </div>
      </div>

      <!-- 横並び -->
      <div class="buttons is-centered mt-5" style="gap: 3rem;">
        <!-- 現金決済 -->
        <form action="cash.php" method="POST" style="margin-right: 1rem;">
          <button type="submit" name="payment" value="cash"style="width: 120px; height: 120px;" 
          class="button is-large is-rounded">
            <span class="icon is-large"><i class="fas fa-dollar-sign"></i></span>
          </button>
          <h3 style="margin-left: 1.5rem;"><strong>現金決済</strong></h3>
        </form>

        <!-- カード決済 -->
        <form action="card.php" method="POST">
          <button type="submit" name="payment" value="card" style="width: 120px; height: 120px;"
           class="button  is-large is-rounded">
            <span class="icon is-large"><i class="fas fa-credit-card"></i></span>
          </button>
          <h3 style="margin-left: 1.5rem;"><strong>カード決済</strong></h3>
        </form>
      </div>

      <!-- ホームに戻るボタン -->
      <div class="has-text-right mt-6">
        <form action="customer_home.php" method="POST">
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
