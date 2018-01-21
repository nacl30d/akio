<?php
    require_once('./conf/functions.php');
	session_start();

	//URLに含まれている記事のIDを取得
	$id = $_GET['id'];
	$redirect = "./update.php?id=" . $id; //フォームページはidごとに動的なURLを発行
	#DB接続
	$pdo = connectDB();
	#時間割情報をDBから取得し、変数$ansに格納（id以外）

	//全般的な情報を取得
	$sql = "SELECT name, note FROM TimeTables WHERE id = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$info = $statement->fetch(PDO::FETCH_ASSOC);
	if (!$info) {
		// http_response_code( 404 ) ;
		// header( "Location: http://akico.azurewebsites.net/404.html" ) ;
		exit('DB Effor A(faild to get record)');
	}

	// //時間割情報を取得
	$sql = "SELECT cell, answer, userId FROM Answers WHERE tableId = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$ans = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	// if (!$ans) {
	// 	http_response_code( 404 ) ;
	// 	header( "Location: http://akico.azurewebsites.net/404.html" ) ;
	// 	exit('DB Error B (faild to get record)');
	// }

	//名前を取得
	$sql = "SELECT Users.id, Users.name FROM Users inner join Belongs on Users.id = Belongs.userId WHERE Belongs.tableId = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$usr = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	// if (!$idame) {
	// 	http_response_code( 404 ) ;
	// 	header( "Location: http://akico.azurewebsites.net/404.html" ) ;
	// 	exit('DB Error C (faild to get record)');
	// }

	//行数を取得
	$sql = "SELECT name FROM DaysOfWeek WHERE tableId = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$dow = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	// if (!$count) {
	// 	http_response_code( 404 ) ;
	// 	header( "Location: http://akico.azurewebsites.net/404.html" ) ;
	// 	exit('DB Error D (faild to get record)');
	// }

	//--- ver2.0 ---//
	$sql = "SELECT name FROM Units WHERE tableId = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$units = $statement->fetchAll(PDO::FETCH_ASSOC);

	for ($i=0; $i < count($dow) * count($units); $i++) { 
		$sql = "SELECT sum(answer) FROM Answers WHERE tableId = :id AND cell = :num;";
		$statement = $pdo -> prepare($sql);
		$statement -> execute([
			':id' => $id,
			':num' => $i
		]);
		$answers[] = $statement -> fetch(PDO::FETCH_ASSOC);
	}

	//--- ver1.0 ---//
	// #値の大きい上位3つの数値を取得、変数に格納
	// $max1 = 0; $max2 = 0; $max3 = 0;
	// foreach ($ans as $value) {
	// 	if ($value >= $max1) {
	// 		$max1 = $value;
	// 	} else if ($value >= $max2) {
	// 		$max2 = $value;
	// 	} else if ($value >= $max3) {
	// 		$max3 = $value;
	// 	}
	// }
	
	// #得たansをテーブルに起こしやすくするため加工
	// $table = array_chunk($ans, 5, true); //5つごとに2次元化

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#次のページにリダイレクト
		header("Location: $redirect");
		exit();
	}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<?php include('meta.html'); ?>
	<title><?php echo h($info['name']); ?>｜AKIO</title>
</head>
<body>
<?php include('header.html'); ?>

<div class="row">
    <div class="col l6 offset-l3 s12 ">
		<?php
			echo '<h1 class="header green-text">', $info['name'], '</h1>', PHP_EOL;
			echo '<h5>', $info['note'], '</h5>', PHP_EOL;
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
			<?php
				//見出し行作成
				echo "<tr><th></th>";
				foreach ($dow as $row) {
					foreach ($row as $name => $day) {
						echo '<th>', $day , '</th>';
					}
				}
				echo "</tr>";
				//見出し列の作成とセルの作成
				$j = 0;
				foreach ($units as $row) {
					foreach ($row as $name => $unit) {
						echo '<tr class="num">' , '<th>' , $unit , '</th>' ; //行の作成、見出しの入力（n時限目）
						for ($i=0; $i < count($dow); $i++) { 
							echo '<td>',$answers[$i+$j]['sum(answer)'] ,'</td>';
						}
						echo '</tr>' , PHP_EOL;
					}
					$j += count($dow);
				}
					//--- ver1.0 ---//
					// foreach ($row as $name => $unit) {
					// }

					// foreach ($row as $cell) {
					// 	//各セルに値を入力
					// 	if ($cell == 0) {
					// 		echo '<td class="zero">' , $cell , '</td>'; 
					// 	} else if ($cell == $max1) {
					// 		echo '<td class="max">' , $cell , '</td>'; 
					// 	} else if ($cell == $max2) {
					// 		echo '<td class="mass">' , $cell , '</td>'; 
					// 	} else if ($cell == $max3) {
					// 		echo '<td class="less">' , $cell , '</td>'; 
					// 	} else {
					// 		echo '<td class="zero">' , $cell , '</td>'; 
					// 	}
					// }
					
				// }
			?>
		</table>
	</div>
</div>
<div class="row">
    <div class="col l6 offset-l3 s12 ">
  			<?php echo '<h5 class="green-text">答えてくれた人（ ', count($usr) ,'人）</h5>';?>
  	</div>
</div>
<div class="row center">
    <div class="col l6 offset-l3 s12 ">
  			<?php
  				foreach ($usr as $row) {
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
		<?php echo '<input type="text" name="url" value="http://akico.azurewebsites.net/result.php?id='.$_GET['id'].'" onclick="this.select(0,this.value.length)">'; ?>
		<!-- LINE -->
		<div class="line-it-button" style="display: none;" data-lang="ja" data-type="share-a" <?php echo 'data-url="http://http://akico.azurewebsites.net/result.php?id='.$id.'"' ?>></div><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
	</div>
</div>	
	

<?php include('footer.html'); ?>

</body>
</html>