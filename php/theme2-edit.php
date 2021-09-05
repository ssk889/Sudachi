<?php session_start();
require_once './DbManager.php';


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
	$stmt = $db->prepare("SELECT * FROM desire WHERE seq = :seq");
	//値をセット
	$stmt->bindValue( ':seq', $_GET['message_id'], PDO::PARAM_INT);
	//SQLクエリの実行
	$stmt->execute();
	//表示するデータを取得
	$message_data = $stmt->fetch();
	//投稿データが取得できないときは管理ページに戻る
	if( empty($message_data) ) {
		header("Location: ./theme2-view.php");
		exit;
	}
	} elseif( !empty($_POST['message_id']) ) {

		$wish = $_POST['wish'];

	if( empty($error_message) ) {

		 try {
			  // トランザクション開始
			  $db->beginTransaction();
				//SQL作成
				$stt = $db->prepare("UPDATE desire SET wish = :wish WHERE seq = :seq");
				//値をセット
				$stt->bindParam(':wish',$wish, PDO::PARAM_STR);
				$stt->bindValue(':seq',$_POST['message_id'], PDO::PARAM_INT);
				//SQLクエリの実行
				$stt->execute();
				// コミット
				$res = $db->commit();
			} catch(Exception $e) {
				// エラーが発生した時はロールバック
				$db->rollBack();
			}
				// 更新に成功したら一覧に戻る
				if( $res ) {
					header("Location: ./theme2-view.php");
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
    <li><a href="theme2-input.php">人見知り克服リスト</a></li>
    <li><a href="theme2-view.php">閲覧ページ</a></li>
		<li><a href="theme2-edit.php">編集ページ</a></li>
  </ol>
</div>

	<div class="conD">
	<form method="post">
		<h1>編集画面</h1>
		<p>*編集後に更新ボタンを押してください。</p>

		<div class="control">
			<label for="wish"><i class="fas fa-caret-right fa-lg"></i>やりたくても出来なかったこと</label>
			<textarea name="wish"><?php if( !empty($message_data['wish']) ){
		echo $message_data['wish']; } ?></textarea>
	</div>

		<div class='link-block'>
			<button class='btn' type='submit' name='btn_submit'>更新する</button>
	 </div>

		<button type="button" onclick="location.href='theme2-view.php'" class="red-button">キャンセル</button>
		<input type="hidden" name="message_id" value="<?php if( !empty($message_data['seq']) ){
			echo $message_data['seq']; } elseif( !empty($_POST['message_id']) ) { echo htmlspecialchars( $_POST['message_id'], ENT_QUOTES, 'UTF-8'); } ?>">
	</form>
</div>

<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>


<?php require 'footer.php';?>
