<?php
if (isset($_SESSION['mensagem']) && $_SESSION['mensagem'] != '') {
	echo $_SESSION['mensagem'];
	unset($_SESSION['mensagem']);
}
?>
<form action="<?php echo url('usuario','acessar'); ?>" method="post">
<input name="nome" type="text" />
<input name="senha" type="password" />
<input name="submeter" type="submit" value="Submeter" />
</form>