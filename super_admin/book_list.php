<?php 
session_start();

if (!empty($_SESSION['alert_msg'])) {
    echo "<script>alert('" . $_SESSION['alert_msg'] . "');</script>";
    unset($_SESSION['alert_msg']); // 1回だけ出す
}

if (!isset($_SESSION['admin_id'])) {
    http_response_code(404);
    exit;
}

if (!isset($_SESSION['super_admin']) || $_SESSION['super_admin'] != 0) {
    echo '<script>
          alert("総合管理者の権限がありません");
          history.back();
          </script>';
    exit;
}

require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 検索機能
$keyword = $_GET['keyword'] ?? '';

if ($keyword === '') {
    $sql = "SELECT * FROM books ORDER BY register_date DESC";
    $stmt = $pdo->query($sql);
} else {
    $sql = "SELECT * FROM books 
            WHERE title LIKE :kw 
               OR author LIKE :kw
               OR genre LIKE :kw
            ORDER BY register_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':kw', '%' . $keyword . '%');
    $stmt->execute();
}

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>書籍管理</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <style>
    .book-buttons form {
      display: inline-block;
      margin: 0 20px;
      text-align: center;
    }
    .book-buttons p {
      margin-top: 5px;
      font-weight: bold;
    }
    .book-buttons {
      margin-top: 20px;
    }
    .book-box {
      margin-top: 25px;
    }
    .book-info p {
      margin: 2px 0;
    }
  </style>
</head>

<body>
<?php require 'header.php' ?>
<?php require 'menu.php' ?>

<section class="section">
  <div class="container">
    <h1 class="title has-text-left">書籍管理</h1>

    <!-- 検索 -->
    <form method="get" class="mt-4">
      <div class="field has-addons">
        <div class="control is-expanded">
          <input 
            class="input" 
            type="text" 
            name="keyword" 
            placeholder="タイトル / 著者 / ジャンル"
            value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="control">
          <button class="button is-info">
            <i class="fas fa-search"></i>&nbsp;検索
          </button>
        </div>
      </div>
    </form>

    <!-- 書籍追加ボタン -->
    <div class="book-buttons has-text-centered">
      <form action="add_book.php" method="get">
        <button type="submit" class="button is-light is-rounded is-large">
          <span class="icon"><i class="fas fa-plus"></i></span>
        </button>
        <p>書籍を追加</p>
      </form>
    </div>

    <!-- 書籍一覧表示 -->
    <?php foreach ($books as $book): ?>
    <div class="box book-box">
      <div class="columns is-vcentered">

        <!-- 表紙画像 -->
        <div class="column is-narrow">
          <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
            <img src="<?= htmlspecialchars($book['book_image']) ?>" alt="表紙画像">
          </figure>
        </div>

        <!-- 書籍情報 -->
        <div class="column book-info">
          <p><strong>ID：</strong><?= $book['book_id'] ?></p>
          
          <p>
            <strong>タイトル：</strong>
            <a href="review_manage.php?book_id=<?= $book['book_id'] ?>">
              <?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          </p>

          <p><strong>著者：</strong><?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?></p>
          <p><strong>ジャンル：</strong><?= htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8') ?></p>
          <p><strong>価格：</strong><?= $book['price'] ?>円</p>
          <p><strong>ステータス：</strong>
            <?= $book['book_status'] == 0 ? '販売中' : '停止中' ?>
          </p>
          <p><strong>登録日：</strong><?= $book['register_date'] ?></p>
        </div>

        <!-- 書籍操作ボタン -->
        <div class="column is-narrow has-text-right book-buttons">

          <!-- 編集ボタン -->
          <form action="edit_book.php" method="get">
            <input type="hidden" name="id" value="<?= $book['book_id'] ?>">
            <button type="submit" class="button is-light is-rounded is-large">
              <span class="icon"><i class="fas fa-edit"></i></span>
            </button>
            <p>書籍情報を編集</p>
          </form>

        </div>

      </div>
    </div>
    <?php endforeach; ?>

  </div>

  <!-- ホームに戻る -->
  <div class="has-text-right mt-5">
    <form action="super_admin_home.php" method="POST">
      <button class="button is-dark">
        <span class="icon"><i class="fas fa-home"></i></span>
        <span>ホームに戻る</span>
      </button>
    </form>
  </div>
</section>

</body>
</html>