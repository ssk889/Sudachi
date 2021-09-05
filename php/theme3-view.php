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
    <li><a href="record.php">不安を軽くする練習</a></li>
    <li><a href="theme3-input.php">実践レポート</a></li>
    <li><a href="theme3-view.php">閲覧ページ</a></li>
  </ol>
</div>

<div class="conG">
  <h1>実践レポート</h1>
  <p>行動した後に編集を,</p>


<?php
try {
  $db = getDB();
  $stt = $db->prepare("SELECT * FROM practice WHERE id = '".$id."'");
  $stt->execute();
  while($row = $stt->fetch(PDO::FETCH_ASSOC) ) {
    ?>

  <div class="listA">
    <table>
      <thead>
        <tr>
          <th style="width: 6%;">日時</th>
          <th style="width: 12%;">状況/出来事</th>
          <th style="width: 14%">直前の考え(修正前)</th>
          <th style="width: 14%">直前の考え(修正後)</th>
          <th style="width: 5%;">直前の不安度</th>
        </tr>
      </thead>
      <tr>
        <td><?=e($row['post_date']) ?></td>
        <td><?=e($row['incident']) ?></td>
        <td><?=e($row['pre_notion']) ?></td>
        <td><?=e($row['post_notion']) ?></td>
        <td><?=e($row['pre_degree']) ?></td>
      </tr>
    </table>

        <table>
        <thead>
          <tr>
            <th style="width: 11%">直後の考え(修正前)</th>
            <th style="width: 11%">直後の考え(修正後)</th>
            <th style="width: 3%">実際の不安度</th>
            <th style="width: 3%;">管理</th>
          </tr>
        </thead>
        <tr>
          <td><?=e($row['pre_thought']) ?></td>
          <td><?=e($row['post_thought']) ?></td>
          <td><?=e($row['post_degree']) ?></td>
          <td><a href="theme3-edit.php?message_id=<?php echo $row['seq']; ?>">編集</a><br>
            <a href="theme3-delete.php?message_id=<?php echo $row['seq']; ?>">削除</a></td>
          </tr>
        </table>
      </div>

  <?php }
} catch(PDOException $e) {
  die("エラーメッセージ：{$e->getMessage()}");
}
?>



    <div class="center-block">
      <button type="submit" class="blue-m-button" onclick="location.href='theme3-input.php'" >続けて記録する</button>
    </div>


</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>


  <?php require 'footer.php';?>
