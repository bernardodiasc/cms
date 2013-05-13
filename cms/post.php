<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

function post_calendario($id_conteudo,$elemento = array(),$metodo) {
	$dataArray = explode(' ',injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])));
	$mes = str_replace(array('janeiro','fevereiro','março','mar&ccedil;o','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'), array('01','02','03','03','04','05','06','07','08','09','10','11','12'), strtolower($dataArray[2]));
	$data = $dataArray[3].'-'.$mes.'-'.$dataArray[1].' 00:00:00';
	switch ($metodo) {
		case 'inserir': 
			mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "'.$elemento['id'].'", "'.$data.'", NULL, NULL, NOW( ), NOW( ), NULL)') or die(mysql_error());
			break;
		case 'atualizar':
			mysql_query('UPDATE elementos SET valor = "'.$data.'", datamodificacao = NOW( ) WHERE id = "'.injection(_post("id_".$elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])).'" AND conteudo = "'.$id_conteudo.'"') or die(mysql_error());
			break;
	}
}

function post_texto($id_conteudo,$elemento = array(),$metodo) {
	switch ($metodo) {
		case 'inserir': 
			mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "'.$elemento['id'].'", "'.injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])).'", NULL, NULL, NOW( ), NOW( ), NULL)') or die(mysql_error());
			break;
		case 'atualizar':
			mysql_query('UPDATE elementos SET valor = "'.injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])).'", datamodificacao = NOW( ) WHERE id = "'.injection(_post("id_".$elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])).'" AND conteudo = "'.$id_conteudo.'"') or die(mysql_error());
			break;
	}
}

function post_textarea($id_conteudo,$elemento = array(),$metodo) {
	//
}

function post_html($id_conteudo,$elemento = array(),$metodo) {
	switch ($metodo) {
		case 'inserir': 
			mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "'.$elemento['id'].'", "'.injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']),'html').'", NULL, NULL, NOW( ), NOW( ), NULL)') or die(mysql_error());
			break;
		case 'atualizar':
			mysql_query('UPDATE elementos SET valor = "'.injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']),'html').'", datamodificacao = NOW( ) WHERE id = "'.injection(_post("id_".$elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])).'" AND conteudo = "'.$id_conteudo.'"') or die(mysql_error());
			break;
	}
}

function post_checkbox($id_conteudo,$elemento = array(),$metodo) {
	//
}

function post_radio($id_conteudo,$elemento = array(),$metodo) {
	//
}

function post_select($id_conteudo,$elemento = array(),$metodo) {
	//
}

function post_imagem($id_conteudo,$elemento = array(),$metodo) {
	$upload_keys = _post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']);
	if (!empty($upload_keys)) {
		switch ($metodo) {
			case 'inserir': 
				$upload_keys = _post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']);
				$ordem = 0;
				foreach ($upload_keys as $value) {
					$upload_result = mysql_query('SELECT * FROM upload_temp WHERE upload_key = "'.$value.'"');
							
					$valor = 'unique_key='.mysql_result($upload_result,0,'unique_key').'\n';
					$valor .= 'upload_dir='.mysql_result($upload_result,0,'upload_dir').'\n';
					$valor .= 'file_ext='.mysql_result($upload_result,0,'file_ext');
					
					mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "'.$elemento['id'].'", "'.$valor.'", NULL, NULL, NOW( ), NOW( ), "'.$ordem.'")') or die(mysql_error());
					$ordem++;
					
					mysql_query('DELETE FROM upload_temp WHERE upload_key = "'.$value.'"');
				}
				break;
			case 'atualizar':
				$upload_keys = _post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']);
			
				$elementos_result = mysql_query('SELECT id FROM elementos WHERE conteudo = '.$id_conteudo.' AND tipo_elemento = '.$elemento['id']);
				
				while ($elemento_atualizacao = mysql_fetch_array($elementos_result)) {
					$imgOut = 1;
					foreach ($upload_keys as $imgKeys) if ($elemento_atualizacao['id'] == $imgKeys) $imgOut = 0;
					if ($imgOut == 1) mysql_query('DELETE FROM elementos WHERE id = "'.$elemento_atualizacao['id'].'"');
				}
				
				$ordem = 0;
				foreach ($upload_keys as $value) {
					if (mysql_num_rows(mysql_query('SELECT id FROM elementos WHERE id = '.$value)) > 0) {
						mysql_query('UPDATE elementos SET ordem = "'.$ordem.'", datamodificacao = NOW( ) WHERE id = "'.$value.'"');
					}
					else {
						$upload_result = mysql_query('SELECT * FROM upload_temp WHERE upload_key = "'.$value.'"');
								
						$valor = 'unique_key='.mysql_result($upload_result,0,'unique_key').'\n';
						$valor .= 'upload_dir='.mysql_result($upload_result,0,'upload_dir').'\n';
						$valor .= 'file_ext='.mysql_result($upload_result,0,'file_ext');
						
						mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "'.$elemento['id'].'", "'.$valor.'", NULL, NULL, NOW( ), NOW( ), "'.$ordem.'")') or die(mysql_error());
				
						mysql_query('DELETE FROM upload_temp WHERE upload_key = "'.$value.'"');
					}
					$ordem++;
				}
				break;
		}
	}
}

function post_audio($id_conteudo,$elemento = array(),$metodo) {
	//
}

function post_video($id_conteudo,$elemento = array(),$metodo) {
	switch ($metodo) {
		case 'inserir': 
			mysql_query('INSERT INTO elementos (id, conteudo, tipo_elemento, valor, atributos, grupo, datacriacao, datamodificacao, ordem) VALUES (NULL, "'.$id_conteudo.'", "'.$elemento['id'].'", "'.injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']),'html').'", NULL, NULL, NOW( ), NOW( ), NULL)') or die(mysql_error());
			break;
		case 'atualizar':
			mysql_query('UPDATE elementos SET valor = "'.injection(_post($elemento['id']."_".$elemento['tipo']."_".$elemento['apelido']),'html').'", datamodificacao = NOW( ) WHERE id = "'.injection(_post("id_".$elemento['id']."_".$elemento['tipo']."_".$elemento['apelido'])).'" AND conteudo = "'.$id_conteudo.'"') or die(mysql_error());
			break;
	}
}

function post_flash($id_conteudo,$elemento = array(),$metodo) {
	//
}

function post_arquivo($id_conteudo,$elemento = array(),$metodo) {
	//
}


function post_elementos($id_conteudo,$elemento = array(),$metodo) {
	switch ($elemento['tipo']) {
		case "calendario": post_calendario($id_conteudo,$elemento,$metodo); break;
		case "texto": post_texto($id_conteudo,$elemento,$metodo); break;
		case "textarea": post_textarea($id_conteudo,$elemento,$metodo); break;
		case "html": post_html($id_conteudo,$elemento,$metodo); break;
		case "checkbox": post_checkbox($id_conteudo,$elemento,$metodo); break;
		case "radio": post_radio($id_conteudo,$elemento,$metodo); break;
		case "select": post_select($id_conteudo,$elemento,$metodo); break;
		case "imagem": post_imagem($id_conteudo,$elemento,$metodo); break;
		case "audio": post_audio($id_conteudo,$elemento,$metodo); break;
		case "video": post_video($id_conteudo,$elemento,$metodo); break;
		case "flash": post_flash($id_conteudo,$elemento,$metodo); break;
		case "arquivo": post_arquivo($id_conteudo,$elemento,$metodo); break;
	}
}
?>