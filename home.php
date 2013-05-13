<?php
require_once('funcs.php');
?>
<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/news.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505"><p>&nbsp;</p>
    <?php
    $noticiasArray = listaConteudo('noticia',array('0','6'),array('apelido'=>'data','ord'=>'DESC'),array('titulo','data','resumo','link-externo'));
    if ($noticiasArray['erro']) echo $noticiasArray['erro'];
    else {
        foreach ($noticiasArray as $noticia) {
            $datastring = $noticia['data'][8].$noticia['data'][9].' / '.$noticia['data'][5].$noticia['data'][6].' / '.$noticia['data'][0].$noticia['data'][1].$noticia['data'][2].$noticia['data'][3];
            if (!empty($noticia['link-externo'])) $href = '"'.$noticia['link-externo'].'" target="_blank"';
            else $href = '"news.php?id='.$noticia['idConteudo'].'" onclick="return loadPage($(this).attr(\'href\'))"';
            echo '<p>'.$datastring.' - '.$noticia['titulo'].' <a href='.$href.'><br />'.$noticia['resumo'].'</a></p>';
        }
        echo '<p align="right"><a href="news.php" onclick="return loadPage($(this).attr(\'href\'))"><img src="arquivos/imagens/morenews.jpg" width="62" height="14" border="0" /></a></p>';
    }
    ?>              
    <p>&nbsp;</p></td>
</tr>
<tr>
  <td><table width="505" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="505"><img src="arquivos/imagens/shedule.jpg" width="505" height="33" /></td>
    </tr>
    <tr>
      <td><p>&nbsp;</p>
    <?php
    $eventosArray = listaConteudo('agenda',array('0','6'),array('apelido'=>'data-do-evento','ord'=>'ASC','apenas'=>'>= CURDATE()'),array('data-do-evento','titulo','descricao','cidade','pais'));
    if ($eventosArray['erro']) echo $eventosArray['erro'];
    else {
        foreach ($eventosArray as $evento) {
            $datastring = $evento['data-do-evento'][8].$evento['data-do-evento'][9].'/'.$evento['data-do-evento'][5].$evento['data-do-evento'][6].'/'.$evento['data-do-evento'][0].$evento['data-do-evento'][1].$evento['data-do-evento'][2].$evento['data-do-evento'][3];
            echo '<p><span class="style1">'.$datastring.'</span> | '.$evento['titulo'].'<br />
            Info: '.$evento['descricao'].'<br />
            Cidade: '.$evento['cidade'].' | País: '.$evento['pais'].'</p>';
        }
        echo '<p align="right"><a href="schedule.php" onclick="return loadPage($(this).attr(\'href\'))"><img src="arquivos/imagens/moreshows.jpg" width="67" height="13" border="0" /></a></p>';
    }
    ?> 
        <p>&nbsp;</p></td>
    </tr>
    </table></td>
 </tr>
<tr>
  <td height="96" valign="top"><p><a href="http://www.zero10.com.br/zero10/" target="_blank"><img src="arquivos/banners/banner_agenda.jpg" width="503" height="85" border="0" /></a></p>    </td>
</tr>
<tr>
  <td height="98" valign="top"><p><a href="http://www.zero10.com.br/zero10/" target="_blank"><img src="arquivos/banners/banner_agenda2.jpg" width="503" height="85" border="0" /></a></p>
    </td>
</tr>
<tr>
  <td height="91" valign="top"><p><a href="aulas.php"><img src="arquivos/imagens/banner_aulas.jpg" width="503" height="91" border="0" usemap="#Map3" /></a></p>
    </td>
</tr>
</table>
