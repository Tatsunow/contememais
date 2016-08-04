<?php 
require_once "app/init.php";

$util = new util();

?>
<html>
<head>
<title>Colégio Estadual de Jandaia do Sul</title>	
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div class="menu">
<ul>
	
	<li><a href="/cejs">C.E.J.S</a></li>
	<li><a href="galeria.php">Galeria</a></li>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="slider/jquery.bxslider.min.js"></script>
    <!-- bxSlider CSS file -->
    <link href="slider/jquery.bxslider.css" rel="stylesheet" />
	<script>
	$(document).ready(function(){
  $('.bxslider').bxSlider();
});
	</script>
	
</ul>
</div>
<div class="topico">
	
	<a href=''>C.E.J.S</a> - Galeria	
	
</div>
<div class="main">

<ul class="bxslider">
  <li><img src="https://fbcdn-sphotos-d-a.akamaihd.net/hphotos-ak-xtf1/v/t1.0-9/10410371_465983876898286_4303343858437558593_n.jpg?oh=2bacfa96d52806bfb515d49eb27104a1&oe=55E5C577&__gda__=1437717804_0e81c90d5857dc7e10f54d70e5995456" /></li>
  <li><img src="https://fbcdn-sphotos-e-a.akamaihd.net/hphotos-ak-xaf1/v/t1.0-9/11096509_463658150464192_5148088048328182722_n.jpg?oh=027f6616bfcd8c37f6ee25b884a48190&oe=55A4C2E3&__gda__=1437160786_4c744dcd0f73c872a4ef478fdbe64b5a" /></li>
  <li><img src="https://scontent-lga.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/13674_408565685991857_3887334722018250848_n.jpg?oh=245d906c2bb77722221131d84f67c772&oe=559E0DEF" /></li>
  <li><img src="https://scontent-lga.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/1545607_587110928085696_3093498619792116160_n.jpg?oh=c195690131ea7ff49c5e5956849a876f&oe=55E2A9C3"/></li>
  <li><img src="https://fbcdn-sphotos-f-a.akamaihd.net/hphotos-ak-xpf1/v/t1.0-9/1610866_371125103059922_3767417136793799313_n.jpg?oh=3914f2d5c985ce5756902cacd39ae506&oe=55E22272&__gda__=1436491699_414b6081240904a2d919f1226b186474" /></li>
</ul>
	
</div>
<!-- FOOTER -->
<div class="footer">
<span class="credit">Software de Site por Thiago Dlugosz Moraes (Tatsunow)</span>
<span class="item">Redes Sociais</span>
<ul>
<li><a target="_blank" title="Facebook" href="https://www.facebook.com/colegioestadualjandaiadosul"><img src="http://icons.iconarchive.com/icons/sicons/flat-shadow-social/256/facebook-icon.png"/></a></li>
<li><a target="_blank" title="Youtube"><img src="http://wcdn2.dataknet.com/static/resources/icons/set111/1dec2448.png"/></a></li>
</ul>
</div>
</body>
</html>