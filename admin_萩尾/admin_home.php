<?php session_start() ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <?php require 'header.php'?>
    <?php require 'menu.php'?>
    <h1 class="has-text-right subtitle">
        <a href="super_admin_home.php">総合管理者ホームへ
            <i class="fas fa-external-link-alt"></i>
        </a>
    </h1>
      <section class="section">
    <div class="container">
      <div class="columns is-centered is-multiline has-text-centered">
        
        <!-- 書籍管理 -->
        <div class="column is-one-third">
          <form action="book_list.php" method="POST">
            <button class="button is-light is-large is-rounded"style="height: 120px; width: 120px; ">
              <i class="fas fa-book fa-2x"></i>
            </button>
          </form>
          <p class="subtitle is-6 mt-2">書籍管理</p>
        </div>

        <!-- レビュー管理 -->
        <div class="column is-one-third">
          <form action="review_manage.php" method="POST">
            <button class="button is-light is-large is-rounded" style="height: 120px; width: 120px;">
              <i class="fas fa-comment-dots fa-2x"></i>
            </button>
          </form>
          <p class="subtitle is-6 mt-15">レビュー管理</p>
        </div>

        <!-- ユーザー管理 -->
        <div class="column is-one-third">
          <form action="user_manage" method="POST">
            <button class="button is-light is-large is-rounded" style="height: 120px; width: 120px; ">
              <i class="fas fa-user fa-2x"></i>
            </button>
          </form>
          <p class="subtitle is-6 mt-2">ユーザー管理</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ログアウトボタンとログ表示ボタンを横並びに -->
<section class="section pt-0">
  <div class="container">
    <div class="buttons">
      <form action="logout.php" method="POST" style="display: inline-block;margin-right: 750px;">
        <button class="button is-danger is-medium is-right">ログアウト</button>
      </form>

       <form action="log_manage.php" method="POST" style="display: inline-block;"> 
        <button class="button is-medium is-left">ログを表示</button>
      </form>
    </div>
  </div>
</section>

</body>
</html>