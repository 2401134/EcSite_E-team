<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
</head>
<body>
  <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?> 
    <section class="sectiion">
    <div class="is-flex is-align-items-center is-justify-content-space-between mb-4 mt-4 ml-4 mr-4">
        <h1 class="title is-2 mb-0 ml-2 mt-2">マイページ</h1>
            <form action="customer_home.php" method="POST" class="mt-2 mr-2">
                <input type="hidden" name="action" value="home">
                <button class="button is-dark is-normal">
                <span>ホームに戻る</span>
                </button>
            </form>
    </div>
    <div class="box">
        <form action="risetto.php" method="POST">
          <div class="is-flex is-align-items-center is-justify-content-space-between">
            <p>アカウント名、パスワード変更、プライバシー管理</p>
            <button class="button is-smal is-rounded is-right" style="height: 20ppx; width: 20px;">
                <span>▶</span>
            </button>
          </div>
        </form>
    </div>
    <div class="box">
        <form action="payment_method.php" method="POST">
          <div class="is-flex is-align-items-center is-justify-content-space-between">
            <p>決済方法</p>
            <button class="button is-smal is-rounded is-right" style="height: 20ppx; width: 20px;">
                <span>▶</span>
            </button>
          </div>
        </form>
    </div>
    <div class="box">
        <form action="#" method="POST">
          <div class="is-flex is-align-items-center is-justify-content-space-between">
            <p>年齢認証</p>
            <button class="button is-smal is-rounded is-right" style="height: 20ppx; width: 20px;">
                <span>▶</span>
            </button>
          </div>
        </form>
    </div>
    <div class="box">
        <form action="logout.php" method="POST">
          <div class="is-flex is-align-items-center is-justify-content-space-between">
            <p>ログアウト</p>
            <button class="button is-smal is-rounded is-right" style="height: 20ppx; width: 20px;">
                <span>▶</span>
            </button>
          </div>
        </form>
    </div>
    </section>
  <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>