<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

// Define application environment
//defined('APPLICATION_ENV') || define('APPLICATION_ENV', ($_SERVER['REMOTE_ADDR'] ? '127.0.0.1' : 'production'));

require_once('config.php');
require_once('functions.php');

conecta($configHost,$configUser,$configSenha,$configDatabase);

//session_cache_expire($duracao_sessao);
session_start();

$agora = time('d/m/Y G:i:s');
if (!isset($_SESSION['activetime']) || is_null($_SESSION['activetime'])) $_SESSION['activetime'] = $agora;
else {
	if (($agora-$_SESSION['activetime']) > ($duracao_sessao*60)) {
		unset($_SESSION['activetime']);
		unset($_SESSION['nome']);
		unset($_SESSION['ip']);
		$_SESSION['mensagem'] = 'Sua sess&atilde;o expirou, acesse novamente!';
		$_SESSION['logged'] = false;
		header('Location: index.php');
	} else {
		$_SESSION['activetime'] = $agora;
	}
}

if (is_logged()) loadController(_get('ctrl','index'));	
else loadController('usuario');
?>
