<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

function indexAction() {
	if (is_logged()) header('Location: index.php');
	renderView('usuario','index');
}

function acessarAction() {
	if (is_logged()) header('Location: index.php');
	
	$u_escape = injection($_POST['nome']);
	$p_escape = injection($_POST['senha']);
	
	$result = mysql_query('SELECT * FROM usuarios WHERE apelido="'.$u_escape.'" AND senha=md5("'.$p_escape.'")');
	
	if(mysql_num_rows($result)<1){
		$_SESSION['mensagem'] = 'Usu&aacute;rio ou senha incorretos, tente novamente!';
		$_SESSION['logged'] = false;
		header('Location: index.php');
	} else {
		unset($_SESSION['mensagem']);
		$tid = mysql_result($result,0,'id');
		$_SESSION['nome'] = mysql_result($result,0,'nome');
		$_SESSION['logged'] = true;
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		
		$ultimavisita = date('Y-m-d H:i:s');
		$ultimoip = $_SERVER['REMOTE_ADDR'];
		mysql_query('UPDATE usuarios SET ultimavisita="'.$ultimavisita.'", ultimoip="'.$ultimoip.'" WHERE id='.$tid);
	
		header('Location: index.php');
	}
}

function sairAction() {
	session_start();
	unset($_SESSION['logged']);
	session_destroy();
	header('location: index.php'); 	
}

switch(_get('act','index')) {
	case 'acessar': acessarAction(); break;
	case 'sair': sairAction(); break;
	default: indexAction(); break;
}

?>