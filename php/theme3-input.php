<?php require_once './DbManager.php';
 session_start();

//タイムゾーンの設定
date_default_timezone_set('Asia/Tokyo');
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
  if ( empty($_POST['incident']) ) {
    $error_message['incident'] = '「不安を感じる状況や出来事」を記入してください。';
  }





if( empty($error_message) ) {
  $_SESSION['join'] = $_POST;
  header('Location: theme3-output.php');
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
    <li><a href="theme3-input.php">実践レポート</a></li>
  </ol>
</div>

<div class="conD">
  <h1>実践レポート</h1>
  <form action="" method="POST">
    <p>不安な状況において、実際に行動する前後に記録をしてください。</p>

    <div>
      <?php if( !empty($error_message) ): ?>
        <ul class="error">
          <?php foreach( $error_message as $value): ?>
            <li ><?php echo "・$value"; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <div class="small-session">
			<label for="post_date"><i class="fas fa-caret-right fa-lg"></i>記録する日時 <span class="small-chara">(右端のアイコンをクリックしてください。)</span></label>
      <input type="date" name="post_date">
		</div>

     <div class="short-session">
       <label for="incident"><i class="fas fa-caret-right fa-lg"></i>不安を感じる状況や出来事 <span class="small-chara">(一つ記入してください。)</span></label>
      <textarea name="incident" rows="8" cols="80" placeholder="披露宴でスピーチをする、人前で電話する、字を書く"></textarea>
		</div>

  	<div class="small-session">
			<label for="kind"><i class="fas fa-caret-right fa-lg"></i>どのタイプの不安か <span class="small-chara">(複数可)</span></label>
      <textarea name="kind" rows="8" cols="80" placeholder="・大勢の人の目にさらされる不安&#13;・権威ある人間への不安&#13;・自分が批判されることへの不安"></textarea>
		</div>

    <div class="control">
			<label for="pre_notion"><i class="fas fa-caret-right fa-lg"></i>直前の考え(自動思考)</label>
      <span class="small-chara">行動前に浮かんだ考えを書き出してみましょう。</span><br><br>
      <textarea name="pre_notion" rows="8" cols="80" placeholder="①スピーチは完璧じゃなきゃいけない&#13;②みんなは堂々と喋るのに&#13;③自分だけはいつもまともに話せない&#13;④人前で大恥をかいてしまう&#13;⑤みんなに馬鹿にされるかもしれない&#13;⑥過去にスピーチで失敗したから今回も失敗する"></textarea>
		</div>

    <div class="control">
			<label for="post_notion"><i class="fas fa-caret-right fa-lg"></i>直前の考え(適応思考)</label>
      <span class="small-chara">浮かんだが考えを一つずつ、バイアスがかかってないか検証して修正しましょう。下記のバイアス一覧を参考にしてください。</span><br>
        <div class="box24">
          <p>・物事は白か黒かで判断できる。 (白黒思考)<br>・完璧でなくてはダメ。中間はない。(最善か無か)<br>・一部を見て、それを全体だと思う。(部分→全体)<br>・一度起こったことが永遠に繰り返すと思う。(一度→永遠)<br>・特殊な一例を普遍的なものだと思う。(特殊→不変)<br>・自分の悪い部分だけを評価する (->+)<br>・心の状態が現実になる (心=現実)<br>・自分は人の気持ちが読める (読心術)<br>・自分は周囲から監視されている (注目の的)<br>・人は～であるべきだ。 (べき思考)<br>・相手の方が自分より価値が上 (相手>自分)</p>
        </div>
      <textarea name="post_notion" rows="8" cols="80" placeholder="①完璧に喋らなくていい(白黒思考、べき思考)&#13;②堂々としている人も本当は不安かもしれない(読心術・他>自)&#13;③「いつも」ということはない(白黒思考)&#13;④恥をかくかはわからない(読心術・心＝現実)&#13;⑤人が馬鹿にするかはわからない(読心術・心＝現実)&#13;⑥過去のスピーチのうち全て失敗しているわけではない(一度→永遠)"></textarea>
		</div>

    <div class="small-session">
      <label for="pre_degree"><i class="fas fa-caret-right fa-lg"></i>行動前の不安度(0~10)</label>
      <div class="degree-block">
        <input name="pre_degree" type="range" id="range" list="datalist" step="1" min="0" max="10" value="0"><span id="value">0</span>/10
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
          <option value="10" label="100">
          </datalist>
        </div>
      </div>

      <p class="red-chara">*ここまでを行動する前に記入して記録ボタンを押してください。</p>
      <div class='link-block'>
        <button class='btn' type='submit' name='btn_submit'>記録する</button>
     </div>

    </div>

    <div class="conD">
      <p class="red-chara">*ここからは実際に行動した後に記録してください。</p>
      <div class="control">
  			<label for="pre_thought"><i class="fas fa-caret-right fa-lg"></i>直後の考え(自動思考)</label>
        <textarea name="pre_thought" rows="8" cols="80" placeholder="①やっぱり上手くいかなかった。&#13;②みんな変に思った&#13;③手が震えていた"></textarea>
  		</div>

      <div class="control">
  			<label for="post_thought"><i class="fas fa-caret-right fa-lg"></i>直後の考え(適応思考)</label>
          <span class="small-chara">浮かんだが考えを一つずつ、バイアスがかかってないか検証して修正しましょう。下記のバイアス一覧を参考にしてください。</span><br>
          <div class="box24">
            <p>・物事は白か黒かで判断できる。 (白黒思考)<br>・完璧でなくてはダメ。中間はない。(最善か無か)<br>・一部を見て、それを全体だと思う。(部分→全体)<br>・一度起こったことが永遠に繰り返すと思う。(一度→永遠)<br>・特殊な一例を普遍的なものだと思う。(特殊→不変)<br>・自分の悪い部分だけを評価する (->+)<br>・心の状態が現実になる (心=現実)<br>・自分は人の気持ちが読める (読心術)<br>・自分は周囲から監視されている (注目の的)<br>・人は～であるべきだ。 (べき思考)<br>・相手の方が自分より価値が上 (相手>自分)</p>
          </div>
        <textarea name="post_thought" rows="8" cols="80" placeholder="①完ぺきではないけど、大きな失敗はなかった(白黒思考)&#13;②人の考えはわからない。好意的にみている人もいるはずだ。(読心術)&#13;③手の震えは思ったより人は気づかない。手が震えたからといって失敗ではない。(一部→全体)"></textarea>
  		</div>

      <div class="small-session">
        <label for="post_degree"><i class="fas fa-caret-right fa-lg"></i>実際の不安度(0~10)</label>
        <div class="degree-block">
          <input name="post_degree" type="range" id="length" list="datalist" step="1" min="0" max="10" value="0"><span id="point">0</span>/10
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
            <option value="10" label="100">
            </datalist>
          </div>
        </div>

	   <div class='link-block'>
       <button class='btn' type='submit' name='btn_submit'>記録する</button>
    </div>

    <input type="hidden" name="message_id" value="<?php if( !empty($message_data['id']) ){ echo $message_data['id']; }  ?>">

	 </form>
  </div>



<a href ="#" onclick="history.back(-1);return false;" class="back-bt" ><i class="fas fa-arrow-alt-circle-left"></i> 戻る</a>




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
