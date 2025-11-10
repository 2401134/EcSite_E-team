<?php session_start() ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログ管理</title>
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
            <h1 class="title">ログ管理</h1>

            <!-- ソートセレクトボックス -->

            <div class="sort-select">
                <div class="field has-addons is-justify-content-flex-end">

                    <p class=control>
                        <span class="select is-small mr-4">
                            <select>
                                <option>顧客に対する操作</option>
                                <option>管理者に対する操作</option>
                            </select>
                        </span>
                    </p>

                    <p class=control>
                        <span class="select is-small mr-4">
                            <select>
                                <option>日時順</option>
                                <option>作業者順</option>
                                <option>操作内容順</option>
                                <option>作業ID</option>
                            </select>
                        </span>
                    </p>

                    <p class="control">
                        <button class="button is-small is-info">
                            <span class="icon"><i class="fas fa-sort"></i></span>
                            <span>ソート</span>
                        </button>
                    </p>

                </div>        
            </div>

            <!-- ログ一覧 -->

            <div class="log-box">
                <table class="table is-fullwidth is-striped is-hoverable">
                    <thead>
                        <tr>
                            <th>日時</th>
                            <th>作業者</th>
                            <th>作業対象</th>
                            <th>操作内容</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>2025-11-10 09:55</td>
                            <td>森山</td>
                            <td>顧客(ID)</td>
                            <td>不適切なコメントの消去</td>
                        </tr>

                        <tr>
                            <td>2025-11-10 09:50</td>
                            <td>森山</td>
                            <td>顧客(ID)</td>
                            <td>ログイン履歴確認</td>
                        </tr>

                        <tr>
                            <td>2025-11-10 09:40</td>
                            <td>森山</td>
                            <td>顧客(ID)</td>
                            <td>不審なユーザーのBAN</td>
                        </tr>
                    </tbody>                    
                </table>
            </div>

        </div>
    </section>

    <?php require 'footer.php'?>
</body>
</html>