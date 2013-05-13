<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

// $iniciar pode ser '0' ou '1' e representa qual sera o valor de ordem do primeiro registro
// '0' retornará o valor mais alto+1, e '1' retornara 0
function ordTable_conteudo($iniciar,$tipo_conteudo,$categoria = '') {
	$conteudos_result = mysql_query('SELECT id, ordem FROM conteudos WHERE tipo_conteudo = "'.$tipo_conteudo.'" ORDER BY ordem');
	$ordemCount = $iniciar;
	while ($conteudo = mysql_fetch_array($conteudos_result)) {
		mysql_query('UPDATE conteudos SET ordem = "'.$ordemCount.'" WHERE id = '.$conteudo['id']);
		$ordemCount++;
	}
	switch ($iniciar) {
		case '0': return $ordemCount; break;
		case '1': return '0'; break;
	}
}

function url($ctrl = 'index',$action = '',$params = array()) {
	$params_serial = '';
	foreach ($params as $key => $value) $params_serial .= '&'.$key.'='.$value;
	$query = '?ctrl='.$ctrl;
	if ($action != '') $query .= '&act='.$action;
	$query .= $params_serial;
	return $query;
}

function renderView($ctrl,$action) {
	include('layout/header.php');
	if (file_exists('views/'.$ctrl.'/'.$action.'.php')) include('views/'.$ctrl.'/'.$action.'.php');
	else include('views/'.$ctrl.'/erro.php?ctrl='.$ctrl.'&act='.$action);
	include('layout/footer.php');
}

function loadController($ctrl) {
	if (file_exists('ctrls/'.$ctrl.'.php')) include('ctrls/'.$ctrl.'.php');
	else include('ctrls/erro.php?ctrl='.$ctrl);
}

function is_logged()
{
	if(!isset($_SESSION['logged']) || !$_SESSION['logged']) return false;
	return true;
}

function conecta($host,$user,$senha,$database){
	$co = mysql_connect($host, $user, $senha) or die ('Configuração de Banco de Dados Errada!');
	mysql_select_db($database, $co) or die ('Banco de Dados Inexistente!');
}

function _post($param,$defvalue = '')
{
	if(!isset($_POST[$param])) 	{
		return $defvalue;
	}
	else {
		return $_POST[$param];
	}
}

function _get($param,$defvalue = '')
{
	if(!isset($_GET[$param])) {
		return $defvalue;
	}
	else {
		return $_GET[$param];
	}
} 

function injection($dado,$tipo = '') {
	switch ($tipo) {
		case 'html':
			$dado = get_magic_quotes_gpc() == 0 ? addslashes($dado) : $dado;
			return $dado;
			break;
		default:
			$dado = strip_tags($dado);
			$dado = trim($dado);
			$dado = get_magic_quotes_gpc() == 0 ? addslashes($dado) : $dado;
			$dado = preg_replace('@(--|\#|;)@s', '', $dado);
			$dado = htmlentities($dado);
			return $dado;
			break;
	}
}

?>