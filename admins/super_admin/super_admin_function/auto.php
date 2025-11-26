<?php require 'db-connect.php';?>
<?php $pdo = new PDO($connect, USER, PASS); ?>
<?php
  $auto_reply_subject = null;
  $auto_reply_text = null;
  $admin_reply_subject = null;
  $admin_reply_text = null;
  
  //トークン生成
  $url_token = uniqid();
  $code = sprintf("%06d", mt_rand(1, 999999));

  //時間設定
  date_default_timezone_set('Asia/Tokyo');
  
  //パラメータ
  $header = "MIME-Version: 1.0\n";
  $header .= "Content-type: text/html; charset=UTF-8\n";
  $header .= "From: Eチーム事務所 <eteam@pafe.com>\n";
  $header .= "Reply-To: Eチーム事務所 <eteam@pafe.com>\n";

  // 件名を設定
  $auto_reply_subject = 'Book Nestパスワード変更のご案内';

  // 本文を設定
  $auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。
下記のURLよりパスワード変更を行ってください。
なお、このメールにご心当たりがない場合は、メールの削除を行ってください。<br><br>";

  $auto_reply_text .= "認証コード：" . $code . "<br>";
  $auto_reply_text .= "コードの使用期限は30分です。<br>";
  $auto_reply_text .= "下記のリンクからパスワードを変更してください。<br>";
  $auto_reply_text .= '<a href="https://aso2401134.greater.jp/2025/test/reset.php?id=' . $url_token . '">';
  $auto_reply_text .= 'パスワード変更はこちら</a><br><br>';

  $auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "<br>";
  $auto_reply_text .= "メールアドレス：" . $_POST['address'] . "<br><br>";

  $auto_reply_text .= "Eチーム事務所";

  // メール送信(迷惑メールに行く可能性あり)
  mb_send_mail( $_POST['address'], $auto_reply_subject, $auto_reply_text, $header);


  //＜データベース記録＞
  //ユーザー検索
  $sql = $pdo->prepare("SELECT user_id FROM users WHERE user_address = ?");
  $sql->execute([$_POST['address']]);
  $user = $sql->fetch();

  //ユーザーの存在確認
  if($user){
    $user_id = (int)$user['user_id'];
  } else { 
    $user_id = NULL;//見つからなかった場合のエラーid(NULL)
  }

  //認証コードとトークンのハッシュ化
  $token_hash = password_hash($code, PASSWORD_DEFAULT);
  $url_token_hash = password_hash($url_token, PASSWORD_DEFAULT);

  //コードの期限設定
  $limit = date("Y-m-d H:i:s", time() + 1800);

  //データ登録
  $insert = $pdo->prepare("
    INSERT INTO password_resets (user_id, token, reset_limit, url_token, used)
    VALUES (?, ?, ?, ?, 0)
  ");
  $insert->execute([
    $user_id,
    $token_hash,
    $limit,
    $url_token_hash
  ]);

  header('Location: input.php?status=1');
  exit;
?>