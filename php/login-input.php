<?php session_start();?>
<?php require_once './DbManager.php';

if( isset($_SESSION['member']) ) {
 //ログイン状態の場合、ウェルカムページへリダイレクト
 header("Location: login-welcome.php");
 exit;
}

?>

<?php require 'header.php';?>

<div class="conC">
  <h1>ログインIDとパスワードを記入してください</h1>
  <form action="login-check.php" method="POST">
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
      <label for="login">ログインID</label>
      <input type="text" id="login" name="login">
    </div><br>

    <div class="control">
      <label for="password">パスワード</label>
      <input type="password" id="password" name="password"><br>
    </div>

    <div class="control">
      <button type="submit" class="btn" name="btn_submit">ログインする</button>
    </div>

  </form><br>

  <div class="control">
    <button type="button" class="green-button" onclick="location.href='user-input.php'">新規登録はこちら</button>
  </div>

</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>


<?php require 'footer.php';?>
