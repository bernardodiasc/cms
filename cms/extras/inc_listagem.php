<?php
// no direct access
defined('_CMS') or die('Restricted access');

if (!is_logged() || !isset($_GET["tipo"]) || $_GET["tipo"] == "") header('Location:index.php?er');
$tipo = injection($_GET["tipo"]);
$tipo_result = mysql_query('SELECT * FROM tipo_conteudo WHERE apelido = "'.$tipo.'"');
if (mysql_num_rows($tipo_result) < 1) header('Location:index.php');

$id_tipo = mysql_result($tipo_result,0,'id');

$tipo_elemento_result = mysql_query("SELECT tipo_elemento.id AS id_tipo, tipo_elemento.nome AS nome_tipo FROM tipo_elemento WHERE tipo_conteudo = '".$id_tipo."' AND listar =1 ORDER BY ordem");
//"SELECT tipo_elemento.id AS id_tipo, tipo_elemento.nome AS nome_tipo, elementos.valor AS valor_elemento FROM tipo_elemento,elementos WHERE tipo_elemento.id = elementos.tipo_elemento AND tipo_conteudo = '".$id_tipo."' AND listar =1 ORDER BY ordem"
$num = mysql_num_rows($tipo_elemento_result);
?>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr><td><a href="?pag=adicionar&tipo=<?php echo mysql_result($tipo_result,0,'apelido'); ?>">Adicionar <?php echo mysql_result($tipo_result,0,'unidade'); ?></a></td></tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th style="width: 10px;">ID</th>
    <th style="width: 10px;">Publicado</th>
<?php
	for ($i=0;$i<$num;$i++) {
		echo "<th>".mysql_result($tipo_elemento_result,$i,'nome_tipo')."</th>";
	}
?>
	<th style="width: 100px;">Categoria</th>
	<th style="width: 150px;">Data</th>
    <th style="width: 100px;">Ações</th>
</tr>
<?php
$elementos = mysql_query("SELECT conteudos.id AS idconteudo,conteudos.estado AS estadoconteudo,conteudos.datacriacao AS datacriacaoconteudo,categorias.titulo AS titulocategoria FROM conteudos,categorias WHERE conteudos.categoria = categorias.id AND conteudos.tipo_conteudo = '".$id_tipo."' ORDER BY conteudos.ordem");
while ($camposlistados = mysql_fetch_array($elementos)) {
	echo "<tr>";
	echo "<td>".$camposlistados['idconteudo']."</td>";
	echo "<td>".$camposlistados['estadoconteudo']."</td>";
	for ($i=0;$i<$num;$i++) {
		$tipo_elemento_id = mysql_result($tipo_elemento_result,$i,'id_tipo');
		$valor_elemento = mysql_query(" SELECT valor FROM elementos WHERE conteudo = '".$camposlistados['idconteudo']."' AND tipo_elemento = '".$tipo_elemento_id."' LIMIT 0 , 1 ");
		echo "<td>".mysql_result($valor_elemento,0,'valor')."</td>";
	}
	echo "<td>".$camposlistados['titulocategoria']."</td>";
	echo "<td>".$camposlistados['datacriacaoconteudo']."</td>";
	echo "<td><a href=\"?pag=editar&id=".$camposlistados['idconteudo']."\">Editar</a> | <a href=\"?pag=excluir&id=".$camposlistados['idconteudo']."\">Excluir</a></td>";
	echo "</tr>";
}
?>
</table>
<?php

?>
