<?php
    require_once('./conf/functions.php');
	session_start();

	//URLに含まれている記事のIDを取得
	$n = $_GET['n'];
	$redirect = "./result.php?n=" . $n; //フォームページはidごとに動的なURLを発行

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		#動作確認テスト用
		// $_SESSION['ans'] = $_POST['ans'];
		$ans = $_POST['ans'];
		if (!$_POST['name']) {
			$_POST['name'] = "名無し";
		}

		#DB接続
		$pdo = connectDB();
		#データ更新
		$sql = "INSERT INTO answers (n, name, mon1, mon2, mon3, mon4, mon5, tue1, tue2, tue3, tue4, tue5, wed1, wed2, wed3, wed4, wed5, thu1, thu2, thu3, thu4, thu5, fri1, fri2, fri3, fri4, fri5) VALUES (:n, :name, :mon1, :mon2, :mon3, :mon4, :mon5, :tue1, :tue2, :tue3, :tue4, :tue5, :wed1, :wed2, :wed3, :wed4, :wed5, :thu1, :thu2, :thu3, :thu4, :thu5, :fri1, :fri2, :fri3, :fri4, :fri5);";
		//データベース関連の処理
		$statement = $pdo -> prepare($sql);
		$result = $statement->execute([
		':n' => $n, ':name' => h($_POST['name']),
        ':mon1' => $ans['0'],':tue1' => $ans['1'], ':wed1' => $ans['2'], ':thu1' => $ans['3'], ':fri1' => $ans['4'],
        ':mon2' => $ans['5'], ':tue2' => $ans['6'], ':wed2' => $ans['7'], ':thu2' => $ans['8'], ':fri2' => $ans['9'],
        ':mon3' => $ans['10'], ':tue3' => $ans['11'], ':wed3' => $ans['12'], ':thu3' => $ans['13'], ':fri3' => $ans['14'],
          ':mon4' => $ans['15'], ':tue4' => $ans['16'], ':wed4' => $ans['17'], ':thu4' => $ans['18'], ':fri4' => $ans['19'],
        ':mon5' => $ans['20'], ':tue5' => $ans['21'], ':wed5' => $ans['22'], ':thu5' => $ans['23'], ':fri5' => $ans['24']
		]);
		if(!$result){
			var_dump($statement->errorinfo());
			exit('DB Error (failed to add record)'); //入に失敗したエラーメッセージ
		}

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
	<meta property="og:title" content="入力画面|AKIKO"/>
	<meta property="og:description" content="忙しい大学生たちの味方！サークルのメンバーと、ゼミの仲間たちと、友達と、空きコマを照らし合わせることに特化した空きコマ調整ツール：AKIO"/>
	<meta property="og:image" content="http://http://akico.azurewebsites.net//img/OGP.png"/>
	<meta property="og:url" content="http://http://akico.azurewebsites.net//"/>
	<meta property="og:type" content="website"/>
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:image:src" content="http://http://akico.azurewebsites.net//img/AKIO.png" />
	<link rel="apple-touch-icon" href="/img/AKIO.png" />

	<title>予定を入力｜AKIO</title>
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
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
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
		<p class="btn_close" font="blue"><a href="#">CLOSE</a></p>
	</div>
</div>
<!-- //layer_board -->

<div class="row">
    <div class="col l6 offset-l3 s12 ">
		<h5 class="green-text">名前を入力！</h5>
	</div>		
</div>			
<div class="row center">
    <div class="col l6 offset-l3 s12 ">
   	 <form action="" method="POST" id="insertForm">
			<div class="input-field">
          		<i class="material-icons prefix">account_circle</i>
          		<input id="icon_prefix" type="text" class="validate" name="name">
          		<label for="icon_prefix">Name</label>
          	</div>
        <!-- <p>Name:</p><input type="text" name="name" value="名無し" /> -->
<div class="row">
    <div class="col l6 offset-l3 s12 ">
			<h5 class="green-text">タップして空きコマ情報を入力！</h5>
	</div>
</div>
			<table class="update">
				<tr><th></th><th>Mon.</th><th>Tue.</th><th>Wed.</th><th>Thu.</th><th>Fri.</th></tr>
				<?php
					//テーブル生成（各tdにidを割り振る）
					$num = 0;
					for ($i = 1; $i < 6 ; $i++) { 
						echo '<tr>','<th>', $i ,'</th>';
						for ($j = 1; $j < 6 ; $j++) { 
	 						echo '<td ' , 'id="'.$num.'" ' , 'class="ng"' , ' onClick="judge('.$num.')"' , '>' , '<input type="hidden" name="ans[]"'.' id="a'.$num.'"'.' value="0">' , '</td>';//各tdにidを発行（クリックイベント用）、onClickで各idを渡す。
	 						$num++;
						}
						echo '</tr>' , PHP_EOL;
					}
				?>
			</table>
			<input class="btn" type="submit" value="登録" name="insert" >
		</form>
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