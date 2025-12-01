<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error_message = '';

// ---------- 入力受け取り ----------
$keyword = $_GET['keyword'] ?? '';
$mode = $_GET['mode'] ?? 'title';

// ---------- ボタン押下判定 ----------
$search_started =
    isset($_GET['author']) ||
    isset($_GET['genre']) ||
    isset($_GET['price']) ||
    isset($_GET['title']) ||
    isset($_GET['keyword']);

// ---------- モード切替（ボタン押した時だけ） ----------
if (isset($_GET['author'])) {
    $mode = 'author';
} else if (isset($_GET['genre'])) {
    $mode = 'genre';
} else if (isset($_GET['price'])) {
    $mode = 'price';
}else if (isset($_GET['title'])) {
    $mode = 'title';
}

// ---------- 検索処理 ----------
$books = [];
if ($search_started) {
    if ($error_message === '') {
        $sql = "SELECT * FROM books WHERE book_status = 0";
        $params = [];

        if ($keyword !== '') {
            switch ($mode) {
                case 'author':
                    $sql .= " AND author LIKE :keyword";
                    $params[':keyword'] = "%{$keyword}%";
                    break;
                case 'genre':
                    $sql .= " AND genre LIKE :keyword";
                    $params[':keyword'] = "%{$keyword}%";
                    break;
                case 'price':
                    if ($keyword !== '') {
                        if (is_numeric($keyword)) {
                            $sql .= " AND price <= :keyword";
                            $params[':keyword'] = $keyword;
                        } else {
                            $error_message = '価格検索では数値を入力してください。';
                        }
                    }
                    break;
                default: // title
                    $sql .= " AND title LIKE :keyword";
                    $params[':keyword'] = "%{$keyword}%";
                    break;
            }
        }

        $sql .= " ORDER BY register_date DESC";
        $stmt = $pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$favorites = [];
?>

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
      <h1 class="title" style="text-align: left; margin-left: 20%;">書籍検索</h1>

      <!-- 検索フォーム -->
      <form method="get">
        <input type="hidden" name="mode"
               value="<?= htmlspecialchars($mode, ENT_QUOTES, 'UTF-8') ?>">

        <?php if ($error_message): ?>
          <div class="notification is-danger is-light">
            <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?>
          </div>
        <?php endif; ?>

        <!-- 🔍検索バー -->
        <div class="columns is-centered mt-5 mb-5">
          <div class="column is-two-thirds">
            <div class="field">
              <p class="control has-icons-left">
                <input class="input" type="text" name="keyword"
                       placeholder="search"
                       value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
                       style="border-radius: 12px;">
                <span class="icon is-small is-left">
                  <i class="fas fa-search"></i>
                </span>
              </p>
            </div>
          </div>
        </div>

        <!-- 🔘 ボタン（customer_home の見た目維持） -->
        <div class="columns is-centered is-multiline">
          <div class="column is-narrow">
          <button class="button is-large <?= $mode === 'title' ? 'is-info' : '' ?>"
                  type="submit" name="title">タイトル検索</button>
          </div>
          <div class="column is-narrow">
            <button class="button is-large <?= $mode === 'author' ? 'is-info' : '' ?>"
                    type="submit" name="author">著者検索</button>
          </div>
          <div class="column is-narrow">
            <button class="button is-large <?= $mode === 'genre' ? 'is-info' : '' ?>"
                    type="submit" name="genre">ジャンル検索</button>
          </div>
          <div class="column is-narrow">
            <button class="button is-large <?= $mode === 'price' ? 'is-info' : '' ?>"
                    type="submit" name="price">価格検索</button>
          </div>
        </div>
      </form>

      <!-- 📚 検索結果 -->
      <?php if ($search_started && $error_message === ''): ?>
      <hr>

      <div class="columns is-multiline">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $row): 
                $book_id = (int)$row['book_id'];
                $title   = $row['title'];
                $synopsis = $row['synopsis'];
                $price    = $row['price'];

                // 画像
                if (empty($row['book_image'])) {
                  $image_path = "";
                } else {
                  $image_path = $row['book_image'];
                }

                $is_fav = in_array($book_id, $favorites);
            ?>
            <div class="column is-one-third">
              <div class="card">

                <!-- 📕画像 -->
                <div class="card-image">
                  <figure class="image is-3by4">
                    <img src="<?= $image_path ?>" alt="本の表紙">
                  </figure>
                </div>

                <!-- 📄 内容 -->
                <div class="card-content">
                  <p class="title is-6"><?= htmlspecialchars($title) ?></p>
                  <p class="subtitle is-7"><?= htmlspecialchars($synopsis) ?></p>

                  <p class="has-text-weight-bold">価格：<?= htmlspecialchars($price) ?>円</p>

                  <div class="level-right">

                    <!-- ⭐お気に入り -->
                    <form action="favarit.php" method="POST" style="display:inline;">
                      <input type="hidden" name="book_id" value="<?= $book_id ?>">
                      <button type="submit" class="button is-white is-rounded" title="お気に入り登録">
                        <span class="icon">
                          <i class="<?= $is_fav ? 'fas fa-star has-text-dark' : 'far fa-star' ?>"></i>
                        </span>
                      </button>
                    </form>

                    <!-- 💬レビュー -->
                    <form action="review.php" method="GET" style="display:inline;">
                      <input type="hidden" name="book_id" value="<?= $book_id ?>">
                      <button type="submit" class="button is-white is-normal">
                        <span class="icon"><i class="far fa-comment"></i></span>
                      </button>
                    </form>

                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
          <p class="has-text-centered">該当する書籍が見つかりませんでした。</p>
        <?php endif; ?>
      </div>

      <?php endif; ?>

      <!-- 戻るボタン -->
      <div class="has-text-right mt-4">
        <button class="button is-large is-black" onclick="location.href='customer_home.php'">
          <span class="icon"><i class="fas fa-home"></i></span>
          <span>ホームに戻る</span>
        </button>
      </div>

    </div>
  </section>

  <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>