<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カード決済</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
  <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?>
  <section class="section">
      <h1 class="title is-5">マイページ - 決済方法選択 - カード決済</h1>
        <div class="field">
          <label class="label">カード番号</label>
          <div class="control">
            <input class="input" type="text" name="card_number" placeholder="例：1234 5678 9012 3456">
          </div>
        </div>

        <div class="field">
          <label class="label">有効期限</label>
          <div class="control">
            <input class="input" type="month" name="expiry_date">
          </div>
        </div>

        <div class="field">
          <label class="label">カード名義人</label>
          <div class="control">
            <input class="input" type="text" name="card_holder" placeholder="例：TARO YAMADA">
          </div>
        </div>
        <div class="field">
          <label class="label">CVV</label>
          <div class="control">
            <input class="input" type="password" name="cvv" placeholder="例：123"
                  inputmode="numeric"
                  pattern="\d{3,4}"
                  maxlength="4"
                  required
                  aria-label="CVV"
                  autocomplete="off">
          </div>
        </div>

        <div class="field is-grouped is-grouped-centered">
          <div class="control">
            <form action="" method="POST">
            <button class="button is-dark">カードを登録する</button>
            </form>
          </div>
        </div>

        <div class="field is-grouped is-grouped-right mt-4">
          <div class="control">
            <form action="customer_home.php" method="POST">
            <button class="button is-dark">ホームに戻る</button>
            </form>
          </div>
  </section>
   <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>
