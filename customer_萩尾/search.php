<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>書籍検索</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?> 
    <section class="section">
    <div class="container">
      <h1 class="title"style="text-align: left; margin-left: 20%;">書籍検索</h1>
      <!-- 検索バー -->
      <div class="columns is-centered mt-5 mb-5">
        <div class="column is-two-thirds">
          <div class="field">
            <p class="control has-icons-left">
              <input class="input" type="text" placeholder="search" style="border-radius: 12px;">
              <span class="icon is-small is-left">
                <i class="fas fa-search"></i>
              </span>
            </p>
          </div>
        </div>
      </div>

      <!-- ボタン群 -->
      <div class="columns is-centered is-multiline">
        <div class="column is-narrow">
          <input class="button is-large" type="submit" value="著者検索" />
        </div>
        <div class="column is-narrow">
          <input class="button is-large" type="submit" value="ジャンル検索" />
        </div>
        <div class="column is-narrow">
          <input class="button is-large" type="submit" value="価格検索" />
        </div>
        </div>
        <div class="has-text-right mt-4">
          <input class="button is-large is-black" type="button" value="ホームに戻る" onclick="location.href='index.html'" />
        </div>
    </div>
  </section>  
  <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>