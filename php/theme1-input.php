<?php require_once './DbManager.php';
 session_start();

//タイムゾーンの設定
date_default_timezone_set('Asia/Tokyo');
//変数の初期化
$current_date = date("Y-m-d H:i:s");
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
  if ( empty($_POST['who']) ) {
    $error_message['who'] = '「誰と？」を記入してください。';
  }
  if ( empty($_POST['place']) ) {
    $error_message['place'] = '「どこで？」を記入してください。';
  }
  if ( empty($_POST['what']) ) {
    $error_message['what'] = '「何をしていたか？」を記入してください';
  }

if( empty($error_message) ) {
  $_SESSION['join'] = $_POST;
  header('Location: theme1-output.php');
  exit();
  }
}

?>

<?php require 'header.php'?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="record.php"></a></li>
    <li><a href="record.php">不安を和らげる練習</a></li>
    <li><a href="theme1-input.php">自分の苦手な場面を知る</a></li>
  </ol>
</div>

<div class="conD">
  <h1>自分が苦手な場面を知る</h1>
  <form action="" method="POST">
    <p class="small-chara"><i class="fas fa-lightbulb"></i>自分が不安を感じる状況を記入してください。実際に経験したことも、想像して不安になったことどちらでもかまいません。</p>

    <div>
      <?php if( !empty($error_message) ): ?>
        <ul class="error">
          <?php foreach( $error_message as $value): ?>
            <li ><?php echo "・$value"; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

     <div class="short-session">
       <label for="who"><i class="fas fa-caret-right fa-lg"></i>誰と？</label>
      <textarea name="who" rows="5" cols="70" placeholder="男性・女性、若い人・年配、大勢、4,5人、親しい人・初対面の人"></textarea>
		</div>

		<div class="short-session">
			<label for="place"><i class="fas fa-caret-right fa-lg"></i>どこで？</label>
      <textarea name="place" rows="5" cols="70" placeholder="結婚式、会議室、レストラン、電車"></textarea>
		</div>

    <div class="short-session">
			<label for="what"><i class="fas fa-caret-right fa-lg"></i>何をしていた？</label>
      <textarea name="what" rows="5" cols="70" placeholder="スピーチ、食事、書類に記入、デート"></textarea>
		</div>

    <div class="small-session">
			<label for="result"><i class="fas fa-caret-right fa-lg"></i>どうなった？</label>
      <textarea name="result" rows="5" cols="70" placeholder="しどろもどろ、手が震えた、目が合わせられない、その場から離れた"></textarea>
		</div>

    <div class="small-session">
			<label for="think"><i class="fas fa-caret-right fa-lg"></i>相手にどう思われていると思った？</label>
      <textarea name="think" rows="5" cols="70" placeholder="変な人・不思議な人、この年でこれくらいのこともできないのか"></textarea>
		</div>

    <div class="small-session">
			<label for="assess"><i class="fas fa-caret-right fa-lg"></i>自分で自分をどう評価した？</label>
      <textarea name="assess" rows="5" cols="70" placeholder="こんなこともでできなく恥ずかしい、情けない"></textarea>
		</div>

    <div class="small-session">
			<label for="type"><i class="fas fa-caret-right fa-lg"></i>名前をつけるとしたらどのような不安？</label>
      <textarea name="type" rows="5" cols="70" placeholder="・大勢の人の目にさらされる不安&#13;・年長の男性への不安&#13;・権威ある人間への不安"></textarea>
		</div>

	   <div class='link-block'>
       <button class='btn' type='submit' name='btn_submit'>記録する</button>
    </div>

    <input type="hidden" name="message_id" value="<?php if( !empty($message_data['id']) ){ echo $message_data['id']; }  ?>">

	</form>


</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>



<?php require 'footer.php';?>
