<?php session_start() ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
      <?php require 'header.php'?>
        <?php require 'menu.php'?>
        <section class="section">
        <div class="container">
            <h1 class="title is-left">このユーザーの購入履歴</h1>
            <div class="box">
                <div class="columns is-vcentered">
            <!-- 左：表紙画像 -->
            <div class="column is-narrow">
                <figure class="image is-3by4" style="width: 80px; border: 1px solid #4a4a4a;">
                    <img src="images/sample.jpg" alt="小説の表紙">
                </figure>
            </div>

            <div class="column">
                 <p class="title is-6">（小説の題名）</p>
                 <p class="subtitle is-7">（簡単なあらすじ）</p>
            </div>
            <div class="column is-narrow">
                <div class="is-flex is-align-items-center mb-2">
                <!-- 価格表示 -->
                    <div class="has-text-weight-bold mr-2">〇〇〇〇円</div>
                </div>
            </div>
            </div>
            </div>
</body>
</html>