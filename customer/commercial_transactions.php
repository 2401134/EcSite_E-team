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

        <div class="container">

        
            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">販売事業者</h2>
                        <p>株式会社BookNest</p>
                    </div>
                </div>
            </div>

        
            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">運営責任者</h2>
                        <p>Eチーム</p>
                    </div>
                </div>
            </div>

        
            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">所在地</h2>
                        <p>〒000-0000<br>福岡県〇〇区〇〇0-0-0</p>
                    </div>
                </div>
            </div>

        
            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">電話番号</h2>
                        <p>000-0000-0000</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">メールアドレス</h2>
                        <p>info@exanple.com</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">販売価格</h2>
                        <p>商品ごとに表示された税込み価格となります。</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">商品代金以外の必要料金</h2>
                        <p>通信料（インターネット接続料金等）はお客様負担となります。</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">支払方法</h2>
                        <div class="content">
                            <ul>
                                <li>クレジットカード決済</li>
                                <li>コンビニ決済</li>
                                <li>銀行振込</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">代金の支払時期</h2>
                        <p>各決済方法の規定に基づきます。</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">商品の引き渡し時期</h2>
                        <p>電子書籍の場合、決済完了後すぐに閲覧可能となります。</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">返品・キャンセルについて</h2>
                        <p>電子書籍という商品の特性上、購入後の返品・キャンセルはお受けできません。<br>
                        ただし、データ不備等があった場合はお問い合わせください。</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">動作環境</h2>
                        <p>商品ページに記載された閲覧環境に準じます。</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="media">
                    <div class="media-left">
                        <span class="icon">
                            <i class="fas fa-square"></i>
                        </span>
                    </div>
                    <div class="media-content">
                        <h2 class="subtitle mb-1">特別な販売条件</h2>
                        <p>アクセス集中やシステム障害等により、サービスを一時停止する場合があります。</p>
                    </div>
                </div>
            </div>

            <p class="has-text-left mt-5">以上</p>

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
