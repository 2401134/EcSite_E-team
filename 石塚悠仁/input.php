<?php
    if(isset($_GET['status']) && $_GET['status'] == 1){
        echo '
            <form action="input.php" method="post">
                <p>
                    パスワード変更に関するメールを送信しました<br>
                    届かない場合は時間をおいて再度、お試しください。
                </p>
                <button type="submit">閉じる</button>
                <hr>
            </form>
        ';
    }
    echo '
        <form action="auto.php" method="post">
            メールアドレス<br>
            <input type = "address" name = "address"><br>
            <input type = "submit" value = "送信">
        </form>
    ';
?>