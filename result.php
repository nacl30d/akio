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
		exit('DB Effor A(faild to get record)');
	}
	//時間割情報を取得
	$sql = "SELECT sum(mon1), sum(tue1), sum(wed1), sum(thu1), sum(fri1), sum(mon2), sum(tue2), sum(wed2), sum(thu2), sum(fri2), sum(mon3), sum(tue3), sum(wed3), sum(thu3), sum(fri3), sum(mon4), sum(tue4), sum(wed4), sum(thu4), sum(fri4), sum(mon5), sum(tue5), sum(wed5), sum(thu5), sum(fri5) FROM answers WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$ans = $statement->fetch(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	if (!$ans) {
		exit('DB Error B (faild to get record)');
	}
	//名前を取得
	$sql = "SELECT name FROM answers WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$name = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	if (!$name) {
		exit('DB Error C (faild to get record)');
	}
	//行数を取得
	$sql = "SELECT count(name) FROM answers WHERE n = :n;";
	$statement = $pdo -> prepare($sql);
	$statement->execute([':n' => $n]);
	$count = $statement->fetch(PDO::FETCH_ASSOC); //fetch_assoc属性がないとインデックス付配列というオマケがつく
	if (!$count) {
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
	<meta charset="utf-8">
	<!-- GoogleAnalytics -->
	<script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  	ga('create', 'UA-102690858-1', 'auto');
  	ga('send', 'pageview');

	</script>
	<!-- /End GoogleAnalytics -->

	<!-- 2017-10-30 -->
	<link rel="stylesheet" type="text/css" href="css/layerBoard.css" media="all" />

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/jquery.layerBoard.js"></script>
	<script>
	$(function(){

		$('#layer_board_area').layerBoard({alpha:0.5});

	})
	</script>
	<!-- /End 2017-10-30 -->

	<!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="./css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="./js/myscript.js"></script>

    <!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- meta tags for Share -->
	<meta name="description" content="忙しい大学生たちの味方！サークルのメンバーと、ゼミの仲間たちと、友達と、空きコマを照らし合わせることに特化した空きコマ調整ツール：AKIO">
	<meta property="og:title" <?php echo 'content="',h($info['formName']),'|AKIKO"'; ?>/>
	<meta property="og:description" content="忙しい大学生たちの味方！サークルのメンバーと、ゼミの仲間たちと、友達と、空きコマを照らし合わせることに特化した空きコマ調整ツール：AKIO"/>
	<meta property="og:image" content="http://http://akico.azurewebsites.net//img/OGP.png"/>
	<meta property="og:url" content="http://http://akico.azurewebsites.net//"/>
	<meta property="og:type" content="website"/>
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:image:src" content="http://http://akico.azurewebsites.net//img/AKIO.png" />
	<link rel="apple-touch-icon" href="/img/AKIO.png" />

	<title><?php echo h($info['formName']); ?>｜AKIO</title>
</head>
<body>
<!-- config -->
	<!-- Load Facebook SDK for JavaScript -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
  	var js, fjs = d.getElementsByTagName(s)[0];
  	if (d.getElementById(id)) return;
  	js = d.createElement(s); js.id = id;
  	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.10";
  	fjs.parentNode.insertBefore(js, fjs);
  	}(document, 'script', 'facebook-jssdk'));</script>
	<!-- Load LINE SDK for Javascript -->
	<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
	<!-- Load Twitter SDK for Javascript -->
	<script>
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
	</script>

	<!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
<!-- /End config -->

<!-- navibar -->
 <nav class="green darken-4" role="navigation">
 	<div class="nav-wrapper container">
 		<a href="./" class="brand-logo">AKIO</a>
 		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
 		<ul class="right hide-on-med-and-down">
        	<li><a href="/#about" target="_blank">About</a></li>
        	<li><a href="/#howto" target="_blank">How to</a></li>
        	<li><a href="/#create" target="_blank">Create</a></li>
 		</ul>

 		<ul class="side-nav" id="mobile-demo">
 			<li><a href="/" target="_blank">Top</a></li>
        	<li><a href="/#about" target="_blank">About</a></li>
        	<li><a href="/#howto" target="_blank">How to</a></li>
        	<li><a href="/#create" target="_blank">Create</a></li>
      </ul>
     </div>
 </nav>
  <!-- /End navibar -->

  <!-- layer_board -->
<div id="layer_board_area">
	<div class="layer_board_bg"></div>
	<div class="layer_board">
		<p>URLが新しくなりました。再度登録をお願いします。<br>
			従来のURLでは2017年11月1日以降アクセスできません。<br>
		新URL: http://akico.azurewebsites.net/</p>
		<p class="btn_close" font="blue"><a href="./">CLOSE</a></p>
	</div>
</div>
<!-- //layer_board -->

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
	

<!-- footer -->
<footer class="page-footer green">
    <div class="container">
      <div class="row">
        <div class="col l3 s12">
          <h5 class="white-text">D.Salt</h5>
          <p class="grey-text text-lighten-4">This tool made for University Students. I hope your campus life will be better.</p>
        </div>
        <div class="col l3 s12">	
          <h5 class="white-text">Special Thanks</h5>
          <ul>
            <li><a class="white-text" href="https://www.nifty.com/" target="_bla">nifty</a></li>
            <li><a class="white-text" href="http://www.myjlab.org/" target="_bla">Miyaji Lab</a></li>
            <li><a class="white-text" href="http://matsuzawalab.si.aoyama.ac.jp/pub/intro/" target="_bla">Matsuzawa Lab</a></li>
            <li><a class="white-text" href="http://www.si.aoyama.ac.jp/" target="_bla">青山学院大学 社会情報学部</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Share</h5>
          <ul>
          	<!-- LINE -->
            <li><div class="line-it-button" style="display: none;" data-lang="ja" data-type="share-a" data-url="http://http://akico.azurewebsites.net//"></div></li>
            <!-- Twitter -->
            <li><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></li>
            <!-- Facebook -->
            <li><div class="fb-share-button" data-href="http://http://akico.azurewebsites.net/" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fhttp://akico.azurewebsites.net/%2F&amp;src=sdkpreparse">シェア</a></div></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3" href="https://twitter.com/d__salt" target="_bla">D_Salt</a>
      </div>
    </div>
  </footer>
  <!-- /End footer -->

</body>
</html>