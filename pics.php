<?php
require_once('funcs.php');
?>
<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/fotos.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505" valign="top" background="arquivos/imagens/bgnews.jpg"><p>&nbsp;</p>
  <script type="text/javascript">
  $(function() {
		$('.lightbox').lightBox();
  }); 
  </script>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {  ### CARREGA O CONTEUDO PELO ID
	$galeria = carregaConteudo($_GET['id'],array('titulo','imagem','descricao'));
	if ($galeria['erro']) echo $galeria['erro'];
	else {
		echo '<p><strong>'.$galeria['titulo'].'</strong></p><p><small>'.$galeria['descricao'].'</small></p>';
		foreach($galeria['imagem'] as $imagem) {
			
			list($unique_key, $upload_dir, $file_ext) = explode("\n",$imagem);
			list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
			list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
			list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
			echo '<a href="cms/'.$upload_dir_val.'/'.$unique_key_val.'_resized.'.$file_ext_val.'" class="lightbox" title="'.$galeria['titulo'].'"><img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" width="100" height="100" border="0" style="margin: 0 10px;" /></a>';
		}
		echo '<p>&nbsp;</p><p>&nbsp;</p>
				<p align="left"><a href="pics.php" onclick="return loadPage($(this).attr(\'href\'))">&lt;&lt; voltar</a></p> 
				<p>&nbsp;</p>';
	}
} else {  ### CARREGA A LISTAGEM DE CONTEUDOS
	$galeriasArray = listaConteudo('galerias-de-imagens',array('0','100'),'',array('titulo','imagem','descricao'));
	if ($galeriasArray['erro']) echo $galeriasArray['erro'];
	else {
		foreach ($galeriasArray as $galeria) {
            list($unique_key, $upload_dir, $file_ext) = explode("\n",$galeria['imagem'][0]);
            list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
            list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
            list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
			echo '<table width="505" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="100"><a href="pics.php?id='.$galeria['idConteudo'].'" onclick="return loadPage($(this).attr(\'href\'))"><img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" width="100" height="100" border="0" /></a></td>
                  <td width="302"><strong>'.$galeria['titulo'].'</strong><br />'.$galeria['descricao'].'</td>
                  <td width="73"><a href="pics.php?id='.$galeria['idConteudo'].'" onclick="return loadPage($(this).attr(\'href\'))"><img src="arquivos/imagens/seta.jpg" width="73" height="70" border="0" /></a></td>
                </tr>
                </table>';
		}
	}
}
?>

    </td>
</tr>
<tr>
  <td height="13">&nbsp;</td>
</tr>
</table>