<?php
    require_once('./conf/functions.php');
	session_start();

	//URLに含まれている記事のIDを取得
	$id = $_GET['id'];
	$redirect = "./result.php?id=" . $id; //フォームページはidごとに動的なURLを発行

	$pdo = connectDB();
	//--- ver2.0 ---//
	//行数を取得
	$sql = "SELECT name FROM DaysOfWeek WHERE tableId = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$dow = $statement->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT name FROM Units WHERE tableId = :id;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':id' => $id]);
	$units = $statement->fetchAll(PDO::FETCH_ASSOC);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#動作確認テスト用
		// $_SESSION['ans'] = $_POST['ans'];
		$ans = $_POST['ans'];
		if (!$_POST['name']) {
			$_POST['name'] = "名無し";
		}

		$sql = "INSERT INTO Users (name, createdTime) VALUES (:name, now());";
		$statement = $pdo -> prepare($sql);
		$result = $statement -> execute([
			':name' => $_POST['name']
		]);

		$sql = "SELECT id FROM Users ORDER BY id DESC LIMIT 1;";
		$statement = $pdo -> prepare($sql);
		$statement -> execute([]);
		$userId = $statement->fetch(PDO::FETCH_ASSOC);

		$sql = "INSERT INTO Belongs (userId, tableId) VALUES (:userId, :tableId);";
		$statement = $pdo -> prepare($sql);
		$result = $statement -> execute([
			':userId' => $userId['id'],
			':tableId' => $id
		]);

		for ($i=0; $i < count($dow) * count($units); $i++) {
			$sql = "INSERT INTO Answers (tableId, userId, cell, answer, createdTime) VALUES (:id, :userId, :cell, :answer, now());";
			$statement = $pdo -> prepare($sql);
			$result = $statement -> execute([
				':id' => $id,
				':userId' => $userId['id'],
				':cell' => $i,
				':answer' => $ans[$i]
			]);
			if(!$result){
				exit();
			}
		}


		//--- ver1.0 ---//
		#データ更新
		// $sql = "INSERT INTO answers (n, name, mon1, mon2, mon3, mon4, mon5, tue1, tue2, tue3, tue4, tue5, wed1, wed2, wed3, wed4, wed5, thu1, thu2, thu3, thu4, thu5, fri1, fri2, fri3, fri4, fri5) VALUES (:id, :idame, :mon1, :mon2, :mon3, :mon4, :mon5, :tue1, :tue2, :tue3, :tue4, :tue5, :wed1, :wed2, :wed3, :wed4, :wed5, :thu1, :thu2, :thu3, :thu4, :thu5, :fri1, :fri2, :fri3, :fri4, :fri5);";
		// //データベース関連の処理
		// $statement = $pdo -> prepare($sql);
		// $result = $statement->execute([
		// ':id' => $id, ':idame' => h($_POST['name']),
  //       ':mon1' => $ans['0'],':tue1' => $ans['1'], ':wed1' => $ans['2'], ':thu1' => $ans['3'], ':fri1' => $ans['4'],
  //       ':mon2' => $ans['5'], ':tue2' => $ans['6'], ':wed2' => $ans['7'], ':thu2' => $ans['8'], ':fri2' => $ans['9'],
  //       ':mon3' => $ans['10'], ':tue3' => $ans['11'], ':wed3' => $ans['12'], ':thu3' => $ans['13'], ':fri3' => $ans['14'],
  //         ':mon4' => $ans['15'], ':tue4' => $ans['16'], ':wed4' => $ans['17'], ':thu4' => $ans['18'], ':fri4' => $ans['19'],
  //       ':mon5' => $ans['20'], ':tue5' => $ans['21'], ':wed5' => $ans['22'], ':thu5' => $ans['23'], ':fri5' => $ans['24']
		// ]);
		// if(!$result){
		// 	var_dump($statement->errorinfo());
		// 	exit('DB Error (failed to add record)'); //入に失敗したエラーメッセージ
		// }

		#次のページにリダイレクト
		header("Location: $redirect");
		exit();
	}
?>

<!DOCTYPE html>
  <head>
	<?php include('meta.html') ?>
	<title>予定を入力｜AKIO</title>
  </head>
<body>
<?php include('header.html'); ?>

<div class="row">
<div class="row center">
    <div class="col l6 offset-l3 s12 ">
   	 <form action="" method="POST" id="insertForm">

        <!-- <p>Name:</p><input type="text" name="name" value="名無し" /> -->
		<div class="row">
    		<div class="col l6 offset-l3 s12 ">

    			<br />
				<h5 class="green-text">タップして空きコマ情報を入力！</h5>
				<table class="update">
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
									echo '<td id="', $i+$j ,'" class="ng" onClick="judge(', $i+$j ,')"> <input type="hidden" name="ans[]" id="a', $i+$j ,'" value="0"> </td>';
								}
								echo '</tr>' , PHP_EOL;
								$j += count($dow);
							}
						}

						//--- ver1.0 ---//
						// //テーブル生成（各tdにidを割り振る）
						// $idum = 0;
						// for ($i = 1; $i < 6 ; $i++) {
						// 	echo '<tr>','<th>', $i ,'</th>';
						// 	for ($j = 1; $j < 6 ; $j++) {
			 			// 			echo '<td ' , 'id="'.$idum.'" ' , 'class="ng"' , ' onClick="judge('.$idum.')"' , '>' , '<input type="hidden" name="ans[]"'.' id="a'.$idum.'"'.' value="0">' , '</td>';//各tdにidを発行（クリックイベント用）、onClickで各idを渡す。
	 					// 			$idum++;
						// 	}
						// 	echo '</tr>' , PHP_EOL;
						// }
					?>
				</table>

				<br />
				<h5 class="green-text">名前を入力！</h5>
				<div class="input-field">
       				<i class="material-icons prefix">account_circle</i>
		       		<input id="icon_prefix" type="text" class="validate" name="name">
       				<label for="icon_prefix">Name</label>
       			</div>
       			<input class="btn" type="submit" value="登録" name="insert" >
			</div>
		</div>
	</form>
	</div>
</div>
</div>

<?php include('footer.html'); ?>

</body>
</html>