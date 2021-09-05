<?php require_once './DbManager.php';
 session_start();

 try {
   $db = getDb();
 } catch (PDOException $e) {
   echo "データベース接続エラー　：".$e->getMessage();
 }

//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');
// 書き込み日時を取得
	$current_date = date("Y-m-d H:i:s");
  $id = $_SESSION['member']['id'];


if ( isset($_SESSION['join']) ) {
	// 入力情報をデータベースに登録
	$statement = $db->prepare("INSERT INTO awareness SET id=?, who=?, place=?, what=?, result=?, think=?, assess=?, type=?");
	$statement->execute(array(
			$_SESSION['join']['message_id'],
			$_SESSION['join']['who'],
			$_SESSION['join']['place'],
      $_SESSION['join']['what'],
      $_SESSION['join']['result'],
      $_SESSION['join']['think'],
      $_SESSION['join']['assess'],
      $_SESSION['join']['type'],
			) );
    //データベースからデータを取得
    $sql = "SELECT * FROM awareness WHERE id = '".$id."'";
    $message_array = $db->query($sql);
    $success_message = '記録しました。';
    }

    if( !empty($success_message) ) {
      header('Location: theme1-view.php');
      exit();
    }

?>
