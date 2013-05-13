<form id="adicionar" action="<?php global $tipoArray; echo url('conteudo','salvar',array('tipo'=>$tipoArray['apelido'])); ?>" method="post" <?php global $enctype; echo $enctype; ?>>
<table border="1" cellpadding="10" cellspacing="0" width="100%">

<?php

global $elementosArray;

foreach($elementosArray as $elemento) {
	renderizar_elementos($elemento);
}

?>

<tr>
	<td></td>
	<td><input type="submit" name="submeter" value="Salvar" id="submeter" /></td>
</tr>

</table>
</form>