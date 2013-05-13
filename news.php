<?php
require_once('funcs.php');
?>
<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/news.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505" background="marcelobarbosa/imagens/bgnews.jpg">
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {  ### CARREGA O CONTEUDO PELO ID
	$noticia = carregaConteudo($_GET['id'],array('titulo','data','conteudo'));
	if ($noticia['erro']) echo $noticia['erro'];
	else {
		$datastring = $noticia['data'][8].$noticia['data'][9].' / '.$noticia['data'][5].$noticia['data'][6].' / '.$noticia['data'][0].$noticia['data'][1].$noticia['data'][2].$noticia['data'][3];
		echo '<p><strong>'.$noticia['titulo'].'</strong></p><p><small>'.$datastring.'</small></p><p>'.$noticia['conteudo'].'</p>';
		echo '<p>&nbsp;</p><p>&nbsp;</p>
				<p align="left"><a href="news.php" onclick="return loadPage($(this).attr(\'href\'))">&lt;&lt; voltar</a></p> 
				<p>&nbsp;</p>';
	}
} else {  ### CARREGA A LISTAGEM DE CONTEUDOS
	$noticiasArray = listaConteudo('noticia',array('0','6'),array('apelido'=>'data','ord'=>'DESC'),array('titulo','data','resumo','link-externo'));
	if ($noticiasArray['erro']) echo $noticiasArray['erro'];
	else {
		foreach ($noticiasArray as $noticia) {
			$datastring = $noticia['data'][8].$noticia['data'][9].' / '.$noticia['data'][5].$noticia['data'][6].' / '.$noticia['data'][0].$noticia['data'][1].$noticia['data'][2].$noticia['data'][3];
			if (!empty($noticia['link-externo'])) $href = '"'.$noticia['link-externo'].'" target="_blank"';
			else $href = '"news.php?id='.$noticia['idConteudo'].'" onclick="return loadPage($(this).attr(\'href\'))"';
			echo '<p>'.$datastring.' - '.$noticia['titulo'].' <a href='.$href.'><br />'.$noticia['resumo'].'</a></p>';
		}
	}
}
?>    </td>
</tr>
</table>
