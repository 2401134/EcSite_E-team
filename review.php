<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>レビュー画面</title>
  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
     .review-card { border: 1px solid #dbdbdb; }
  </style>
</head>
<body>
  <section class="section">
    <div class="container">
      <h1 class="title has-text-left">この作品のレビュー</h1>

      <!-- レビューを書くボタン -->
      <div class="has-text-left mb-4">
        <form action="review_write.php" method="POST"> 
          <button type="submit" class="button is-black is-normal">
          <span class="icon"><i class="fas fa-pen"></i></span>
          <span>レビューを書く</span>
          </button>
        </form>
      </div>

      <!-- レビューカード（横並び） -->
    <div class="box review-card">
        <!-- ユーザーアイコン -->
                  <span class="icon is-large has-text-grey" style=" border: 1px solid #4a4a4a; border-radius:45%;padding:2em;">
                    <i class="fas fa-user fa-2x"></i>
                  </span>
          <!-- 星評価 -->
          <span class="icon"><i class="fas fa-star"></i></span> 
          <span class="icon"><i class="fas fa-star"></i></span> 
          <span class="icon"><i class="fas fa-star"></i></span> 
          <span class="icon"><i class="fas fa-star"></i></span> 
          <span class="icon"><i class="fas fa-star"></i></span>
          
          <strong>とてもいい作品でした。</strong><br>
          <p class="has-text-centered"><small>（レビュー本文）</small></p>
        <!-- 通報ボタン -->
        <div class="review-report has-text-right">
            <button class="button is-normal is-light is-rounded">
                <span class="icon is-normal"><i class="fas fa-exclamation-triangle"></i></span>
            </button><br>
            <span class="is-size-7 mt-1">このユーザーを通報する</span><br>
            <span class="is-size-7"><strong>（ユーザーID）</strong></span>
        </div>
      </div>

      <!-- ホームに戻る -->
      <div class="has-text-right mt-5">
        <a href="customer_home.php" class="button is-black">
          <span class="icon"><i class="fas fa-home"></i></span>
          <span>ホームに戻る</span>
        </a>
      </div>
    </div>
  </section>
</body>
</html>