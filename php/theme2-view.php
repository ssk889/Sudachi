<?php
require_once './DbManager.php';
require_once './Encode.php';
 session_start();


$id = $_SESSION['member']['id'];

if( empty($_SESSION['member']) ) {
	//ログインページへリダイレクト
	header("Location: ./login-input.php");
	exit;
}



?>

<?php require 'header2.php';?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="record.php">不安を和らげる練習</a></li>
    <li><a href="theme2-input.php">人見知り克服リスト</a></li>
    <li><a href="theme2-view.php">閲覧ページ</a></li>
  </ol>
</div>

<div class="conE">
  <h1>やりたいことリスト</h1>
<table>
  <thead>
    <tr>
      <th>やりたいこと</th></th>
      <th style="width: 10%; ">管理</th>
    </tr>
  </thead>

<?php
try {
  $db = getDB();
  $stt = $db->prepare("SELECT * FROM desire WHERE id = '".$id."'");
  $stt->execute();
  while($row = $stt->fetch(PDO::FETCH_ASSOC) ) {
    ?>

    <tr>
      <td><?=e($row['wish']) ?></td>
      <td><a href="theme2-edit.php?message_id=<?php echo $row['seq']; ?>">編集する</a><br>
      <a href="theme2-delete.php?message_id=<?php echo $row['seq']; ?>">削除する</a></td>
    </tr>

  <?php }
} catch(PDOException $e) {
  die("エラーメッセージ：{$e->getMessage()}");
}
?>
</table>

    <div class="center-block">
      <button type="submit" class="blue-m-button" onclick="location.href='theme2-input.php'" >続けて「やりたいことリスト」を記録する</button>
    </div>


</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>

<a href ="theme3-input.php" class="next-bt" >実践レポートへ  <i class="fas fa-arrow-alt-circle-right"></i></a>

  <?php require 'footer.php';?>
