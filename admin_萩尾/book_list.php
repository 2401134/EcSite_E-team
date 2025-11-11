<?php session_start() ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>書籍管理</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <style>
    /* ボタンの余白を広くする */
    .book-buttons form {
      display: inline-block;
      margin: 0 20px; /* 横に20pxの隙間 */
      text-align: center;
    }

    /* ラベル（pタグ）をボタンの下に中央寄せで */
    .book-buttons p {
      margin-top: 5px;
      font-weight: bold;
    }

    /* 全体の上に少し余白 */
    .book-buttons {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <?php require 'header.php'?>
    <?php require 'menu.php'?>
  <section class="section">
    <div class="container">
      <h1 class="title has-text-left">書籍管理</h1>

      <!-- ✅ 書籍操作ボタン -->
      <div class="book-buttons has-text-right">

        <!-- 書籍を追加 -->
        <form action="book_add.php" method="post">
          <button type="submit" class="button is-light is-rounded is-large">
            <span class="icon"><i class="fas fa-plus"></i></span>
          </button>
          <p>書籍を追加</p>
        </form>

        <!-- 書籍情報を編集 -->
        <form action="book_edit.php" method="post">
          <button type="submit" class="button is-light is-rounded is-large">
            <span class="icon"><i class="fas fa-edit"></i></span>
          </button>
          <p>書籍情報を編集</p>
        </form>

        <!-- 書籍を削除 -->
        <form action="book_delete.php" method="post">
          <button type="submit" class="button is-light is-rounded is-large">
            <span class="icon"><i class="fas fa-trash"></i></span>
          </button>
          <p>書籍を削除</p>
        </form>

      </div>
      <!-- 書籍表示ボックス -->
      <div class="box mt-5">
        <div class="columns is-vcentered">
          <!-- 左：表紙画像 -->
          <div class="column is-narrow">
            <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
              <img src="images/sample.jpg" alt="小説の表紙">
            </figure>
          </div>

          <!-- 価格表示 -->
          <div class="column is-narrow">
            <div class="is-flex is-align-items-center mb-2">
              <div class="has-text-weight-bold mr-2">〇〇〇〇円</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</body>
</html>
