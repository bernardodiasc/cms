<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

function indexAction() {
	if (isset($_SESSION['mensagem']) && $_SESSION['mensagem'] != '') {
		echo $_SESSION['mensagem'];
		unset($_SESSION['mensagem']);
	}
	renderView('index','index');
}

switch(_get('act','index')) {
	default: indexAction(); break;
}

?>