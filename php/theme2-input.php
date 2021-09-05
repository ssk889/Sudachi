<?php require_once './DbManager.php';
 session_start();


//変数の初期化
$message_data['id'] = $_SESSION['member']['id'];

try {
  $db = getDb();
} catch (PDOException $e) {
  echo "データベース接続エラー　：".$e->getMessage();
}

if( empty($_SESSION['member']) ) {
	//ログインページへリダイレクト
	header("Location: ./login-input.php");
	exit;
}

if( !empty($_POST) ) {
  if ( empty($_POST['wish']) ) {
    $error_message['wish'] = '「人見知り克服リスト」を記入してください。';
  }


if( empty($error_message) ) {
  $_SESSION['join'] = $_POST;
  header('Location: theme2-output.php');
  exit();
  }
}

?>

<?php require 'header.php'?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="record.php">不安を軽くする練習</a></li>
    <li><a href="theme2-input.php">人見知り克服リスト</a></li>
  </ol>
</div>

<div class="conD">
  <h1>人見知り克服リスト</h1>
  <form action="" method="POST">
    <p>不安のためにやりたくてもできなかったことを記入してください。</p>

    <div>
      <?php if( !empty($error_message) ): ?>
        <ul class="error">
          <?php foreach( $error_message as $value): ?>
            <li ><?php echo "・$value"; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

     <div class="control">
       <label for="wish"><i class="fas fa-caret-right fa-lg"></i>人見知り克服リスト</label>
      <textarea name="wish" rows="8" cols="70" placeholder="・行きつけのバー、レストランをつくる&#13;・友達に貸したお金を返してもらう&#13;・残業を断る&#13;・友達と違う意見を言う&#13;・クーリングオフする&#13;・パーティーで初対面の人に話しかける&#13;・カーディーラーで試乗したり、洋服屋で試着する"></textarea>
		</div>

    <div class='link-block'>
      <button class='btn' type='submit' name='btn_submit'>記録する</button>
   </div>

    <input type="hidden" name="message_id" value="<?php if( !empty($message_data['id']) ){ echo $message_data['id']; }  ?>">

	</form>

</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>

<?php require 'footer.php';?>
