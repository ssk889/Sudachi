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
	$stmt = $db->prepare("SELECT * FROM practice WHERE seq = :seq");
	//値をセット
	$stmt->bindValue( 'seq', $_GET['message_id'], PDO::PARAM_INT);
	//SQLクエリの実行
	$stmt->execute();
	//表示するデータを取得
	$message_data = $stmt->fetch();
	//投稿データが取得できないときは管理ページに戻る
	if( empty($message_data) ) {
		header("Location: ./theme3-view.php");
		exit;
		}
	} elseif( !empty($_POST['message_id']) ) {
		$db = getDb();
		try {
			//トランザクション開始
			$db->beginTransaction();
			//SQL作成
			$stmt = $db->prepare("DELETE FROM practice WHERE seq = :seq");
			//値をセット
			$stmt->bindValue( ':seq', $_POST['message_id'], PDO::PARAM_INT);
			//SQLクエリの実行
			$stmt->execute();
			//コミット
			$res = $db->commit();

		} catch(Exception $e) {
			//エラー時はロールバック
		 $db->rollBack();
	}

	if( $res) {
		header("Location: ./theme3-view.php");
		exit;
	}
}




require 'header.php';?>

<!--パンくずリスト-->
<div class="bread">
  <ol>
    <li><a href="../index.html">トップ</a></li>
    <li><a href="record.php">不安を和らげる練習</a></li>
    <li><a href="theme3-input.php">実践レポート</a></li>
    <li><a href="theme3-view.php">閲覧ページ</a></li>
		<li><a href="theme3-delete.php">削除ページ</a></li>
  </ol>
</div>

	<div class="conD">
	<form method="POST">
		<h1>編集画面</h1>
		<p class="small-chara">*編集後に更新ボタンを押してください。</p>

	<div class="small-session">
		<label for="post_date"><i class="fas fa-caret-right fa-lg"></i>日時</label>
		<input type="date" name="post_date" value="<?php if( !empty($message_data['post_date']) ){
	echo $message_data['post_date']; } elseif( !empty($post_date) ) { echo htmlspecialchars( $post_date, ENT_QUOTES, 'UTF-8'); } ?>">
	</div>

	<div class="small-session">
		<label for="incident"><i class="fas fa-caret-right fa-lg"></i>不安を感じる状況や出来事</label>
		<textarea name="incident" placeholder="同僚のミスを指摘する、披露宴でスピーチをする、人前で電話する"><?php if( !empty($message_data['incident']) ){
	echo $message_data['incident']; } elseif( !empty($incident) ) { echo htmlspecialchars( $incident, ENT_QUOTES, 'UTF-8'); } ?></textarea>
</div>

	<div class="small-session">
		<label for="kind"><i class="fas fa-caret-right fa-lg"></i>どのタイプの不安か <span class="small-chara">(複数可)</span></label>
		<textarea name="kind" placeholder="・大勢の人の目にさらされる不安&#13;・権威ある人間への不安&#13;・異性への不安"><?php if( !empty($message_data['kind']) ) {
			echo $message_data['kind']; }  elseif( !empty($kind) ) { echo htmlspecialchars( $kind, ENT_QUOTES, 'UTF-8'); } ?></textarea>
		</div>

		<div class="control">
			<label for="pre_notion"><i class="fas fa-caret-right fa-lg"></i>直前の考え(修正前)</label><br>
      <span class="small-chara">行動前に浮かんだ考えを書き出してみましょう(複数可)</span><br><br>
			<textarea name="pre_notion" placeholder="①スピーチは完璧じゃなきゃいけない&#13;②みんなは堂々と喋るのに&#13;③自分だけはいつもまともに話せない&#13;④人前で大恥をかいてしまう&#13;⑤みんなに馬鹿にされるかもしれない&#13;⑥過去にスピーチで失敗したから今回も失敗する"><?php if( !empty($message_data['pre_notion']) ) {
				echo $message_data['pre_notion']; }  elseif( !empty($basis) ) { echo htmlspecialchars( $pre_notion, ENT_QUOTES, 'UTF-8'); } ?></textarea>
			</div>

			<div class="control">
				<label for="post_notion"><i class="fas fa-caret-right fa-lg"></i>直前の考え(修正後)</label><br>
	      <span class="small-chara">浮かんだが考えを一つずつ、バイアスがかかってないか検証して修正しましょう。</span><br><br>
				<textarea name="post_notion" placeholder="①完璧に喋らなくていい(白黒)&#13;②堂々としている人も本当は不安かもしれない(読心・他>自・心＝現実)&#13;③「いつも」ということはない(白黒)&#13;④恥をかくかはわからない(読心・心＝現実)&#13;⑤人が馬鹿にするかはわからない(読心・心＝現実)&#13;⑥過去のスピーチのうち全て失敗しているわけではない(一度→永遠)"><?php if( !empty($message_data['post_notion']) ) {
					echo $message_data['post_notion']; }  elseif( !empty($post_notion) ) { echo htmlspecialchars( $post_notion, ENT_QUOTES, 'UTF-8'); } ?></textarea>
				</div>

		<div class="control">
    <label for="pre_degree"><i class="fas fa-caret-right fa-lg"></i>行動前の不安度</label>
    <div class="degree-block">
      <input name="pre_degree" type="range" id="range" list="datalist" step="1" min="0" max="10" value="<?php if( !empty($message_data['pre_degree']) ) {
				echo $message_data['pre_degree']; }  elseif( !empty($pre_degree) ) { echo htmlspecialchars( $pre_degree, ENT_QUOTES, 'UTF-8'); } ?>">
				<span id="value"><?php if( !empty($message_data['pre_degree']) ) {
				echo $message_data['pre_degree']; }  elseif( !empty($pre_degree) ) { echo htmlspecialchars( $pre_degree, ENT_QUOTES, 'UTF-8'); } ?></span>
    <datalist id="datalist">
  <option value="0" label="0">
  <option value="1">
  <option value="2">
  <option value="3">
  <option value="4">
  <option value="5" label="5">
  <option value="6">
  <option value="7">
  <option value="8">
  <option value="9">
  <option value="10" label="10">
    </datalist>
    </div>
  </div>

	<div class="control">
		<label for="pre_thought"><i class="fas fa-caret-right fa-lg"></i>直後の考え(修正前)</label><br>
		<textarea name="pre_thought" placeholder="①やっぱり上手くいかなかった。&#13;②みんな変に思った&#13;③手が震えていた"><?php if( !empty($message_data['pre_thought']) ) {
			echo $message_data['pre_thought']; }  elseif( !empty($pre_thought) ) { echo htmlspecialchars( $pre_thought, ENT_QUOTES, 'UTF-8'); } ?></textarea>
		</div>

		<div class="control">
			<label for="post_thought"><i class="fas fa-caret-right fa-lg"></i>直後の考え(修正後)</label><br>
			<textarea name="post_thought" placeholder="①完ぺきではないけど、大きな失敗はなかった(白黒)&#13;②人の考えはわかならい。好意的にみている人もいるはずだ。(読心)&#13;③手の震えは思ったより人は気づかない。手が震えたからといって失敗ではない。(一部→全体)"><?php if( !empty($message_data['post_thought']) ) {
				echo $message_data['post_thought']; }  elseif( !empty($post_thought) ) { echo htmlspecialchars( $post_thought, ENT_QUOTES, 'UTF-8'); } ?></textarea>
			</div>

		<div class="control">
			<label for="post_degree"><i class="fas fa-caret-right fa-lg"></i>実際の不安度</label>
			<div class="degree-block">
				<input name="post_degree" type="range" id="length" list="datalist" step="1" min="0" max="10" value="<?php if( !empty($message_data['post_degree']) ) {
					echo $message_data['post_degree']; }  elseif( !empty($post_degree) ) { echo htmlspecialchars( $post_degree, ENT_QUOTES, 'UTF-8'); } ?>">
					<span id="point"><?php if( !empty($message_data['post_degree']) ) {
					echo $message_data['post_degree']; }  elseif( !empty($post_degree) ) { echo htmlspecialchars( $post_degree, ENT_QUOTES, 'UTF-8'); } ?></span>
					<datalist id="datalist">
					<option value="0" label="0">
					<option value="1">
					<option value="2">
					<option value="3">
					<option value="5" label="5">
					<option value="6">
					<option value="7">
					<option value="8">
					<option value="9">
					<option value="10" label="10">
						</datalist>
							</div>
								</div>


		<div class='link-block'>
			<button class='big-red-button' type='submit' name='btn_submit'>削除</button>
	 </div>

		<button type="button" onclick="location.href='theme3-view.php'" class="green-button">キャンセル</button>

		<input type="hidden" name="message_id" value="<?php if( !empty($message_data['seq']) ){
			echo $message_data['seq']; } elseif( !empty($_POST['message_id']) ) { echo htmlspecialchars( $_POST['message_id'], ENT_QUOTES, 'UTF-8'); } ?>">

	</form>
</div>

<!--inputバーのJavaScript処理-->
<script>
  var elem = document.getElementById('range');
  var target = document.getElementById('value');
  var rangeValue = function (elem, target) {
    return function(evt){
      target.innerHTML = elem.value;
    }
  }
  elem.addEventListener('input', rangeValue(elem, target));

  var fact = document.getElementById('length');
  var mark = document.getElementById('point');
  var rangeValue = function (fact, mark) {
    return function(evt){
      mark.innerHTML = fact.value;
    }
  }
  fact.addEventListener('input', rangeValue(fact, mark));
</script>

<?php require 'footer.php';?>
