<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

if (injection(_get('tipo')) == '') header('Location: index.php');

## TIPO DE CONTEÚDO
$tipo_result = mysql_query('SELECT * FROM tipo_conteudo WHERE apelido = "'.injection(_get('tipo')).'"');
if (mysql_num_rows($tipo_result) < 1) header('Location: index.php');	
global $tipoArray;
$tipoArray = mysql_fetch_array($tipo_result);

function indexAction() {
	global $tipoArray;
	
	## TIPOS DE ELEMENTOS
	$tipo_elemento_result = mysql_query('SELECT tipo_elemento.id AS id_tipo, tipo_elemento.nome AS nome_tipo FROM tipo_elemento WHERE tipo_conteudo = "'.$tipoArray['id'].'" AND listar = 1 ORDER BY ordem');
	global $num_tipo_elemento;
	$num_tipo_elemento = mysql_num_rows($tipo_elemento_result);
	
	global $tipo_elementoArray;
	$tipo_elemento_count = 0;
	while ($tipo_elemento = mysql_fetch_array($tipo_elemento_result)) {
		$tipo_elementoArray[$tipo_elemento_count] = $tipo_elemento['nome_tipo'];
		$tipo_elemento_count++;
	}

	## RECUPERA REGISTROS DE CONTEÚDO
	// To Do - a linha abaixo é uma query com Categoria ;)
	//$conteudo_result = mysql_query('SELECT conteudos.id AS idconteudo,conteudos.estado AS estadoconteudo,conteudos.datacriacao AS datacriacaoconteudo,categorias.titulo AS titulocategoria FROM conteudos,categorias WHERE conteudos.categoria = categorias.id AND conteudos.tipo_conteudo = "'.$tipoArray['id'].'" ORDER BY conteudos.ordem');
	$conteudo_result = mysql_query('SELECT conteudos.id AS idconteudo,conteudos.estado AS estadoconteudo,conteudos.datacriacao AS datacriacaoconteudo FROM conteudos WHERE conteudos.tipo_conteudo = "'.$tipoArray['id'].'" ORDER BY conteudos.ordem');
	global $conteudoArray;
	$counterConteudo = 0;
	while ($conteudo = mysql_fetch_array($conteudo_result)) {
		$conteudoArray[$counterConteudo]['idconteudo'] = $conteudo['idconteudo'];
		$conteudoArray[$counterConteudo]['estadoconteudo'] = $conteudo['estadoconteudo'];
		//$conteudoArray[$counterConteudo]['titulocategoria'] = $conteudo['titulocategoria'];
		$conteudoArray[$counterConteudo]['datacriacaoconteudo'] = $conteudo['datacriacaoconteudo'];
		for ($i=0;$i<$num_tipo_elemento;$i++) {
			$valor_elemento = mysql_query('SELECT valor FROM elementos WHERE conteudo = "'.$conteudo['idconteudo'].'" AND tipo_elemento = "'.mysql_result($tipo_elemento_result,$i,'id_tipo').'" LIMIT 0 , 1 ');
			//echo 'SELECT valor FROM elementos WHERE conteudo = "'.$conteudo['idconteudo'].'" AND tipo_elemento = "'.mysql_result($tipo_elemento_result,$i,'id_tipo').'" LIMIT 0 , 1 ';
			$conteudoArray[$counterConteudo]['valor'][$i] = mysql_result($valor_elemento,0,'valor');
			mysql_free_result($valor_elemento);
		}
		$counterConteudo++;
	}
	
	global $viewTitle;
	$viewTitle = $tipoArray['nome'];
	renderView('conteudo','index');
}

function adicionarAction() {
	global $tipoArray;
	
	// To Do =]
	//$categorias_result = mysql_query('SELECT * FROM categorias WHERE tipo_conteudo = "'.$tipoArray['id'].'"');
	//global $categoriasArray;
	//$categoriasArray = mysql_fetch_array($categorias_result);
	
	## RECUPERA INFORMAÇÕES SOBRE OS TIPOS DE ELEMENTOS E TRANSFERE AS INFORMAÇÕES PARA UM ARRAY
	$tipo_elemento_result = mysql_query('SELECT * FROM tipo_elemento WHERE tipo_conteudo = "'.$tipoArray['id'].'" ORDER BY ordem');
	
	global $elementosArray;
	$counterElemento = 0;
	while ($elementos = mysql_fetch_array($tipo_elemento_result)) {
		$elementosArray[$counterElemento]['id'] = $elementos['id'];
		$elementosArray[$counterElemento]['tipo_conteudo'] = $elementos['tipo_conteudo'];
		$elementosArray[$counterElemento]['tipo'] = $elementos['tipo'];
		$elementosArray[$counterElemento]['nome'] = $elementos['nome'];
		$elementosArray[$counterElemento]['apelido'] = $elementos['apelido'];
		$elementosArray[$counterElemento]['label'] = $elementos['label'];
		$elementosArray[$counterElemento]['descricao'] = $elementos['descricao'];
		$elementosArray[$counterElemento]['parametros'] = $elementos['parametros'];
		$elementosArray[$counterElemento]['ordem'] = $elementos['ordem'];
		$elementosArray[$counterElemento]['padrao'] = $elementos['padrao'];
		$elementosArray[$counterElemento]['validacao'] = $elementos['validacao'];
		$elementosArray[$counterElemento]['multiplo'] = $elementos['multiplo'];
		$elementosArray[$counterElemento]['oculto'] = $elementos['oculto'];
		$elementosArray[$counterElemento]['leitura'] = $elementos['leitura'];
		$elementosArray[$counterElemento]['listar'] = $elementos['listar'];
		$elementosArray[$counterElemento]['datacriacao'] = $elementos['datacriacao'];
		$counterElemento++;
	}
	
	require_once("render.php");
	
	global $viewTitle;
	$viewTitle = 'Adicionar '.$tipoArray['unidade'];
	renderView('conteudo','adicionar');
}

function salvarAction() {
	global $tipoArray;
			
	## SALVA UM NOVO REGISTRO DE CONTEÚDO
	$ordem = ordTable_conteudo('1',$tipoArray['id']);
	$uniqid = md5(uniqid(mt_rand(), true));
	mysql_query('INSERT INTO conteudos (id, tipo_conteudo, categoria, estado, ordem, datacriacao, criado_por, autor, datamodificacao, modificado_por, revisoes, inicio_puiblicacao, termino_publicacao, nivel_acesso, visualizacoes, uninqid) VALUES (NULL, "'.$tipoArray['id'].'", NULL, "1", "'.$ordem.'", NOW( ), "1", NULL, CURRENT_TIMESTAMP, NULL, NULL, NOW( ), "0000-00-00 00:00:00", "0", NULL, "'.$uniqid.'")');

	$conteudo_result = mysql_query('SELECT id FROM conteudos WHERE uninqid = "'.$uniqid.'"');
	$id_conteudo = mysql_result($conteudo_result,0,'id');
	
	## RECUPERA INFORMAÇÕES SOBRE OS TIPOS DE ELEMENTOS E EXECUTA O POST DE CADA UM
	$tipo_elemento_result = mysql_query('SELECT * FROM tipo_elemento WHERE tipo_conteudo = "'.$tipoArray['id'].'" ORDER BY ordem');
	
	require_once("post.php");
	
	while ($elemento = mysql_fetch_array($tipo_elemento_result)) {
		post_elementos($id_conteudo,$elemento,'inserir');
	}
	
	header('Location: index.php'.url('conteudo','index',array('tipo'=>$tipoArray['apelido'])));
}

function editarAction() {
	global $tipoArray;
	
	## RECUPERA REGISTRO DE CONTEÚDO
	$conteudo_result = mysql_query('SELECT * FROM conteudos WHERE id = "'.injection(_get('id')).'"');
	if (mysql_num_rows($conteudo_result) < 1) 
		header('Location: index.php'.url('conteudo','index',array('tipo'=>$tipoArray['apelido'])));	
	global $conteudoArray;
	$conteudoArray = mysql_fetch_array($conteudo_result);
	
	## RECUPERA INFORMAÇÕES SOBRE OS TIPOS DE ELEMENTOS E TRANSFERE AS INFORMAÇÕES PARA UM ARRAY
	$tipo_elemento_result = mysql_query('SELECT * FROM tipo_elemento WHERE tipo_conteudo = "'.$tipoArray['id'].'" ORDER BY ordem');
	
	global $elementosArray;
	$counterElemento = 0;
	while ($elementos = mysql_fetch_array($tipo_elemento_result)) {
		$elementosArray[$counterElemento]['id'] = $elementos['id'];
		$elementosArray[$counterElemento]['tipo_conteudo'] = $elementos['tipo_conteudo'];
		$elementosArray[$counterElemento]['tipo'] = $elementos['tipo'];
		$elementosArray[$counterElemento]['nome'] = $elementos['nome'];
		$elementosArray[$counterElemento]['apelido'] = $elementos['apelido'];
		$elementosArray[$counterElemento]['label'] = $elementos['label'];
		$elementosArray[$counterElemento]['descricao'] = $elementos['descricao'];
		$elementosArray[$counterElemento]['parametros'] = $elementos['parametros'];
		$elementosArray[$counterElemento]['ordem'] = $elementos['ordem'];
		$elementosArray[$counterElemento]['padrao'] = $elementos['padrao'];
		$elementosArray[$counterElemento]['validacao'] = $elementos['validacao'];
		$elementosArray[$counterElemento]['multiplo'] = $elementos['multiplo'];
		$elementosArray[$counterElemento]['oculto'] = $elementos['oculto'];
		$elementosArray[$counterElemento]['leitura'] = $elementos['leitura'];
		$elementosArray[$counterElemento]['listar'] = $elementos['listar'];
		$elementosArray[$counterElemento]['datacriacao'] = $elementos['datacriacao'];
		$counterElemento++;
	}
	
	require_once("render.php");
	
	global $viewTitle;
	$viewTitle = 'Editar '.$tipoArray['unidade'];
	renderView('conteudo','editar');
}

function atualizarAction() {
	global $tipoArray;
	
	## RECUPERA REGISTRO DE CONTEÚDO
	$conteudo_result = mysql_query('SELECT * FROM conteudos WHERE id = "'.injection(_post('id')).'"');
	if (mysql_num_rows($conteudo_result) < 1) 
		header('Location: index.php'.url('conteudo','index',array('tipo'=>$tipoArray['apelido'])));	
	global $conteudoArray;
	$conteudoArray = mysql_fetch_array($conteudo_result);
	
	## ATUALIZA REGISTRO DE CONTEÚDO
	mysql_query('UPDATE conteudos SET datamodificacao = NOW( ) WHERE id = '.$tipoArray['id'].'');
	
	## RECUPERA INFORMAÇÕES SOBRE OS TIPOS DE ELEMENTOS E EXECUTA O POST DE CADA UM
	$tipo_elemento_result = mysql_query('SELECT * FROM tipo_elemento WHERE tipo_conteudo = "'.$tipoArray['id'].'" ORDER BY ordem');
	
	require_once("post.php");
	
	while ($elemento = mysql_fetch_array($tipo_elemento_result)) {
		post_elementos($conteudoArray['id'],$elemento,'atualizar');
	}
	
	header('Location: index.php'.url('conteudo','index',array('tipo'=>$tipoArray['apelido'])));
}

function excluirAction() {
	global $tipoArray;
	
	## RECUPERA REGISTRO DE CONTEÚDO
	$conteudo_result = mysql_query('SELECT * FROM conteudos WHERE id = "'.injection(_get('id')).'"');
	
	if (mysql_num_rows($conteudo_result) < 1) 
		header('Location: index.php'.url('conteudo','index',array('tipo'=>$tipoArray['apelido'])));	
	
	## APAGA REGISTRO DE CONTEÚDO
	mysql_query('DELETE FROM conteudos WHERE id = "'.injection(_get('id')).'"');
	
	header('Location: index.php'.url('conteudo','index',array('tipo'=>$tipoArray['apelido'])));
}

switch(_get('act','index')) {
	case 'adicionar': adicionarAction(); break;
	case 'salvar': salvarAction(); break;
	case 'editar': editarAction(); break;
	case 'atualizar': atualizarAction(); break;
	case 'excluir': excluirAction(); break;
	default: indexAction(); break;
}

?>