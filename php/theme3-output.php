<?php
require_once './DbManager.php';
require_once './Encode.php';
session_start();


 try {
   $db = getDb();
 } catch (PDOException $e) {
   echo "データベース接続エラー　：".$e->getMessage();
 }

if ( isset($_SESSION['join']) ) {
	// 入力情報をデータベースに登録
  $statement = $db->prepare("INSERT INTO practice SET id=?, post_date=?, incident=?, kind=?, pre_notion=?, post_notion=?, pre_degree=?, pre_thought=?, post_thought=?, post_degree=?");
	$statement->execute(array(
			$_SESSION['join']['message_id'],
      $_SESSION['join']['post_date'],
			$_SESSION['join']['incident'],
      $_SESSION['join']['kind'],
			$_SESSION['join']['pre_notion'],
      $_SESSION['join']['post_notion'],
      $_SESSION['join']['pre_degree'],
      $_SESSION['join']['pre_thought'],
      $_SESSION['join']['post_thought'],
      $_SESSION['join']['post_degree'],
    ) );
  $success_message = 'success';
  }

  if( !empty($success_message) ) {
    header('Location: theme3-view.php');
    exit();
  }
      ?>
