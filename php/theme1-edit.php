<?php session_start();
require_once './DbManager.php';

//タイムゾーンの設定
date_default_timezone_set('Asia/Tokyo');
//変数の初期化
$current_date = date("Y-m-d H:i:s");

if( empty($_SESSION['member']) ) {
	//ログインページへリダイレクト
	header("Location: ./login-input.php");
	exit;
}


try {
  //データベースへの接続を確立
  $db = getDb();
} catch(PDOException $e) {
	// 接続エラーのときエラー内容を取得する
    $error_message[] = $e->getMessage();
}


//GETのみの場合データを表示、POSTもある場合はデータを更新する
if ( !empty($_GET['message_id']) && empty($_POST['message_id']) ) {
	//SQL作成
	$stmt = $db->prepare("SELECT * FROM awareness WHERE seq = :seq");
	//値をセット
	$stmt->bindValue( ':seq', $_GET['message_id'], PDO::PARAM_INT);
	//SQLクエリの実行
	$stmt->execute();
	//表示するデータを取得
	$message_data = $stmt->fetch();
	//投稿データが取得できないときは管理ページに戻る
	if( empty($message_data) ) {
		header("Location: ./theme1-view.php");
		exit;
		}
	} elseif( !empty($_POST['message_id']) ) {


	if( empty($error_message) ) {

		 try {
			  // トランザクション開始
			  $db->beginTransaction();
				//SQL作成
				$stt = $db->prepare("UPDATE awareness SET who = :who, place = :place, what = :what, result = :result, think = :think, assess = :assess, type = :type WHERE seq = :seq");
				//値をセット
				$stt->bindParam(':who', $_POST['who'], PDO::PARAM_STR);
				$stt->bindParam(':place', $_POST['place'], PDO::PARAM_STR);
				$stt->bindParam(':what', $_POST['what'], PDO::PARAM_STR);
				$stt->bindParam(':result', $_POST['result'], PDO::PARAM_STR);
				$stt->bindParam(':think', $_POST['think'], PDO::PARAM_STR);
				$stt->bindParam(':assess', $_POST['assess'], PDO::PARAM_STR);
				$stt->bindParam(':type', $_POST['type'], PDO::PARAM_STR);
				$stt->bindParam(':seq', $_POST['message_id'], PDO::PARAM_INT);
				//SQLクエリの実行
				$stt->execute();
				echo $stt->rowCount();
				// コミット
				$res = $db->commit();
			} catch(Exception $e) {
				// エラーが発生した時はロールバック
				$db->rollBack();
			}
				// 更新に成功したら一覧に戻る
				if( $res ) {
					header("Location: ./theme1-view.php");
					exit;
			}
	}
}






require 'header.php';?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="record.php">不安を和らげる練習</a></li>
    <li><a href="theme1-input.php">自分の苦手な場面を知る</a></li>
    <li><a href="theme1-view.php">閲覧ページ</a></li>
		<li><a href="theme1-edit.php">編集ページ</a></li>
  </ol>
</div>


<div class="conD">
	<form method="post">
		<h1>編集画面</h1>
		<p>*編集後に更新ボタンを押してください。</p>
		<div class="control">
			<label for="who"><i class="fas fa-caret-right fa-lg"></i>誰と？</label>
			<textarea name="who"><?php if( !empty($message_data['who']) ){
		echo $message_data['who']; } ?></textarea>
	</div>

	<div class="control">
		<label for="place"><i class="fas fa-caret-right fa-lg"></i>どこで？</label>
		<textarea name="place"><?php if( !empty($message_data['place']) ) {
			echo $message_data['place']; } ?></textarea>
		</div>

		<div class="control">
			<label for="what"><i class="fas fa-caret-right fa-lg"></i>何をしていた？</label>
			<textarea name="what"><?php if( !empty($message_data['what']) ) {
				echo $message_data['what']; } ?></textarea>
			</div>

			<div class="control">
				<label for="result"><i class="fas fa-caret-right fa-lg"></i>どうなった？</label>
				<textarea name="result"><?php if( !empty($message_data['result']) ) {
					echo $message_data['result']; } ?></textarea>
				</div>

				<div class="control">
					<label for="think"><i class="fas fa-caret-right fa-lg"></i>相手にどう思われていると思った？</label>
					<textarea name="think"><?php if( !empty($message_data['place']) ) {
						echo $message_data['think']; } ?></textarea>
					</div>

					<div class="control">
						<label for="assess"><i class="fas fa-caret-right fa-lg"></i>自分で自分をどう評価した？</label>
						<textarea name="assess"><?php if( !empty($message_data['assess']) ) {
							echo $message_data['assess']; } ?></textarea>
						</div>

						<div class="control">
							<label for="type"><i class="fas fa-caret-right fa-lg"></i>どのタイプの不安？</label>
							<textarea name="type"><?php if( !empty($message_data['type']) ) {
								echo $message_data['type']; } ?></textarea>
							</div>

		<div class='link-block'>
			<button class='btn' type='submit' name='btn_submit'>更新する</button>
	 </div>

		<button type="button" onclick="location.href='theme1-view.php'" class="red-button">キャンセル</button>

		<input type="hidden" name="message_id" value="<?php if( !empty($message_data['seq']) ){
			echo $message_data['seq']; } elseif( !empty($_POST['message_id']) ) { echo htmlspecialchars( $_POST['message_id'], ENT_QUOTES, 'UTF-8'); } ?>">

	</form>
</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>


<?php require 'footer.php';?>
