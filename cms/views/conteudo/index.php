<?php
global $tipoArray;
?>
<table border="1" cellpadding="5" cellspacing="5" width="100%">
<tr><td><a href="<? echo url('conteudo','adicionar',array('tipo'=>$tipoArray['apelido'])); ?>">Adicionar <?php echo $tipoArray['unidade']; ?></a></td></tr>
</table>
<br />
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th style="width: 10px;">ID</th>
    <th style="width: 10px;">Publicado</th>
<?php
	global $num_tipo_elemento;
	global $tipo_elementoArray;
	for ($i=0;$i<$num_tipo_elemento;$i++) {
		echo '<th>'.$tipo_elementoArray[$i].'</th>';
	}
?>
	<!--<th style="width: 100px;">Categoria</th>-->
	<th style="width: 150px;">Data</th>
    <th style="width: 100px;">Ações</th>
</tr>

<?php
global $conteudoArray;
if (count($conteudoArray) < 1) {
	echo '<tr><td colspan="6" style="text-align:center;">Nenhum registro encontrado!</td></tr>';
} else {
	foreach ($conteudoArray as $rowArray) {
		echo '<tr>';
		echo '<td>'.$rowArray['idconteudo'].'</td>';
		echo '<td>'.$rowArray['estadoconteudo'].'</td>';
		for ($i=0;$i<$num_tipo_elemento;$i++) {
			echo '<td>'.$rowArray['valor'][$i].'</td>';
		}
		//echo '<td>'.$rowArray['titulocategoria'].'</td>';
		echo '<td>'.$rowArray['datacriacaoconteudo'].'</td>';
		echo '<td><a href="'.url('conteudo','editar',array('tipo'=>$tipoArray['apelido'],'id'=>$rowArray['idconteudo'])).'">Editar</a> | <a href="'.url('conteudo','excluir',array('tipo'=>$tipoArray['apelido'],'id'=>$rowArray['idconteudo'])).'" onclick="return confirm(\'Deseja realmente excluir o registro #'.$rowArray['idconteudo'].'?\')">Excluir</a></td>';
		echo '</tr>';
	}
}
?>

</table>