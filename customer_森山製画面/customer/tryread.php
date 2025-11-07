<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>試し読み</title>
</head>
    <body>
        <?php require 'header.php'; ?>
        <?php require 'menu.php'; ?>

        <section class="tryread section">

            <div class="container">

                <h1 class = "title has-text-left mb-6">
                    試し読みできる小説
                </h1>

                <p class="has-text-left mb-6">指定されたページまで試し読みできます！<br>
                気になったらぜひ購入してみてください！</p>

            

                <div class="box">
                    <div class="columns is-vcentered">
                
                        <div class="column is-2">
                        <figure class="image is-3by4">
                            <img src="image/hyousi1.png" alt="雨とパレット">
                        </figure>
                        </div>

                
                        <div class="column">
                            <h2 class="title is-5">
                                (小説の題名)
                            </h2>
                            <p>(簡単なあらすじ)</p>

                    
                            <div class="columns is-mobile is-vcentered is-justify-content-flex-end mb-2">

                                <!--試し読みボタン。本文試し読みに遷移-->
                                <div class="column is-narrow">
                                    <a href="#" class="button is-dark">
                                        <span class="icon">
                                            <i class="fas fa-book-open"></i>
                                        </span>
                                        <span>試し読みする</span>
                                    </a>
                                </div>

                                <!--購入ボタン。購入画面に遷移-->
                                <div class="column is-narrow">
                                    <a href="purchase.php" class="button is-primary">
                                        <span class="icon">
                                            <i class="fas fa-shopping-cart"></i>
                                        </span>
                                        <span>購入する</span>
                                    </a>
                                </div>
                            </div>

                                <!--お気に入りに遷移-->

                                <div class="buttons is-right">
                                <a href="favorite.php" class="button is-light is-rounded">
                                    <span class="icon"><i class="fas fa-star"></i></span>
                                </a>

                                <!--レビュー画面に遷移-->

                                <a href="review.php" class="button is-light is-rounded">
                                    <span class="icon"><i class="fas fa-comment-alt"></i></span>
                                </a>
                            </div>

                        </div>    
                    </div>
                </div>
            </div>

        </section>
        

        <?php require 'footmenu.php'; ?>
        <?php require 'footer.php'; ?>

    </body>
</html>