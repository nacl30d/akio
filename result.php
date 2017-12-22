<?php
    require_once('./conf/functions.php');
	session_start();

	//URLに含まれている記事のIDを取得
	$n = $_GET['n'];
	$redirect = "./update.php?n=" . $n; //フォームページはidごとに動的なURLを発行
	#DB接続
	$pdo = connectDB();
	#時間割情報をDBから取得し、変数$ansに格納（id以外）
	//全般的な情報を取得
	$sql = "SELECT formName, notice FROM informations WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$info = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$info) {
		http_response_code( 404 ) ;
		header( "Location: http://akico.azurewebsites.net/404.html" ) ;
		exit('DB Effor A(faild to get record)');
	}
	//時間割情報を取得
	$sql = "SELECT sum(mon1), sum(tue1), sum(wed1), sum(thu1), sum(fri1), sum(mon2), sum(tue2), sum(wed2), sum(thu2), sum(fri2), sum(mon3), sum(tue3), sum(wed3), sum(thu3), sum(fri3), sum(mon4), sum(tue4), sum(wed4), sum(thu4), sum(fri4), sum(mon5), sum(tue5), sum(wed5), sum(thu5), sum(fri5) FROM answers WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$ans = $statement->fetch(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	if (!$ans) {
		http_response_code( 404 ) ;
		header( "Location: http://akico.azurewebsites.net/404.html" ) ;
		exit('DB Error B (faild to get record)');
	}
	//名前を取得
	$sql = "SELECT name FROM answers WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$name = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	if (!$name) {
		http_response_code( 404 ) ;
		header( "Location: http://akico.azurewebsites.net/404.html" ) ;
		exit('DB Error C (faild to get record)');
	}
	//行数を取得
	$sql = "SELECT count(name) FROM answers WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$count = $statement->fetch(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	if (!$count) {
		http_response_code( 404 ) ;
		header( "Location: http://akico.azurewebsites.net/404.html" ) ;
		exit('DB Error D (faild to get record)');
	}

	#値の大きい上位3つの数値を取得、変数に格納
	$max1 = 0; $max2 = 0; $max3 = 0;
	foreach ($ans as $value) {
		if ($value >= $max1) {
			$max1 = $value;
		} else if ($value >= $max2) {
			$max2 = $value;
		} else if ($value >= $max3) {
			$max3 = $value;
		}
	}
	
	#得たansをテーブルに起こしやすくするため加工
	$table = array_chunk($ans, 5, true); //5つごとに2次元化

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#次のページにリダイレクト
		header("Location: $redirect");
		exit();
	}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<?php include('meta.php'); ?>

	<!-- meta tags for Share -->
		<meta property="og:title" <?php echo 'content="',h($info['formName']),'|AKIKO"'; ?>/>
		<meta property="og:url" content="http://akico.azurewebsites.net/"/>
	
	<title><?php echo h($info['formName']); ?>｜AKIO</title>
</head>
<body>
<?php include('header.php'); ?>

<div class="row">
    <div class="col l6 offset-l3 s12 ">
		<?php
			echo '<h1 class="header green-text">', $info['formName'], '</h1>', PHP_EOL;
			echo '<h5>', $info['notice'], '</h5>', PHP_EOL;
		?>
	</div>
</div>	

<div class="row">
    <div class="col l6 offset-l3 s12 ">
  			<h5 class="green-text">みんなの結果</h5>
  	</div>
</div>
  <div class="row center">
    <div class="col l6 offset-l3 s12 ">
		<table class="result">
			<tr><th></th><th>Mon.</th><th>Tue.</th><th>Wed.</th><th>Thu.</th><th>Fri.</th></tr>
			<?php
				foreach ($table as $num => $row) {
					echo '<tr class="num">' , '<th>' , $num+1 , '</th>' ; //行の作成、見出しの入力（n時限目）
					foreach ($row as $cell) {
						//各セルに値を入力
						if ($cell == 0) {
							echo '<td class="zero">' , $cell , '</td>'; 
						} else if ($cell == $max1) {
							echo '<td class="max">' , $cell , '</td>'; 
						} else if ($cell == $max2) {
							echo '<td class="mass">' , $cell , '</td>'; 
						} else if ($cell == $max3) {
							echo '<td class="less">' , $cell , '</td>'; 
						} else {
							echo '<td class="zero">' , $cell , '</td>'; 
						}
					}
					echo '</tr>' , PHP_EOL;
				}
			?>
		</table>
	</div>
</div>
<div class="row">
    <div class="col l6 offset-l3 s12 ">
  			<?php echo '<h5 class="green-text">答えてくれた人（ ', $count['count(name)'] ,'人）</h5>';?>
  	</div>
</div>
<div class="row center">
    <div class="col l6 offset-l3 s12 ">
  			<?php
  				foreach ($name as $row) {
  					echo '<p>', h($row['name']) , '</p>', PHP_EOL;
  				}
  			?>
  	</div>
 </div>

<div class="row">
    <div class="col l6 offset-l3 s12 ">
  			<h5 class="green-text">みんなに空きコマを教えよう！</h5>
		<div id="insertForm">
			<form action="" method="POST" >
				<input class="btn" type="submit" value="予定を入力" name="insert">
			</form>
		</div>
  		<h5 class="green-text">共有</h5>
		<?php echo '<input type="text" name="url" value="http://akico.azurewebsites.net/result.php?n='.$_GET['n'].'" onclick="this.select(0,this.value.length)">'; ?>
		<!-- LINE -->
		<div class="line-it-button" style="display: none;" data-lang="ja" data-type="share-a" <?php echo 'data-url="http://http://akico.azurewebsites.net/result.php?n='.$n.'"' ?>></div><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
	</div>
</div>	
	

<?php include('footer.php'); ?>

</body>
</html>