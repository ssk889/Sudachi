<?php
session_start();
//セッションの中身をすべて削除
$_SESSION = array();
//セッションを破棄
session_destroy();
?>


<?php require 'header.php';?>
<div class="conC">
  <p>ログアウトしました。</p>
  <button type="button" class="btn-typeA" onclick="location.href='login-input.php'">ログイン</button>
</div>

<?php require 'footer.php';?>
