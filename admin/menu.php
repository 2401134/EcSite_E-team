<?php
// ---- セッションチェック ----
if (!isset($_SESSION['admin_id'])) {
    echo "エラー：管理者としてログインしていません。<br>";
    echo '<a href="Alogin-input.php">ログイン画面へ</a>';
    exit;
}
?>
<div class="header columns is-vcentered has-background-grey-light">

  
  <figure class="image is-128x128 ml-5">
    <a href = "admin_home.php"><img src="../uploads/image/booknest.png" width="100px" height="100px"></a>
  </figure>

</div>
