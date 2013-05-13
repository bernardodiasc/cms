<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

date_default_timezone_set("America/Sao_Paulo");

$duracao_sessao = 120; // minutos

switch ($_SERVER['REMOTE_ADDR']) {
	case '127.0.0.1':
		$configHost = 'localhost';
		$configUser = 'root';
		$configSenha = 'security';
		$configDatabase = 'cms';
		define('ABS_PATH','http://localhost/cms');
		break;
	default:
		$configHost = 'localhost';
		$configUser = 'root';
		$configSenha = 'securitypassword';
		$configDatabase = 'cms';
		define('ABS_PATH','http://localhost/cms');
		break;
}
?>