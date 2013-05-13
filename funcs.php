<?php
require_once('conecta.php');

function listaConteudo($tipo,$limite=array('0','30'),$orenamento=array(),$elementos=array()) {
	
	if (!empty($orenamento['apenas'])) $apenas = 'AND elementos.valor '.$orenamento['apenas'];

	if (empty($orenamento['apelido'])) $listaConteudos = mysql_query('SELECT conteudos.id AS idConteudo
																		FROM conteudos,tipo_conteudo
																		WHERE tipo_conteudo.apelido = "'.$tipo.'"
																		AND conteudos.tipo_conteudo = tipo_conteudo.id
																		AND conteudos.estado = 1
																		LIMIT '.$limite[0].' , '.$limite[1].' ');
	else $listaConteudos = mysql_query('SELECT conteudos.id AS idConteudo
										FROM conteudos, tipo_conteudo, tipo_elemento, elementos
										WHERE tipo_conteudo.apelido = "'.$tipo.'"
										AND tipo_elemento.apelido = "'.$orenamento['apelido'].'"
										AND conteudos.tipo_conteudo = tipo_conteudo.id
										AND elementos.conteudo = conteudos.id
										AND elementos.tipo_elemento = tipo_elemento.id
										'.$apenas.'
										ORDER BY elementos.valor '.$orenamento['ord'].' , conteudos.ordem ASC
										LIMIT '.$limite[0].' , '.$limite[1].' ');

	if (mysql_num_rows($listaConteudos) < 1) {
		$resultado['erro'] = 'Nenhum registro encontrado!';
		return $resultado;
	} else {
		while ($arrayConteudos = mysql_fetch_array($listaConteudos)) {
			$resultado[$arrayConteudos['idConteudo']]['idConteudo'] = $arrayConteudos['idConteudo'];
			
			if (!empty($elementos)) $filtro = 'AND (tipo_elemento.apelido = "'.implode('" OR tipo_elemento.apelido = "',$elementos).'")';
			$listaElementos = mysql_query('SELECT tipo_elemento.id AS idTipoElemento, tipo_elemento.apelido AS apelidoTipoElemento,
											elementos.id AS idElemento, valor AS valorElemento, tipo_elemento.multiplo
											FROM tipo_elemento,elementos
											WHERE elementos.conteudo = '.$arrayConteudos['idConteudo'].'
											AND tipo_elemento.id = elementos.tipo_elemento
											'.$filtro.'
											ORDER BY tipo_elemento.ordem, elementos.ordem');

			$contador = 0;
			while ($arrayElementos = mysql_fetch_array($listaElementos)) {
				if ($arrayElementos['multiplo']) {
					$resultado[$arrayConteudos['idConteudo']][$arrayElementos['apelidoTipoElemento']][$contador] = $arrayElementos['valorElemento'];
					$contador++;
				} else $resultado[$arrayConteudos['idConteudo']][$arrayElementos['apelidoTipoElemento']] = $arrayElementos['valorElemento'];
			}
		}
		return $resultado;
	}
}

function carregaConteudo($id,$elementos=array()) {
	
	if (!empty($elementos)) $filtro = 'AND (tipo_elemento.apelido = "'.implode('" OR tipo_elemento.apelido = "',$elementos).'")';
	$listaElementos = mysql_query('SELECT tipo_elemento.id AS idTipoElemento, tipo_elemento.apelido AS apelidoTipoElemento,
									elementos.id AS idElemento, valor AS valorElemento, tipo_elemento.multiplo
									FROM tipo_elemento,elementos
									WHERE elementos.conteudo = '.$id.'
									AND tipo_elemento.id = elementos.tipo_elemento
									'.$filtro.'
									ORDER BY tipo_elemento.ordem, elementos.ordem');

	$resultado['idConteudo'] = $id;
	
	if (mysql_num_rows($listaElementos) < 1) {
		$resultado['erro'] = 'Nenhum registro encontrado!';
		return $resultado;
	} else {
		$contador = 0;
		while ($arrayElementos = mysql_fetch_array($listaElementos)) {
			if ($arrayElementos['multiplo']) {
				$resultado[$arrayElementos['apelidoTipoElemento']][$contador] = $arrayElementos['valorElemento'];
				$contador++;
			} else $resultado[$arrayElementos['apelidoTipoElemento']] = $arrayElementos['valorElemento'];
		}
	}
	return $resultado;
}

?>
