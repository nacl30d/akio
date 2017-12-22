config -->
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
      <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
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
<!-- <div id="layer_board_area">
	<div class="layer_board_bg"></div>
	<div class="layer_board">
		<p>URLが新しくなりました。再度登録をお願いします。<br>
			従来のURLでは2017年11月1日以降アクセスできません。<br>
		新URL: http://akico.azurewebsites.net/</p>
		<p class="btn_close" font="blue"><a href="#">CLOSE</a></p>
	</div>
</div> -->
<!-- //layer_board