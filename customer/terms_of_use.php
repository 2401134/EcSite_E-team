<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用規約</title>

    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<section class="section">

    <div class="container">

        <h1 class="title has-text-centered mb-6">【利用規約】</h1>

        <p class="has-text-centered mb-6">
            本規約は、本サイト（以下「当サイト」）の利用条件を定めるものです。<br>
            利用者は、本規約に同意したうえで当サイトを利用するものとします。
        </p>

        <div class="columns has-text-centered is-centered">
            <div class="column is-8">
                <h2 class="subtitle has-text-left mt-5">第1条（適用）</h2>
                <p class="has-text-left mb-6">
                    本規約は、当サイトの利用に関する一切に適用されます。
                </p>

                <h2 class="subtitle has-text-left mt-5">第2条（禁止事項）</h2>
                <p class="has-text-left mb-6">
                    利用者は、以下の行為をしてはなりません。
                </p>

                <div class="content">
                    <ul class="has-text-left mb-6">
                        <li>法令または公序良俗に反する行為</li>
                        <li>他者の権利を侵害する行為</li>
                        <li>虚偽の情報を送信する行為</li>
                        <li>当サイトの運営を妨害する行為</li>
                    </ul>
                </div>

                <h2 class="subtitle has-text-left mt-5">第3条（商品購入）</h2>
                <p class="has-text-left mb-6">
                    利用者は、当サイトの表示に従い商品申込みを行うものとします。入力内容に誤りがあった場合でも、当サイトは責任を負いません。
                </p>

                <h2 class="subtitle has-text-left mt-5">第4条（返品・キャンセル）</h2>
                <p class="has-text-left mb-6">
                    原則として、購入後の返品・キャンセルは受け付けません。ただし、当サイトが認める場合はこの限りではありません。
                </p>

                <h2 class="subtitle has-text-left mt-5">第5条（免責事項）</h2>
                <p class="has-text-left mb-6">
                    当サイトは、利用者が当サイトを利用することで生じた損害について、一切責任を負いません。
                </p>

                <h2 class="subtitle has-text-left mt-5">第6条（規約の変更）</h2>
                <p class="has-text-left mb-6">
                    当サイトは、必要に応じて本規約を変更できるものとします。変更後の規約は、当サイトに掲載された時点で効力を生じます。
                </p>

                <p class="has-text-left">
                    以上
                </p>
            </div>
        </div>

    </div>

</section>

<?php require 'footmenu.php'; ?>
<?php require 'footer.php'; ?>

</body>
</html>
