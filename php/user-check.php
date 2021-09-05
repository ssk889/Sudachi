<?php require_once './DbManager.php';
 session_start();


  try {
   //データベースへの接続を確立
   $db = getDb();
 } catch (PDOException $e) {
   echo "エラーメッセージ：" .$e->getMessage();
 }

/* 会員登録の手続き以外のアクセスを飛ばす */
if ( !isset($_SESSION['join']) ) {
    header('Location: user-input.php');
    exit();
}

if (!empty($_POST['check'])) {
    // パスワードを暗号化
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);

    // 入力情報をデータベースに登録
    $statement = $db->prepare("INSERT INTO member SET name=?, login=?, password=?");
    $statement->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['login'],
        $hash
    ));
    unset($_SESSION['join']);   // セッションを破棄
    header('Location: user-thank.php');   // thank.phpへ移動
    exit();
}
?>

<?php require 'header.php';?>

<div class="conC">
       <form action="" method="POST">
           <input type="hidden" id="check" name="check" value="checked">
           <h1>入力情報の確認</h1>
           <p>ご入力情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
           <p>登録情報はあとから変更することもできます。</p>
           <?php if ( !empty($error_message) ): ?>
               <p class="error">＊会員登録に失敗しました。</p>
           <?php endif ?>
           <hr>

           <div class="control">
               <p>ユーザー名</p>
               <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
           </div>

           <div class="control">
               <p>ログインID</p>
               <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['login'], ENT_QUOTES); ?></span></p>
           </div>

           <br>
           <button type="button" onclick="history.back()" class="back-btn">変更する</button>
           <button type="submit" class="btn next-btn">登録する</button>
           <div class="clear"></div>
       </form>
   </div>

<?php require 'footer.php';?>
