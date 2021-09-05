<?php require_once './DbManager.php';
 session_start();

try {
  $db = getDb();
} catch (PDOException $e) {
  echo "データベース接続エラー　：".$e->getMessage();
}

if( !empty($_POST) ) {
  //入力情報の不備を検知
  if ( empty($_POST['name']) ) {
    $error_message['name'] = 'ユーザー名を入力してください。';
  }
  if ( empty($_POST['login']) ) {
    $error_message['login'] = 'IDを入力してください。';
  }
  if ( empty($_POST['password']) ) {
    $error_message['password'] = 'パスワードを入力してください';
  }

  //ログインIDの重複を検知
  if( !isset($error_message)) {
    $member = $db->prepare('SELECT COUNT(*) as cnt FROM member WHERE login=?');
    $member->execute( array(
      $_POST['login']
    ) );
    $record = $member->fetch();
    if( $record['cnt'] > 0) {
      $error_message['login'] = 'duplicate';
    }
  }

  //エラーがなければ次のページへ
  if( empty($error_message) ) {
    //一時的にセッションに入力情報を保存
    $_SESSION['join'] = $_POST;
    header('Location: user-check.php');
    exit();
  }
}
?>

<?php require 'header.php';?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="../about.html">アカウント登録</a></li>
  </ol>
</div>

<div class="conC">
  <form action="" method="POST">
    <h1>アカウント作成</h1>
    <p>ご利用するために必要事項を記入してください。</p>
    <div>
      <?php if( isset($error_message) ):?>
        <ul class="error">
          <?php foreach( $error_message as $value): ?>
            <li ><?php echo "・$value"; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <div class="control">
      <label for="name">ユーザー名<span class="required">必須</label>
        <input id="name" type="text" name="name">
    </div>

    <div class="control">
      <label for="login">ログインID<span class="required">必須</span></label>
        <input id="login" type="text" name="login">
    </div>

    <div class="control">
      <label for="password">パスワード<span class="required">必須</span></label>
        <input id="password" type="password" name="password">
    </div>

    <div class="control">
      <button type="submit" class="btn" name="btn_submit">確認する</button>
    </div>
    <div class="control">
      <button type="button" class="green-button"  onclick="location.href='login-input.php'">ログイン画面へ</button>
    </div>
  </form>
</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>

<a href ="record.php" class="next-bt" >記録へ  <i class="fas fa-arrow-alt-circle-right"></i></a>




<?php require 'footer.php';?>
