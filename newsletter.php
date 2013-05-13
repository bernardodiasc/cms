<?php
if ($_POST['controle'] == 1) {
	
	require_once('conecta.php');
	
	$email = mysql_real_escape_string(trim($_POST['email']));
	$uniqid = md5(uniqid(mt_rand(), true));
	
	
	mysql_query('INSERT INTO conteudos (id, tipo_conteudo, categoria, estado, ordem, datacriacao, criado_por, autor, datamodificacao, modificado_por, revisoes, inicio_puiblicacao, termino_publicacao, nivel_acesso, visualizacoes, uninqid) VALUES (NULL, "1", NULL, "1", "0", NOW( ), "1", NULL, CURRENT_TIMESTAMP, NULL, NULL, NOW( ), "0000-00-00 00:00:00", "0", NULL, "'.$uniqid.'")') or die('0');
	$conteudo_result = mysql_query('SELECT id FROM conteudos WHERE uninqid = "'.$uniqid.'"') or die('0');
	$id_conteudo = mysql_result($conteudo_result,0,'id') or die('0');
	mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "6", "'.$email.'", NULL, NULL, NOW( ), NOW( ), NULL)') or die('0');

	die('1');	
}
?>