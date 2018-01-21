<?php
    require_once('./conf/functions.php');
	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#テーブルidが推測されにくいユニークなidとなるように作成
		$id = uniqid("",1);

		$pdo = connectDB();
		
		$sql = "INSERT INTO TimeTables VALUES (:id, :name, :note, :passwd, now());";
		$statement = $pdo -> prepare($sql);
		$result = $statement->execute([
			':id' => $id,
			':name' => h($_POST['name']),
			':note' => h($_POST['note']),
			':passwd' => h($_POST['passwd'])
			]);
		if(!$result){
			exit('DB Error (failed to add record)'); //入に失敗したエラーメッセージ
		}

		for($i = 0; $i < 5; $i++) {
			$sql = "INSERT INTO DaysOfWeek (no, name, tableId) VALUES (:no, :name, :id);";
			$statement = $pdo -> prepare($sql);
			$result = $statement->execute([
				':no' => 'd'.$i,
				':name' => h($_POST['d'.$i]),
				':id' => $id
				]);
			if(!$result){
				exit('DB Error (failed to add record)');
			}
		}

		for($i = 0; $i < 6; $i++) {
			$sql = "INSERT INTO Units (no, name, tableId) VALUES (:no, :name, :id);";
			$statement = $pdo -> prepare($sql);
			$result = $statement->execute([
				':no' => 'u'.$i,
				':name' => h($_POST['u'.$i]),
				':id' => $id
				]);
			if(!$result){
				exit('DB Error (failed to add record)');
			}
		}

		#次のページにリダイレクト
		$redirect = "./result.php?id=" . $id; //フォームページはidごとに動的なURLを発行
		header("Location: $redirect");
		exit();
	}
	
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<?php include('./meta.html'); ?>
	<title>AKIO</title>
</head>
<body>
<?php include('./header.html'); ?>
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
	<div id="about" class="col s12">
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
	<div id="howto" class="col s12 l12">
		<span class="headline">
  			<h2 class="headline__title">使い方</h2>
		</span>
		<p>使い方は簡単！代表者が時間割を作成してURLを共有。あとはみんながそれに空きコマ情報を登録するだけ！</p>
	</div>

    <div class="col s12 m7 l3">
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
	<div class="col s12">
	<span class="headline">
  			<h2 class="headline__title">時間割を作成</h2>
	</span>
	</div>
    <div id="create" class="col s12 m7 l6 ">
		<form action="" method="POST">
		     <div class="input-field">
        		<input type="text" class="validate" name="name" />
		        <label for="icon_prefix">予定のタイトル</label>
		     </div>
		     <div class="input-field">
		        <input type="text" class="validate" name="note" />
		        <label for="icon_prefix">内容・コメント</label>
		     </div>
			<div class="input-field">
			  	<input type="password" class="valib" name="passwd" />
			  	<label for="icon_prefix">幹事パスワード</label>
			</div>
	</div>

	<div class="col s12 m7 l6">
		  	<table>
		  		<tbody id="createForm">
	  			<!-- ここもAjaxにしちゃう？？JSで扱うならクライアントサイドの方が変数の扱いとか楽かも。（2018-01-04） -->
			  	<?php
			  	$dow = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
			  	$unit = array('1', '2', 'Lunch', '3', '4', '5', '6', '7', '8', '9', '10');
				echo '<tr id="day"><th></th>';
				for($i = 0; $i < 5; $i++){
					echo '<th><input type="text" value="'. $dow[$i] .'" name="d'. $i .'" /></th>';
				}
				echo '<td class="clr"><input type="button" value="+" id="addDay" onclick="addCol()" /></td></tr>', PHP_EOL;
				echo '</tr>', PHP_EOL;
				for($i = 0; $i < 6; $i++){
					echo '<tr id="r'. $i .'"><th><input type="text" value="'. $unit[$i] .'" name="u'. $i .'" /></th>';
					for ($j=0; $j < 5; $j++) { 
						echo '<td></td>';
					}
					echo '</tr>', PHP_EOL;
				}
				?>
				</tbody>
				<tbody>
				<?php
					echo '<td class="clr"><input type="button" value="+" id="addUnit" onclick="addRow()" /></td></tr>', PHP_EOL;
				?>
				</tbody>
			</table>
	</div>
		<input class="btn" type="submit" value="作成" name="create" />
		</form>
</div>

</div>
<?php include('footer.html'); ?>
</body>
</html>