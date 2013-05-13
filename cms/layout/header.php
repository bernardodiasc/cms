<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>Marcelo Barbosa<?php global $viewTitle; if (isset($viewTitle) && $viewTitle != '') echo ' - '.$viewTitle; ?></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="Cache-Control" content="no-nache">
<meta http-equiv="Pragma" content="no-nache">
<meta http-equiv="Expires" content="0">

<script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="js/lightbox/js/jquery.lightbox-0.5.min.js"></script>

<link href="theme/css/base.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
</head>
<body>
<div id="wrapper">
	<div id="container">
        <div id="top">
            <h2>Marcelo Barbosa</h2>
<?php
if (is_logged()) {
	$tipo_conteudo = mysql_query('SELECT * FROM tipo_conteudo ORDER BY ordem');
?>
        	<span id="logout"><a href='<?php echo url('usuario','sair'); ?>'>sair</a></span>
            <div class="clear"></div>
        </div>
      <ul id="menu">
        <li><a href="index.php">P&aacute;gina Inicial</a></li>
            <?php
            while ($tipos = mysql_fetch_array($tipo_conteudo)) {
                echo '<li><a href="'.url('conteudo','index',array('tipo'=>$tipos['apelido'])).'">'.$tipos['nome'].'</a></li>';	
            }
            ?>
      </ul>
<?php
} else {
?>
            <div class="clear"></div>
        </div>
<?php
}
?>
	<div id="body">
