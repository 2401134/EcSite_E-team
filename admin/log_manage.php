<?php require 'admin_function/logs.php' ?>

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
            <form method="GET" class="sort-select field has-addons is-justify-content-flex-end mb-5">
            <!-- ソートセレクトボックス -->
                    <p class=control>
                        <span class="select is-small mr-4">
                            <select name="filter">
                                <option value="user"<?= $filter=='user'?'selected':'' ?>>顧客に対する操作</option>
                                <option value="admin"<?= $filter=='admin'?'selected':'' ?>>管理者に対する操作</option>
                            </select>
                        </span>
                    </p>

                    <p class=control>
                        <span class="select is-small mr-4">
                            <select>
                                <option value="date"<?= $sort=='date'?'selected':'' ?>>日時順</option>
                                <option value="user"<?= $sort=='user'?'selected':'' ?>>作業者順</option>
                                <option value="action"<?= $sort=='action'?'selected':'' ?>>操作内容順</option>
                                <option value="id"<?= $sort=='id'?'selected':'' ?>>作業ID</option>
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
                        <?php foreach($logs as $log){ ?>
                        <tr>
                            <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($log['log_date']))) ?></td>
                            <td><?= htmlspecialchars($log['user_name']) ?></td>
                            <td><?= htmlspecialchars($log['target']) ?></td>
                            <td><?= htmlspecialchars($log['action']) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>                 
                </table>
            </div>

        </div>

        <!--ホームに戻る-->
        <div class="has-text-right mt-5">
            <form action="admin_home.php" method="POST">
                <button class="button is-dark">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span>ホームに戻る</span>
                </button> 
            </form>  
        </div>

    </section>

    <?php require 'footer.php'?>
</body>
</html>