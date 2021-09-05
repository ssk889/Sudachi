<?php session_start();?>
<?php require 'header.php';?>


<?php
if (isset($_SESSION['member'])) {
  unset($_SESSION['member']);
  echo 'ログアウトしました。';
} else {
  echo 'ログアウトしています。';
}
?>

<php require 'footer.php';?>
