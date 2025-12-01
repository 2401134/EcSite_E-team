<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お支払方法について</title>

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

        <h1 class="title has-text-centered mb-6">【お支払方法】</h1>

        <p class="has-text-centered mb-6">
            当サイトでは、以下のお支払方法をご利用いただけます。
        </p>

        <div class="columns has-text-centered is-centered">
            <div class="column is-8">
                <div class="content">
                    <ul class="has-text-left mb-6">
                        <li>クレジットカード（VISA / MasterCard / JCB / American Express）</li>
                        <li>銀行振込</li>
                        <li>コンビニ決済</li>
                        <li>その他、当サイトが定める決済方法</li>
                    </ul>
                </div>

                <p class="has-text-left mb-6">
                    ※ご利用可能な決済手段は予告なく変更される場合があります。
                </p>

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
