<?php session_start();?>
<?php require_once './DbManager.php';?>



<?php require 'header.php';?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="login-welcome.php">ログイン完了</a></li>
  </ol>
</div>

<div class="conC">
  <p>ログインしました。</P>

  <div class="control">
    <button type="button" class="red-button" onclick="location.href='logout.php'">ログアウト</button>
  </div>

</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>

<a href ="record.php" class="next-bt" >記録へ  <i class="fas fa-arrow-alt-circle-right"></i></a>

<?php require 'footer.php';?>
