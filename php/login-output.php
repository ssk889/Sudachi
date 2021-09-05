<?php require_once './DbManager.php';
session_start();

$login = $_POST['login'];

try {
 //データベースへの接続を確立
 $db = getDb();
} catch (PDOException $e) {
 echo "エラーメッセージ：" .$e->getMessage();
}

if( !empty($_POST) ) {
  //入力情報の不備を検知
  if ( empty($_POST['login']) ) {
    $error_message['login'] = 'IDを入力してください。';
  }
  if ( empty($_POST['password']) ) {
    $error_message['password'] = 'パスワードを入力してください。';
  }
}

//エラーがなければ照合
if( empty($error_message) ) {

   $sql = "SELECT * FROM member WHERE login = :login";
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':login', $login);
   $stmt->execute();
   $member = $stmt->fetch();
   //指定したハッシュがパスワードにマッチしているかチェック
   if (password_verify($_POST['password'], $member['password']) ) {
     //DBのユーザー情報をセッションに保存
     $_SESSION['member'] = $member;
     //ログインに成功した場合、ウェルカムページへリダイレクト
     header("Location: login-welcome.php");
     exit;
   } else {
   $error_message['mistake'] = "IDもしくはパスワードが間違っています。";
   }
 }

?>

<?php require 'header.php';?>
<div class="conC">
  <?php if( isset($error_message) ):?>
    <ul class="error">
      <?php foreach( $error_message as $value): ?>
        <li ><?php echo "・$value"; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>

<?php require 'footer.php';?>


<php require 'footer.php';?>
