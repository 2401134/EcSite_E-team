<?php
session_start();
require 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>特定商取引法表示について</title>

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

        <h1 class="title has-text-centered mb-6">【特定商取引法に基づく表記】</h1>

        <div class="columns has-text-centered is-centered">

            <div class="columns is-multiline is-centered is-variable is-4">

                <span class="icon"><i class="fas fa-square"><h2 class="subtitle has-text-left mt-5">販売事業者</h2></i></span>

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
