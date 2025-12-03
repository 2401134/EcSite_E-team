<?php
session_start();

// 初期化（無ければ0）
if (!isset($_SESSION['purchase_process'])) {
    $_SESSION['purchase_process'] = 0;
}

$success = false;

// POST 処理（支払いボタンが押されたときのみ true）
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment'])) {

    // 現金払いに設定
    $_SESSION['purchase_process'] = 1;

    // 完了フラグ
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>現金決済</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<section class="section">
  <div class="container"> 
    <div class="title is-left">マイページ - 決済方法 - 現金決済</div>
    <div class="subtitle is-left">お支払先の指定</div>

    <!-- この条件なら初回ロードでは絶対に出ない -->
    <?php if ($success): ?>
      <script>
        alert("現金決済を登録しました");
      </script>
    <?php endif; ?>

    <!-- 支払先フォーム -->
    <form action="" method="POST">
      <div class="has-text-centered mt-5">
        <button type="submit" name="payment" value="oo_bank" class="button is-black is-normal is-fullwidth">
          <span><strong>〇〇銀行</strong></span>
        </button>
      </div>

      <div class="has-text-centered mt-5">
        <button type="submit" name="payment" value="xx_bank" class="button is-black is-normal is-fullwidth">
          <span><strong>✕✕銀行</strong></span>
        </button>
      </div>

      <div class="has-text-centered mt-5">
        <button type="submit" name="payment" value="conveni" class="button is-black is-normal is-fullwidth">
          <span><strong>〇✕コンビニ決済</strong></span>
        </button>
      </div>
    </form>
  </div>

  <!-- ホームに戻る -->
  <div class="container has-text-right mt-6">
    <form action="customer_home.php" method="POST">
      <button class="button is-dark">
        <span>ホームに戻る</span>
      </button> 
    </form>  
  </div>
</section>

<?php require 'footmenu.php'; ?>
<?php require 'footer.php'; ?>

</body>
</html>