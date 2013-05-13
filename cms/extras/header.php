<?php
// no direct access
defined('_CMS') or die('Restricted access');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>CMS - Marcelo Barbosa</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="Cache-Control" content="no-nache">
<meta http-equiv="Pragma" content="no-nache">
<meta http-equiv="Expires" content="0">
<link href="css/base.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>

<script type="text/javascript" src="nicEdit/nicEdit.js"></script>
<script type="text/javascript">
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
	//bkLib.onDomLoaded(new nicEditor().panelInstance('area1')});
</script>
</head>
<body>
<div id="wrapper">
	<div id="container">
<?php
if (is_logged()) {
	$tipo_conteudo = mysql_query("SELECT * FROM tipo_conteudo ORDER BY ordem");
?>
	<div id="top">
        <h2>Marcelo Barbosa</h2>
        <span id="logout"><a href='index.php?pag=logout'>sair</a></span>
        <div class="clear"></div>
    </div>
    <ul id="menu">
    	<li><a href="index.php">Página Inicial</a></li>
        <?php
		while ($tipos = mysql_fetch_array($tipo_conteudo)) {
			echo "<li><a href=\"index.php?pag=listagem&tipo=".$tipos['apelido']."\">".$tipos['nome']."</a></li>";	
		}
		?>
    </ul>
<?php
}
?>
	<div id="body">
