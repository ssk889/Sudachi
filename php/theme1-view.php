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
    <li><a href="record.php"></a></li>
    <li><a href="theme1-input.php">不安を和らげる練習</a></li>
    <li><a href="theme1-view.php">閲覧ページ</a></li>
  </ol>
</div>

<div class="conE">
  <h1>自分が苦手な場面を知る</h1>
<table>
  <thead>
    <tr>
      <th style="width: 16%;">誰と?</th><th>どこで?</th><th style="width: 22%;">何をしていた?</th><th style="width: ;">どうなった?</th><th style="width: ;">相手からどう思われたか？</th>
      <th style="width: ;">自分への評価</th>
      <th>不安のタイプ</th><th style="width: 15%;">管理</th>
    </tr>
  </thead>

<?php
try {
  $db = getDB();
  $stt = $db->prepare("SELECT * FROM awareness WHERE id = '".$id."'");
  $stt->execute();
  while($row = $stt->fetch(PDO::FETCH_ASSOC) ) {
    ?>

    <tr>
      <td><?=e($row['who']) ?></td>
      <td><?=e($row['place']) ?></td>
      <td><?=e($row['what']) ?></td>
      <td><?=e($row['result']) ?></td>
      <td><?=e($row['think']) ?></td>
      <td><?=e($row['assess']) ?></td>
      <td><?=e($row['type']) ?></td>
      <td><a href="theme1-edit.php?message_id=<?php echo $row['seq']; ?>">編集する</a><br>
      <a href="theme1-delete.php?message_id=<?php echo $row['seq']; ?>">削除する</a></td>
    </tr>

  <?php }
} catch(PDOException $e) {
  die("エラーメッセージ：{$e->getMessage()}");
}
?>
</table>


    <div class="center-block">
      <button type="submit" class="blue-m-button" onclick="location.href='theme1-input.php'" >続けて記録する</button>
    </div>


</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>

<a href ="theme2-input.php" class="next-bt" >やりたいことリスト  <i class="fas fa-arrow-alt-circle-right"></i></a>

  <?php require 'footer.php';?>
