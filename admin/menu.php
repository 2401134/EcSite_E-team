<?php
if (!isset($_SESSION['admin_id'])) {
    http_response_code(404);
    exit;
}

if (!isset($_SESSION['super_admin']) || $_SESSION['super_admin'] != 0) {
    echo '<script>
          alert("総合管理者の権限がありません");
          history.back();
          </script>';
    exit;
}
?>
<div class="header columns is-vcentered has-background-grey-light">

  
  <figure class="image is-128x128 ml-5">
    <a href = "super_admin_home.php"><img src="../uploads/image/booknest.png" width="100px" height="100px"></a>
  </figure>

</div>
