<?php
if (isset($_GET['pag']) && !empty($_GET['pag']) && file_exists($_GET['pag'].'.php'))
	$include = $_GET['pag'].'.php'; 
else $include = 'home.php';

require_once('conecta.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Marcelo Barbosa // The Official Website</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #D3BA85;
	background-repeat: no-repeat;
}
body {
	background-color: #000000;
	background-image: url(arquivos/imagens/bg.jpg);
	background-repeat: no-repeat;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-position: top;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #B48032;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #B48032;
}
a:hover {
	text-decoration: underline;
	color: #B48032;
}
a:active {
	text-decoration: none;
	color: #B48032;
}
.style1 {color: #B48032}
#slider ul, #slider li{
	margin:0;
	padding:0;
	list-style:none;
	overflow: hidden;
	}
#slider, #slider li{ 
	width:500px;
	height:180px;
	overflow:hidden; 
	margin: 10px 0;
	}
#videos ul, #videos li{
	margin:0;
	padding:0;
	list-style:none;
	overflow: hidden;
	}
#videos, #videos li{ 
	width:500px;
	height:350px;
	overflow:hidden; 
	margin: 0;
	}
span#prevBtn{}
span#nextBtn{}	
p {
	margin: 10px 0;	
}
-->
</style>
<script src="AC_RunActiveContent.js" language="javascript"></script>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="easySlider1.5.js"></script>
<script language="javascript" type="text/javascript" src="lightbox/js/jquery.lightbox-0.5.min.js"></script>
<link rel="stylesheet" type="text/css" href="lightbox/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" language="javascript">
//$(document).ready(function() {
	//$('.container').click(function(){
	function loadPage(href) {
		var toLoad = href;//$(this).attr('href');
		$('#container').hide('fast',loadContent);
		function loadContent() {
			$('#container').empty();
			$('#load').remove();
			$('#wrapper').prepend('<span id="load"><br><br><br><br><br>CARREGANDO...</span>');
			$('#load').fadeIn('normal');
			$('#container').load(toLoad,'',showNewContent())
		}
		function showNewContent() {
			$('#container').show('normal',hideLoader());
		}
		function hideLoader() {
			$('#load').fadeOut('normal');
		}
		return false;
	}
	//});
//});
</script>
<script type="text/javascript">
jQuery(function($){
	$("#bt_send_news").click(
		function enviar(){
			var email = $("#newsletter").val();
			
			var valid = true;			
			var check = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
			
			if ((!email) || (!check.test(email))) { $("#newsletter").css({ border: "1px solid #ff0000" }); valid = false; }
			else $("#newsletter").css({ border: "none" });			
			
			if (valid) {
				$.ajax({
					type: "POST",
					url: "newsletter.php",
					dataType: "html",
					data: "controle=1&email="+email,
					success: function(msg){
						if(msg == 1){
							alert('Seu e-mail foi cadastrado com sucesso!');
							$("#newsletter").val('');
						} else {
							alert('Ocorreu um erro ao tentar cadastrar o email, tente novamente mais tarde!');
						}
					},
				})
			} else {
				alert("Preencha um email válido.");
			}
		return false;
		}
	);

});
</script>
</head>

<body>
<div align="center">
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="861"><img src="arquivos/imagens/top1.jpg" width="860" height="291" /></td>
    </tr>
    <tr>
      <td><table width="860" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="arquivos/imagens/top2.jpg" width="592" height="22" /></td>
          <td>
		<script language="javascript">
			if (AC_FL_RunContent == 0) {
				alert("This page requires AC_RunActiveContent.js.");
			} else {
				AC_FL_RunContent(
					'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
					'width', '268',
					'height', '22',
					'src', 'mp3',
					'quality', 'high',
					'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
					'align', 'middle',
					'scale', 'showall',
					'wmode', 'window',
					'devicefont', 'false',
					'id', 'menu',
					'name', 'menu',
					'menu', 'false',
					'allowScriptAccess','sameDomain',
					'movie', 'mp3',
					'salign', ''
					); //end AC code
			}
		</script>
		<noscript>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="268" height="22" id="menu" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="allowFullScreen" value="false" />
			<param name="movie" value="mp3.swf" /><param name="menu" value="false" /><param name="quality" value="high" /><embed src="mp3.swf" loop="false" menu="false" quality="high" width="268" height="22" name="menu" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
		</noscript></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><img src="arquivos/imagens/top3.jpg" width="860" height="184" border="0" usemap="#Map" />
          <map name="Map" id="Map5">
            <area shape="rect" coords="496,107,545,132" href="http://marcelogtr-eng.blogspot.com/" target="_blank" />
            <area shape="rect" coords="436,107,485,132" href="http://www.marcelobarbosa.com.br/blog/" target="_blank" />
            <area shape="rect" coords="557,109,604,131" href="http://www.youtube.com/marcelogtr" target="_blank" />
            <area shape="rect" coords="614,107,634,131" href="http://www.myspace.com/marcelobarbosagtr" target="_blank" />
            <area shape="rect" coords="643,112,690,129" href="http://www.orkut.com.br/Main?cmm=4079694#Community.aspx?cmm=4079694" target="_blank" />
            <area shape="rect" coords="701,112,771,129" href="#" />
            <area shape="rect" coords="781,111,857,130" href="http://twitter.com/marcelogtr" target="_blank" />
            <area shape="rect" coords="330,139,376,160" href="home.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="390,139,417,161" href="bio.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="430,138,463,161" href="pics.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="480,138,588,162" href="setup.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="603,139,652,162" href="media.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="665,140,708,162" href="disco.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="724,139,768,161" href="aulas.php" onclick="return loadPage($(this).attr('href'))" />
            <area shape="rect" coords="783,138,855,162" href="contatos.php" onclick="return loadPage($(this).attr('href'))" />
      </map></td>
    </tr>
    <tr>
      <td height="654"><table width="860" border="0" cellspacing="0" cellpadding="0">
       <!--<tr>
          <td><img src="arquivos/imagens/destaques.jpg" width="343" height="41" /></td>
          <td><img src="arquivos/imagens/news.jpg" width="505" height="41" /></td>
          <td><img src="arquivos/imagens/divisa2.jpg" width="12" height="41" /></td>
          </tr>-->
        <tr>
          <td width="343" valign="top"><table width="343" border="0" cellspacing="0" cellpadding="0">
          <tr>
          <td><img src="arquivos/imagens/destaques.jpg" width="343" height="41" /></td>
          </tr>
            <tr>
              <td width="343"><img src="arquivos/imagens/lateral01.jpg" width="330" height="619" border="0" usemap="#Map2" /></td>
            </tr>
            <tr>
              <td><form action="#" method="post"><table width="343" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="232" style="background: url(arquivos/imagens/newsletter.jpg)"><input type="text" name="newsletter" style="background: #271F12; width: 190px; margin: 0 0 0 25px; border: none; color: #E3B584;" id="newsletter" /></td>
                  <td width="98"><input src="arquivos/imagens/btenviar.jpg" type="image" id="bt_send_news" /></td>
                </tr>
              </table></form></td>
            </tr>
          </table></td>
          
          <td width="505" valign="top"><div id="wrapper" style="background:url(arquivos/imagens/bg-titulo.jpg) no-repeat top center; min-height: 136px; height: 136px; height: auto !important;"><span id="load"></span><div id="container" style="width: 505px; display: block; overflow: hidden;">
		  <?php
		  include($include);
		  ?>
          </div></div></td>
          <td width="11" valign="top">
          	<table cellpadding="0"  cellspacing="0" border="0">
              <tr>
                <td><img src="arquivos/imagens/divisa2.jpg" width="12" height="41" /></td>
              </tr>
              <tr>
                <td></td>
              </tr></table>
           </td>
          <!--<td width="12" valign="top"><img src="arquivos/imagens/barra2.jpg" width="12" height="654" /></td>-->
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><img src="arquivos/imagens/down.jpg" width="860" height="117" usemap="#Map4" border="0" /></td>
    </tr>
  </table>
</div>

<map name="Map" id="Map">
<area shape="rect" coords="524,108,547,131" href="#" /><area shape="rect" coords="557,109,604,131" href="#" /><area shape="rect" coords="614,107,634,131" href="#" /><area shape="rect" coords="643,112,690,129" href="#" />
<area shape="rect" coords="701,112,771,129" href="#" /><area shape="rect" coords="781,111,857,130" href="#" /><area shape="rect" coords="329,139,375,160" href="#" />
<area shape="rect" coords="390,139,417,161" href="index.php?pag=bio" />
<area shape="rect" coords="430,138,463,161" href="#" />
<area shape="rect" coords="480,138,588,162" href="#" /><area shape="rect" coords="603,139,652,162" href="#" />
<area shape="rect" coords="665,140,708,162" href="#" />
<area shape="rect" coords="724,139,768,161" href="#" />
<area shape="rect" coords="783,138,855,162" href="#" />
</map>
<map name="Map2" id="Map2"><area shape="rect" coords="25,261,314,388" href="http://www.marcelobarbosa.com.br/blog/" target="_blank" />
<area shape="rect" coords="25,261,314,388" href="#" /><area shape="rect" coords="27,418,312,536" href="#" /><area shape="rect" coords="153,222,231,235" href="bio.php" onclick="return loadPage($(this).attr('href'))" />
</map>
<map name="Map3" id="Map3"><area shape="rect" coords="14,57,220,85" href="#" /></map>
<map name="Map4" id="Map4"><area shape="rect" coords="56,58,173,91" href="http://www.orangeamps.com/" target="_blank" />
<area shape="rect" coords="199,49,278,90" href="http://www.elixirstrings.com/" target="_blank" />
<area shape="rect" coords="308,46,392,90" href="http://www.tagima.com.br/" target="_blank" />
<area shape="rect" coords="425,46,518,90" href="#" /><area shape="rect" coords="561,51,636,95" href="http://www.ibox.ind.br/" target="_blank" />
<area shape="rect" coords="673,57,794,90" href="http://www.santoangelo.com.br/principal.php?lingua=pt&amp;tipo=1" target="_blank" />
</map></body>
</html>
