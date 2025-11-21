<?php
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// URLパラメータから id を取得
$book_id = $_GET['id'] ?? null;

if (!$book_id) {
    echo "IDが指定されていません。";
    exit;
}

// データベースから該当書籍を取得
$sql = "SELECT * FROM books WHERE book_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $book_id, PDO::PARAM_INT);
$stmt->execute();

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo "書籍が見つかりません。";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>書籍編集</title>
<!-- Bulma -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="admin_function/edit_book_script.js" defer></script>
</head>
<body>

    <?php require 'header.php'?>
    <?php require 'menu.php'?>

    <section>
        <div class="container">
            <h1 class="title">書籍の編集</h1>

            <form action="update_book_action.php" method="post" enctype="multipart/form-data">

                <!-- 編集対象のID -->
                <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">

                <!--タイトル-->
                <div class="field">
                    <label class="label">タイトル：</label>
                    <div class="control">
                        <input type="text"
                            name="title"
                            value="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>"
                            required>
                    </div>
                </div>

                <!--著者-->
                <div class="field">
                    <label class="label">著者：</label>
                    <div class="control">
                        <input type="text"
                        name="author"
                        value="<?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?>"
                        required>
                    </div>
                </div>

                <!--ジャンル-->
                <div class="field">
                    <label class="label">ジャンル（カンマ区切り）：</label>
                    <div class="control">
                        <input type="text"
                            name="genre"
                            value="<?= htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8') ?>"
                            required>
                    </div>
                </div>

                <!--価格-->
                <div class="field">
                    <label class="label">価格：</label>
                    <div class="control">
                        <input type="number"
                            name="price"
                            value="<?= $book['price'] ?>"
                            required>
                    </div>
                </div>

                <!--あらすじ-->
                <div class="field">
                    <label class ="label">あらすじ：</label>
                    <div class="control">
                        <textarea name="synopsis" rows="5" cols="40" required><?= htmlspecialchars($book['synopsis'], ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                </div>

                <!--表紙-->
                <div class="field">
                    <label class="label">【現在の表紙画像】</label>
                    <?php if (!empty($book['book_image'])): ?>
                        <figure class="image is-128x128">
                            <img src="<?= $book['book_image'] ?>">
                        </figure>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label class="label">新しい表紙画像（変更する場合のみ）</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <label class="file-label">
                            <input class="file-input"
                                type="file"
                                id="book_image_input"
                                name="book_image"
                                accept=".png"
                                onchange="showFileName(this, 'book_image_name')">
                        <span class="file-cta">
                            <span class="file-icon"><i class="fas fa-upload"></i></span>
                            <span class="file-label">ファイルを選択</span>
                        </span>
                        <span id="book_image_name" class="file-name" aria-live="polite">
                            選択されていません
                        </span>
                    </div>
                </div>


                <br>

                <!--サンプルデータ-->
                <div class="field">
                    <label class="label">【現在のサンプルデータ】</label>
                    <p class="help">
                        <?= htmlspecialchars($book['sample'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <div class="field">
                    <label class="label">新しいサンプルデータ（変更する場合のみ）</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input"
                                type="file"
                                id="book_sample_input"
                                name="book_sample"
                                accept=".pdf"
                                onchange="showFileName(this, 'book_sample_name')"
                            >
                        <span class="file-cta">
                            <span class="file-icon"><i class="fas fa-upload"></i></span>
                            <span class="file-label">ファイルを選択</span>
                        </span>
                        <span id="book_sample_name" class="file-name" aria-live="polite">
                            選択されていません
                        </span>
                        </label>
                    </div>
                </div>

                <br>

                <!--電子書籍本体データ-->
                <div class="field">
                    <label class="label">【現在の電子書籍】</label>
                    <p class="help">
                        <?= htmlspecialchars($book['e_book'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <div class="field">
                    <label class="label">新しい電子書籍データ（変更する場合のみ）</label>
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input"
                                type="file"
                                id="book_e-book_input"
                                name="book_e-book"
                                accept=".pdf"
                                onchange="showFileName(this, 'book_e-book_name')"
                            >
                        <span class="file-cta">
                            <span class="file-icon"><i class="fas fa-upload"></i></span>
                            <span class="file-label">ファイルを選択</span>
                        </span>
                        <span id="book_e-book_name" class="file-name" aria-live="polite">
                            選択されていません
                        </span>
                        </label>
                    </div>
                </div>


                <br>

                <!--販売ステータス-->
                <div class="field">
                    <label class="label">販売ステータス：</label>
                    <div class="control">
                        <div class="select">
                            <select name="book_status">
                                <option value="0" <?= ($book['book_status'] == 0) ? 'selected' : '' ?>>販売中</option>
                                <option value="1" <?= ($book['book_status'] == 1) ? 'selected' : '' ?>>停止中</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <!--更新ボタン-->
                <div class="field is-grouped is-justfity-content-flex-end mt-5">
                    <div class="control">
                        <button type="submit" class="button is-primary is-medium">
                            <span class="icon"><i class="fas fa-save"></i></span>
                            <span>更新する</span>
                        </button>
                    </div>
                </div>

                <br>

            </form>
        </div>

    </section>

    <?php require 'footer.php'?>

</body>
</html>