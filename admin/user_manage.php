<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理</title>
    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .review-card { border: 1px solid #dbdbdb; }
    </style>
</head>
<body>
    <?php require 'header.php'?>
    <?php require 'menu.php'?>

    <section class="section">
        <div class="container">
            <h1 class="title">ユーザー管理</h1>

          <!-- ユーザー情報（横並び） -->
            <div class="box user-info">
                <div class="columns is-vcentered mb-2">
                    <!-- ユーザーアイコン -->
                    <span class="icon is-large has-text-grey" style=" border: 1px solid #4a4a4a; border-radius:45%;padding:2em;">
                        <i class="fas fa-user fa-2x"></i>
                    </span>
                
                    <!--ユーザー名、ユーザーID-->
                
                    <div class="column is-narrow">
                        <strong>(ユーザー名)</strong>
                    </div>
                
                    <div class="column is-narrow">
                        <small>（ユーザーID）</small></p>
                    </div>
                </div>

                <!-- ユーザーの購入履歴とレビュー履歴が見れるボタン -->
                <div class="history_browse is-flex is-justify-content-flex-end">
                    <form action ="purchase_history.php" method="post" class="mr-4">
                        <button type="submit" class="button is-normal is-light">
                            <span class="icon is-normal"><i class="fas fa-shopping-cart"></i></span>
                            <span>購入履歴</span>
                        </button>
                    </form>

                    <form action="user_review_manage.php" method="post">
                        <button class="button is-normal is-light">
                            <span class="icon is-normal"><i class="fas fa-comment-dots"></i></span>
                            <span>レビュー履歴</span>
                        </button>
                    </form>

                </div>

            </div>

        </div>

        <br>

        <div class="container">

          <!-- ユーザー情報（横並び） -->
            <div class="box user-info">
                <div class="columns is-vcentered mb-2">
                    <!-- ユーザーアイコン -->
                    <span class="icon is-large has-text-grey" style=" border: 1px solid #4a4a4a; border-radius:45%;padding:2em;">
                        <i class="fas fa-user fa-2x"></i>
                    </span>
                
                <!--ユーザー名、ユーザーID-->
                
                    <div class="column is-narrow">
                        <strong>(ユーザー名)</strong>
                    </div>
                
                    <div class="column is-narrow">
                        <small>（ユーザーID）</small></p>
                    </div>
                </div>

                <!-- ユーザーの購入履歴とレビュー履歴が見れるボタン -->
                <div class="history_browse is-flex is-justify-content-flex-end">
                    <form action ="purchase_history.php" method="post" class="mr-4">
                        <button type="submit" class="button is-normal is-light">
                            <span class="icon is-normal"><i class="fas fa-shopping-cart"></i></span>
                            <span>購入履歴</span>
                        </button>
                    </form>

                    <form action="user_review_manage.php" method="post">
                        <button class="button is-normal is-light">
                            <span class="icon is-normal"><i class="fas fa-comment-dots"></i></span>
                            <span>レビュー履歴</span>
                        </button>
                    </form>

                </div>

            </div>

            <!-- ホームに戻る -->
            <div class="has-text-right mt-5">
                <a href="admin_home.php" class="button is-black">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span>ホームに戻る</span>
                </a>
            </div>

        </div>
    </section>

    <?php require 'footer.php'?>
</body>
</html>