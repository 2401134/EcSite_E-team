<?php
session_start();
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// 仮のログインユーザーID（ログイン未実装なら固定値）
$user_id = $_SESSION['user_id'] ?? 1;

try {
    // 🔹 favorites × books × purchases を結合して購入情報を取得
    $sql = "SELECT 
                b.book_id, 
                b.title, 
                b.synopsis, 
                b.sample,
                p.purchase_date
            FROM favorites f
            JOIN books b ON f.book_id = b.book_id
            LEFT JOIN purchases p 
                ON f.book_id = p.book_id 
                AND p.user_id = f.user_id
            WHERE f.user_id = :user_id
            AND f.favorite_status = 0 
            ORDER BY f.favorite_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "データベースエラー: " . htmlspecialchars($e->getMessage());
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り</title>
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
      <h1 class="title has-text-left mb-5">お気に入り</h1>
    <?php if (!empty($favorites)){ ?>
    <?php foreach ($favorites as $book){ ?>
      
                     <!-- 右：購入情報 -->
                <div class="column is-narrow has-text-right">
                    <?php if (!empty($book['purchase_date'])){ ?>
                        <p class="is-size-7"><?= htmlspecialchars($book['price'] ?? '') ?>円</p>
                        <p class="is-size-7"><?= htmlspecialchars(date('Y年m月d日', strtotime($book['purchase_date']))) ?>に購入</p>
                    <?php }else{ ?>
                        <p class="is-size-7">この商品は未購入です</p>
                        <form action="purchase.php" method="POST">
                            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                            <button class="button is-dark">
                                <span>購入する</span>
                            </button> 
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php }else{ ?>
    <p>お気に入りはまだ登録されていません。</p>
<?php } ?>

      <!-- 🏠 ホームに戻る -->
       <div class="has-text-right mt-5">
        <form action="customer_home.php" method="POST">
        <button class="button is-dark">
          <span class="icon"><i class="fas fa-home"></i></span>
          <span>ホームに戻る</span>
        </button> 
        </form>  
        </div>
    </div>
  </section>
  <?php require 'footmenu.php'; ?>
  <?php require 'footer.php'; ?>
</body>
</html>