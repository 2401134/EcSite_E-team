<?php session_start() ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>書籍登録</title>
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
            <h1 class="title">書籍の新規登録</h1>

            <form action="admin_function/add_book_action.php" method="post" enctype="multipart/form-data">
                <div class="field">
                    <label class="label">タイトル：</label>
                    <div class="control">
                        <input type="text" name="title" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">著者：</label>
                    <div class ="control">
                        <input type="text" name="author" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">ジャンル(複数は , 区切り)：</label>
                    <div class="control">
                        <input type="text" name="genre" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">価格：</label>
                    <div class="control">
                        <input type="number" name="price" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">あらすじ：</label>
                    <div class="control">
                        <textarea name="synopsis" rows="5" cols="40" required></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">表紙画像：</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input" type="file" name="book_image" accept="image/*" required>
                            <span class="file-cta">
                                <span class="file-icon"><i class="fas fa-upload"></i></span>
                                <span class="file-label">ファイルを選択</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label class="label">サンプルデータ(PDF等)：</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input" type="file" name="sample" required>
                            <span class="file-cta">
                                <span class="file-icon"><i class="fas fa-upload"></i></span>
                                <span class="file-label">ファイルを選択</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label class="label">電子書籍データ(PDF等)：</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input" type="file" name="e_book" required>
                            <span class="file-cta">
                                <span class="file-icon"><i class="fas fa-upload"></i></span>
                                <span class="file-label">ファイルを選択</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="field is-grouped is-justify-content-flex-end mt-5">
                    <div class="control">
                        <button type="submit" class="button is-primary is-medium">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>登録する</span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>

    <?php require 'footer.php'?>
</body>
</html>