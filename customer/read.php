<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍閲覧</title>

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

        <!--ここに後でPDF入れる-->
        <div class="box has-text-centered">
            <p class="has-text-grey">ここに電子書籍PDFが表示されます</p>
        </div>

    </div>

    <!--本棚に戻る-->

    <div class="has-text-right mt-5">
        <form action="bookshelf.php" method="POST">
            <input type="hidden" name="action" value="home">
            <button class="button is-dark">
                <span class="icon"><i class="fas fa-book"></i></span>
                <span>本棚に戻る</span>
            </button>
        </form>
    </div>

    <!-- ホームに戻るボタン -->

    <div class="has-text-right mt-5">
        <form action="customer_home.php" method="POST">
            <input type="hidden" name="action" value="home">
            <button class="button is-dark">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span>ホームに戻る</span>
            </button>
        </form>
    </div>

</section>

<?php require 'footmenu.php'; ?>
<?php require 'footer.php'; ?>

</body>
</html>
