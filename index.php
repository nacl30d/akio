<?php
    require_once('./conf/functions.php');
	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#DB接続
		$pdo = connectDB();

		#レコードを作成
		$sql = "INSERT INTO answers (n) VALUES(:n);";
		$n = uniqid("",1);
		//データベース関連の処理
		$statement = $pdo -> prepare($sql);
		$result = $statement->execute([
			':n' => $n,
			]);
		if(!$result){
			exit('DB ErrorA (failed to add record)'); //入に失敗したエラーメッセージ
		}

		#レコードを作成
		$sql = "INSERT INTO informations (n, formName, notice) VALUES(:n, :formName, :notice);";
		//データベース関連の処理
		$statement = $pdo -> prepare($sql);
		$result = $statement->execute([
			':n' => $n,
			':formName' => h($_POST['formName']),
			':notice' => h($_POST['notice'])
			// ':passwd' => h($_POST['passwd'])
			]);
		if(!$result){
			exit('DB Error (failed to add record)'); //入に失敗したエラーメッセージ
		}

		#次のページにリダイレクト
		$redirect = "/result.php?n=" . $n; //フォームページはidごとに動的なURLを発行
		header("Location: $redirect");
		exit();
	}
	
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<?php include('./meta.php'); ?>

	<!-- meta tags for Share -->
	<meta property="og:title" content="AKIKO" />
	<meta property="og:url" content="http://akico.azurewebsites.net/" />
	<title>AKIO</title>
</head>
<body>
<?php include('./header.php'); ?>
<div class="section no-pad-bot" id="index-banner">
<div class="container">
　
	<h1 class="header center green-text">ようこそ！</h1>

	 <div class="row center">
	 	<p class="header col s12 light">今すぐ時間割を作成する</p>
        <a href="./#create" class="btn-large waves-effect waves-light orange">Create now</a>
     </div>

</div>
</div>

<div class="container">
<div class="row center">
	<div id="about" class="col l6 offset-l3 s12">
	<span class="headline">
  		<h2 class="headline__title">About</h2>
	</span>
    <div class="card horizontal">
      <div class="card-image">
        <img src="/img/OGP.png" alt="AKIO" />
      </div>
    </div>
		
		<p>空きコマをみんなで合わせる「空きコマ調整ツール」その名もAKIOくん。
		現在開発途中のβ版です。最低限の機能を実装したので公開していますが、まだまだ至らないところも多いと思います。温かい目で見守っていてください。</p>
	</div>
</div>

<div class="row center">
	<div id="howto" class="col l6 offset-l3 s12">
		<span class="headline">
  			<h2 class="headline__title">使い方</h2>
		</span>
		<p>使い方は簡単！代表者が時間割を作成してURLを共有。あとはみんながそれに空きコマ情報を登録するだけ！</p>
	</div>
</div>
<div class="row center">
    <div class="col s12 m7 l3 offset-l1">
    	<h5 class="green-text">step.1</h5>
        <div class="card">
            <div class="card-image">
              <img src="/img/step1.png" alt="step1">
              <!-- <span class="card-title">step. 1</span> -->
            </div>
            <div class="card-content">
              <p>登録不要で利用可能！まずは幹事がタイトルと内容を入力して時間割を作成！</p>
            </div>
        </div>
    </div>
    <div class="col s12 m7 l3">
    	<h5 class="green-text">step.2</h5>
        <div class="card">
            <div class="card-image">
              <img src="/img/step2.png" alt="step2">
              <!-- <span class="card-title">step. 2</span> -->
            </div>
            <div class="card-content">
              <p>時間割を作ったら、LINEやTwitterを利用して、URLをみんなに知らせよう！</p>
            </div>
        </div>
    </div>
    <div class="col s12 m7 l3">
    	<h5 class="green-text">step.3</h5>
        <div class="card">
            <div class="card-image">
              <img src="/img/step3.png" alt="step3">
              <!-- <span class="card-title">step. 3</span> -->
            </div>
            <div class="card-content">
              <p>入力はタップで簡単！空いている時間をタップして予定を入力することができます！</p>
            </div>
        </div>
    </div>
</div>
            


<div class="row center">
    <div class="col l6 offset-l3 s12 ">
		<div id="create">
		<span class="headline">
  			<h2 class="headline__title">時間割を作成</h2>
		</span>
			<form action="" method="POST">
      <div class="input-field">
        <input id="icon_prefix" type="text" class="validate" name="formName">
        <label for="icon_prefix">予定のタイトル</label>
      </div>
      <div class="input-field">
        <input id="icon_prefix" type="text" class="validate" name="notice">
        <label for="icon_prefix">内容・コメント</label>
      </div>
				<!-- <p>幹事パスワード：</p><input type="password" value="" name="passwd"> -->
				<input class="btn" type="submit" value="作成" name="create">
			</form>
		</div>
	</div>
</div>

</div>
<?php include('footer.php'); ?>
</body>
</html>