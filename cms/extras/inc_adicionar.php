<?php
// no direct access
defined('_CMS') or die('Restricted access');

if (!is_logged() || !isset($_GET["tipo"]) || $_GET["tipo"] == "") header('Location:index.php?er');
$tipo = injection($_GET["tipo"]);
$tipo_result = mysql_query('SELECT * FROM tipo_conteudo WHERE apelido = "'.$tipo.'"');
if (mysql_num_rows($tipo_result) < 1) header('Location:index.php');

require_once("render.php");

$id_tipo = mysql_result($tipo_result,0,'id');

$tipoelementos_result = mysql_query("SELECT * FROM tipo_elemento WHERE tipo_conteudo = '".$id_tipo."' ORDER BY ordem");
?>
<form id="" action="?pag=salvar" method="post">
<input type="hidden" name="" value="" />
<table border="1" cellpadding="10" cellspacing="0" width="100%">

<?php
while ($elementos = mysql_fetch_array($tipoelementos_result)) {
	renderizar_elementos($elementos);
}
?>

<tr>
	<td></td>
	<td><input type="submit" name="submeter" value="Salvar" id="submeter" /></td>
</tr>

</table>
</form>