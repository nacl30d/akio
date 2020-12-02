<?= require('./conf/config.php'); ?>
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
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/jquery.layerBoard.js"></script>
	<script>
	$(function(){

		$('#layer_board_area').layerBoard({alpha:0.5});

	})
	</script>
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
	<meta property="og:site-name" content="AKIO|空きコマ調整ツール"/>
	<meta property="og:description" content="忙しい大学生たちの味方！サークルのメンバーと、ゼミの仲間たちと、友達と、空きコマを照らし合わせることに特化した空きコマ調整ツール：AKIO"/>
	<meta property="og:image" content="<?= $url ?>/img/OGP.png"/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="AKIKO" />
	<meta property="og:url" content="<?= $url ?>" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:image:src" content="<?= $url ?>/img/AKIO.png" />
  	<link rel="apple-touch-icon" href="/img/AKIO.png" />
