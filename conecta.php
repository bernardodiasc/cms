<?php
function conecta($host,$user,$senha,$database){
	$co = mysql_connect($host, $user, $senha) or die ('Configuração de Banco de Dados Errada!');
	mysql_select_db($database, $co) or die ('Banco de Dados Inexistente!');
}

switch ($_SERVER['REMOTE_ADDR']) {
	case '127.0.0.1':
		$configHost = 'localhost';
		$configUser = 'root';
		$configSenha = 'security';
		$configDatabase = 'cms';
		break;
	default:
		$configHost = 'localhost';
		$configUser = 'root';
		$configSenha = 'securitypassword';
		$configDatabase = 'cms';
		break;
}

conecta($configHost,$configUser,$configSenha,$configDatabase);
?>