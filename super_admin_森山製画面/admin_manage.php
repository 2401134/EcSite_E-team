<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者管理</title>
    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .review-card { border: 1px solid #dbdbdb; }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>
    <?php require 'menu.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">管理者管理</h1>

            <!-- 新規管理者追加ボタン -->
            <div class="admin_add">
                <div class="columns is-flex is-justify-content-flex-end mb-2">
                    <div class="column is-narrow">
                        <form action ="rcest.php" method="post">
                            <button type="submit" class="button is-black is-medium">
                                <span>新規管理者追加<span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 管理人情報（横並び） -->
            <div class="box admin-info">
                <div class="columns is-vcentered mb-2">
                    <!-- 管理者アイコン -->
                    <span class="icon is-large has-text-grey" style=" border: 1px solid #4a4a4a; border-radius:45%;padding:2em;">
                        <i class="fas fa-user fa-2x"></i>
                    </span>
                
                    <!--管理者名、管理者ID-->
                
                    <div class="column is-narrow">
                        <strong>(管理者名)</strong>
                    </div>
                
                    <div class="column is-narrow">
                        <small>（管理者ID）</small></p>
                    </div>
                </div>

                <!-- ボタン群 -->
                <div class="history_browse is-flex is-justify-content-flex-end">
                    <form action ="#" method="post" class="mr-4">
                        <button type="submit" class="button is-primary is-light is-rounded">
                            <span class="icon is-normal"><i class="fas fa-plus"></i></span>
                            <span>総合管理者権限を付与</span>
                        </button>
                    </form>

                    <form action="#" method="post" class="mr-4">
                        <button type="submit" class="button is-danger is-light is-rounded">
                            <span class="icon is-normal"><i class="fas fa-trash"></i></span>
                            <span>管理者権限を削除</span>
                        </button>
                    </form>

                </div>

            </div>

        </div>

        <br>

        <div class="container">

          <!-- 管理人情報（横並び） -->
            <div class="box admin-info">
                <div class="columns is-vcentered mb-2">
                    <!-- 管理者アイコン -->
                    <span class="icon is-large has-text-grey" style=" border: 1px solid #4a4a4a; border-radius:45%;padding:2em;">
                        <i class="fas fa-user fa-2x"></i>
                    </span>
                
                    <!--管理者名、管理者ID-->
                
                    <div class="column is-narrow">
                        <strong>(管理者名)</strong>
                    </div>
                
                    <div class="column is-narrow">
                        <small>（管理者ID）</small></p>
                    </div>
                </div>

                <!-- ボタン群 -->
                <div class="history_browse is-flex is-justify-content-flex-end">
                    <form action ="#" method="post" class="mr-4">
                        <button type="submit" class="button is-primary is-light is-rounded">
                            <span class="icon is-normal"><i class="fas fa-plus"></i></span>
                            <span>総合管理者権限を付与</span>
                        </button>
                    </form>

                    <form action="#" method="post" class="mr-4">
                        <button type="submit" class="button is-danger is-light is-rounded">
                            <span class="icon is-normal"><i class="fas fa-trash"></i></span>
                            <span>管理者権限を削除</span>
                        </button>
                    </form>

                </div>

            </div>

            <!-- ホームに戻る -->
            <div class="has-text-right mt-5">
                <a href="super_admin_home.php" class="button is-black">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span>ホームに戻る</span>
                </a>
            </div>

        </div>
    </section>

    <?php require 'footer.php'?>
</body>
</html>