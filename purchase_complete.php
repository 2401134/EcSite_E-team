<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入完了</title>
  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- 中央寄せ -->
  <section class="section is-flex is-justify-content-center is-align-items-center" style="min-height: 100vh;">
    <div class="has-text-centered">
      <h1 class="title">購入手続きが完了しました</h1>

      <form action="customer_home.php" method="POST" class="mt-5">
        <input type="hidden" name="action" value="home">
        <button class="button is-dark is-medium">
          <span>ホームに戻る</span>
        </button>
      </form>
    </div>
  </section>

</body>
</html>
