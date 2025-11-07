<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>顧客ホーム画面</title>
  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php require 'header.php'; ?>
  <?php require 'menu.php'; ?> 
  <section class="section">
  <div class="container">
    <div class="columns is-multiline">
     <?php
      try {
          // 🔹 booksテーブルからデータを取得
          $sql = "SELECT book_id, title, synopsis, sample FROM books";
          $stmt = $pdo->query($sql);

          // 🔹 1件ずつ表示
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $book_id = htmlspecialchars($row['book_id'], ENT_QUOTES, 'UTF-8');
              $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
              $synopsis = htmlspecialchars($row['synopsis'], ENT_QUOTES, 'UTF-8');
              $image_path = !empty($row['sample']) ? htmlspecialchars($row['sample'], ENT_QUOTES, 'UTF-8') : 'images/sample.jpg';
      ?>
      <div class="column is-one-third">
        <div class="card">
          <div class="card-image">
            <figure class="image is-3by4">
              <img src="images/sample.jpg" alt="小説の表紙">
            </figure>
          </div>
          <div class="card-content">
            <p class="title is-6">(小説の題名)</p>
            <p class="subtitle is-7">(簡単なあらすじ)</p>
              <div class="level-right">
                <!--お気に入り登録-->
                 <form action="favorite-add.php" method="POST" style="display:inline;">
                  <button type="submit" name="book_id" value="<?= $i ?>" 
                    class="button is-white is-rounded" title="お気に入り登録">
                    <span class="icon">
                      <i class="far fa-star"></i>
                    </span>
                  </button>
                </form>
                <!--レビュー画面へ遷移-->
                <form action="review.php" method="get" style="display:inline;">
                  <button type="submit" class="button is-white is-normal">
                    <span class="icon">
                      <i class="far fa-comment"></i>
                    </span>
                  </button>
                </form>
               </div>
          </div>
        </div>
      </div>
      <?php
          } // while 終了
      } catch (PDOException $e) {
          echo "<p>データベースエラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
      }
      ?>
    </div>
  </div>
</section>
<?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>
