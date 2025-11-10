<?php session_start(); ?>
<?php require 'header.php'; ?>

<h2>新規登録</h2>

<form action="register-output.php" method="post">
  <table>
    <tr><td>メールアドレス</td>
      <td><input type="email" name="user_address" required></td></tr>
    <tr><td>パスワード</td>
      <td><input type="password" name="user_password" required></td></tr>
  </table>
  <p><input type="submit" value="登録"></p>
</form>

<?php require 'footer.php'; ?>
