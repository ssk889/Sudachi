<?php session_start();?>
<?php require 'header.php';?>

<?php
$pdo=new PDO('mysql:host=localhost; dbname=sudachi; charset=utf8','staff','password');
if (isset($_SESSION['member'])) {
  $id=$_SESSION['member']['id'];
  $sql=$pdo->prepare('select * from member where id!=? and login=?');
  $sql->execute([$id, $_REQUEST['login']]);
} else {
  $sql=$pdo->prepare('select * from member where login=?');
  $sql->execute([$_REQUEST['login']]);
}
if (empty($sql->fetchAll())) {
  if (isset($_SESSION['member'])) {
    $sql=$pdo->prepare('update member set name=?, '.'login=?, password=? where id=?');
    $sql->execute([$_REQUEST['name'], $_REQUEST['login'],
      $_REQUEST['password'], $id]);
    $_SESSION['member']=['id'=>$id, 'name'=>$_REQUEST['name'], 'login'=>$_REQUEST['login'],
      'password'=>$_REQUEST['password']];
    echo 'ユーザー情報を更新しました。';
  } else {
    $sql=$pdo->prepare('insert into member values(null,?,?,?)');
    $sql->execute([$_REQUEST['name'], $_REQUEST['login'], $_REQUEST['password']]);
    echo 'ユーザー情報を登録しました。';
  }
} else {
  echo 'このログインIDはすでに使用されています。';
}
?>
