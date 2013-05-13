<form id="adicionar" action="<?php global $tipoArray; echo url('conteudo','atualizar',array('tipo'=>$tipoArray['apelido'])); ?>" method="post" <?php global $enctype; echo $enctype; ?>>
<?php 
global $conteudoArray;
?>
<input type="hidden" name="id" value="<?php echo $conteudoArray['id']; ?>" />
<table border="1" cellpadding="10" cellspacing="0" width="100%">

<?php

global $elementosArray;

foreach($elementosArray as $elemento) {
	renderizar_elementos($elemento,$conteudoArray);
}

?>

<tr>
	<td></td>
	<td><input type="submit" name="submeter" value="Atualizar" id="submeter" /></td>
</tr>

</table>
</form>