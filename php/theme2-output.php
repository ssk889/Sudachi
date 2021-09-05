<?php
require_once './DbManager.php';
require_once './Encode.php';
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
  $id = $_SESSION['join']['message_id'];


if ( isset($_SESSION['join']) ) {
	// 入力情報をデータベースに登録
	$statement = $db->prepare("INSERT INTO desire SET id=?, wish=?");
	$statement->execute(array(
			$_SESSION['join']['message_id'],
      $_SESSION['join']['wish'],
    ) );
  $success_message = 'success';
  }
  if( !empty($success_message) ) {
    header('Location: theme2-view.php');
    exit();
  }
      ?>
