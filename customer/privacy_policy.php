<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プライバシーポリシー</title>

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

        <h1 class="title has-text-centered mb-6">【プライバシーポリシー】</h1>

        <p class="has-text-centered mb-6">
            当サイト「BookNest」では、サービス提供のため、ユーザーの氏名・住所・メールアドレス・決済情報などの個人情報を取得する場合があります。
        </p>

        <div class="columns has-text-centered is-centered">
            <div class="column is-8">

                <p class="has-text-left mb-4">
                    取得した個人情報は、以下の目的で利用します。
                </p>

                <div class="content">
                    <ul class="has-text-left mb-6">
                        <li>商品の発送やサービス提供のため</li>
                        <li>決済処理のため</li>
                        <li>お問い合わせ対応のため</li>
                        <li>サービス改善やお知らせのため</li>
                    </ul>
                </div>

                <p class="has-text-left mb-6">
                    当サイトは、以下の場合を除き、個人情報を第三者に提供しません。
                </p>

                <div class="content">
                    <ul class="has-text-left mb-6">
                        <li>ユーザーの同意がある場合</li>
                        <li>法令に基づく場合</li>
                        <li>配送業者や決済会社など、必要な業務委託を行う場合</li>
                    </ul>
                </div>

                <p class="has-text-left">
                    個人情報は安全に管理し、不正アクセスや漏洩を防ぐための適切な対策を講じます。
                </p>

                <br>

                <p class="has-text-left">
                    ユーザーは、当サイトが保有する自身の個人情報について、開示・訂正・削除を求めることができます。ご希望の場合はお問い合わせフォームよりご連絡ください。
                </p>

                <br>

                <p class="has-text-left">
                    本ポリシーは必要に応じて内容を更新することがあります。
                </p>

                <br><br>

                <p class="has-text-left">
                    以上
                </p>
            </div>
            
        </div>


        <div class="has-text-right mt-5">
            <form action="customer_home.php" method="POST">
                <input type="hidden" name="action" value="home">
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
