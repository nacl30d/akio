<?php
    require_once('/conf/functions.php');
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
	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<script src="js/jquery.cookie.js"></script>
	<script src="js/jquery.layerBoard.js"></script>
<!-- 	<script>
		$(function(){
 
		$('#layer_board_area').layerBoard({alpha:0.5});
 
		})
	</script> -->
	<!-- /End 2017-10-30 -->

	<!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="/css/stylesheet.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
    <script type="text/javascript" src="/js/myscript.js"></script>

    <!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- meta tags for Share -->
	<meta name="description" content="忙しい大学生たちの味方！サークルのメンバーと、ゼミの仲間たちと、友達と、空きコマを照らし合わせることに特化した空きコマ調整ツール：AKIO">
	<meta property="og:title" content="AKIKO|空きコマ調整ツール"/>
	<meta property="og:site-name" content="AKIO|空きコマ調整ツール"/>
	<meta property="og:description" content="忙しい大学生たちの味方！サークルのメンバーと、ゼミの仲間たちと、友達と、空きコマを照らし合わせることに特化した空きコマ調整ツール：AKIO"/>
	<meta property="og:image" content="http://http://akico.azurewebsites.net//img/OGP.png"/>
	<meta property="og:url" content="http://http://akico.azurewebsites.net//"/>
	<meta property="og:type" content="website"/>
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:image:src" content="http://http://akico.azurewebsites.net//img/AKIO.png" />
  	<link rel="apple-touch-icon" href="/img/AKIO.png" />

	<title>AKIO</title>
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
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
<!-- /End config -->

<!-- navibar -->
 <nav class="green darken-4" role="navigation">
 	<div class="nav-wrapper container">
 		<a href="./" class="brand-logo">AKIO</a>
 		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
 		<ul class="right hide-on-med-and-down">
        	<li><a href="/#about">About</a></li>
        	<li><a href="/#howto">How to</a></li>
        	<li><a href="/#create">Create</a></li>
 		</ul>

 		<ul class="side-nav" id="mobile-demo">
          <li><a href="/" target="_blank">Top</a></li>
        	<li><a href="/#about">About</a></li>
        	<li><a href="/#howto">How to</a></li>
        	<li><a href="/#create">Create</a></li>
      </ul>
     </div>
 </nav>
  <!-- /End navibar -->


<!-- layer_board -->
<div class="modal">
<div class="pr_box">
<div class="disclaimer_inner">
<p>【モーダルウィンドウ表示】</p>
<div class="disclaimer_bt">
<p class="mg01 red">はいをクリックしてください。</p>
<p><a class="close_modal" href="javascript:;" href="/">はい</a>&nbsp;&nbsp;<a class="close_modal_no" href="http://www.kingsite.jp">いいえ</a>
</div>
</div>
</div>
</div>
<!-- //layer_board -->


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