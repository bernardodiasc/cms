<?php
if ($_POST['controle'] == 1) {
	extract($_POST);
	
	$destinatario = "Marcelo Barbosa <marcelogtr@gmail.com>";
	$remetente = "Marcelo Barbosa <marcelogtr@gmail.com>";
	//$mensagem = nl2br($mensagem);
	
	$msg = "
			<div>
				<p>Ol&aacute;, <strong>".utf8_decode($nome)." (".utf8_decode($email).")</strong> enviou uma mensagem registro de representante pelo site!</p>
				<p>Dados do remetente:<br />
				<strong>Assunto:</strong> ".utf8_decode($assunto)."</p>
				<p><strong>Mensagem:</strong></p>
				<p>".nl2br(utf8_decode($mensagem))."</p>
			</div>
		   ";
	
	$header = "From: $remetente \n";
	$header .= "Content-type: text/html \n";

	if (mail("$destinatario","Mensagem enviada pelo site",$msg, $header)){
		print "1";
	} else {
		print "0";
	}		
} else {
?>
<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/contatos.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505" valign="top" background="arquivos/imagens/bgnews.jpg"><p align="justify">&nbsp;</p>
    <div align="justify">
      <script type="text/javascript">
jQuery(function($){
	$("#bt_send").click(
		function enviar(){
			var nome = $("#id_nome").val();
			var assunto = $("#id_assunto").val();
			var email = $("#id_email").val();
			var mensagem = $("#id_mensagem").val();
			
			var valid = true;			
			var check = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
			
			if (!nome) { $("#id_nome").css({ border: "1px solid #ff0000" }); valid = false; }
			else $("#id_nome").css({ border: "none" });
			
			if (!assunto) { $("#id_assunto").css({ border: "1px solid #ff0000" }); valid = false; }
			else $("#id_assunto").css({ border: "1px solid #cccccc" });
						
			if ((!email) || (!check.test(email))) { $("#id_email").css({ border: "1px solid #ff0000" }); valid = false; }
			else $("#id_email").css({ border: "1px solid #cccccc" });
						
			if (!mensagem) { $("#id_mensagem").css({ border: "1px solid #ff0000" }); valid = false; }
			else $("#id_mensagem").css({ border: "1px solid #cccccc" });
			
			
			if (valid) {
				$.ajax({
					type: "POST",
					url: "contatos.php",
					dataType: "html",
					data: "controle=1&nome="+nome+"&assunto="+assunto+"&email="+email+"&mensagem="+mensagem,
					success: function(msg){
						$("#msg_log").html("");
						if(msg == 1){
							$("#msg_log").css({ color: "green" });
							$("#msg_log").html("<b>Mensagem enviada com sucesso!</b>");
							//top.location.href = 'faleconosco.php?msg=sucesso';
						} else {
							$("#msg_log").css({ color: "red" });
							$("#msg_log").html("<b>Houve um erro ao enviar a mensagem.<br />Tente novamente dentro de alguns minutos.</b>");
						}
					},
					beforeSend: function(){
						$("#msg_log").html("<img src=\"images/loadingAnimation.gif\">");
					}
				})
			} else {
				alert("Foram encontrados erros no preenchimento do formulário.\nCorrija os campos destacados depois envie novamente.");
				//return false;
			}
		return false;
		}
	);

});
    </script>
      
      
    </div>
    <form method="post" action="#">
        
        <label for="id_nome">
        <div align="justify">Nome</div>
        </label>
        <div align="justify"><br />
          <input style="font-size: 10px; width: 200px;" name="nome" maxlength="100" id="id_nome" type="text">
          <span class="helptext"></span>
          <br />
          <br />
        </div>
        <label for="id_assunto">
        <div align="justify">Assunto</div>
        </label>
        <div align="justify"><br />
          <input style="font-size: 10px; width: 200px;" name="assunto" maxlength="100" id="id_assunto" class="formlogin" size="50" type="text">
          <span class="helptext"></span>
          <br />
          <br />
        </div>
        <label for="id_email">
        <div align="justify">Email</div>
        </label>
        <div align="justify"><br />
          <input style="font-size: 10px; width: 200px" name="email" id="id_email" class="formlogin">
          <span class="helptext"></span>
          <br />
          <br />
        </div>
        <label for="id_mensagem">
        <div align="justify">Mensagem</div>
        </label> 
        <div align="justify"><br> 
            <textarea style="font-size: 11px; width: 390px; height: 100px;" rows="10" name="mensagem" id="id_mensagem" cols="40" class="formlogin"></textarea>
          <span class="helptext"></span>
          <br />
          <br />
        </div>
        <div style="float: left; margin-top: 25px;" id="msg_log"></div><div style="float: right; height: 50px; margin-top: 25px; margin-right: 25px;">
          <div align="justify">
            <input type="button" value="Enviar" id="bt_send">
          </div>
        </div>
    </form>
    <div style="clear:both"></div>
	<p align="justify">&nbsp;</p>
    <p align="justify"> Marcelo Barbosa English Blog :<br />
<a href="http://www.msplinks.com/MDFodHRwOi8vbWFyY2Vsb2d0ci1lbmcuYmxvZ3Nwb3QuY29t" target="_blank">http://marcelogtr-eng.blogspot.com</a><br />
<br />
Marcelo Barbosa Portuguese Blog:<br />
<a href="http://www.msplinks.com/MDFodHRwOi8vd3d3Lm1hcmNlbG9iYXJib3NhLmNvbS5ici9ibG9n" target="_blank">http://www.marcelobarbosa.com.br/blog</a><br />
<br />
GTR guitar institute:<br />
<a href="http://www.msplinks.com/MDFodHRwOi8vd3d3Lmd0ci5jb20uYnI=" target="_blank">http://www.gtr.com.br</a><br />
<br />
Zero10: <a href="http://www.msplinks.com/MDFodHRwOi8vd3d3Lnplcm8xMC5jb20uYnI=" target="_blank"><br />
http://www.zero10.com.br</a><br />
<br />
Khallice website:<br />
<a href="http://www.msplinks.com/MDFodHRwOi8vd3d3LmtoYWxsaWNlLmNvbS5icg==" target="_blank">http://www.khallice.com.br</a><br />
<br />
Khallice myspace:<br />
<a href="http://www.myspace.com/khallice" target="_blank">http://www.myspace.com/khallice</a><br />
<br />
Almah website: <a href="http://www.msplinks.com/MDFodHRwOi8vd3d3LmFsbWFoLmNvbS5icg==" target="_blank"><br />
http://www.almah.com.br</a><br />
<br />
Almah myspace: <br />
<a href="http://www.myspace.com/almahedufalaschi" target="_blank">http://www.myspace.com/almahedufalaschi</a></p>
    <p align="justify">Webmaster: <br />
    <a href="mailto:artside.contatos@gmail.com" target="_blank">artside.contatos@gmail.com</a></p></td>
</tr>
</table>
<?php
}
?>