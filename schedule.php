<?php
require_once('funcs.php');
?>
<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/agenda.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505" background="marcelobarbosa/imagens/bgnews.jpg">
    <?php
    $eventosArray = listaConteudo('agenda',array('0','30'),array('apelido'=>'data-do-evento','ord'=>'ASC','apenas'=>'>= CURDATE()'),array('data-do-evento','titulo','descricao','cidade','pais'));
    if ($eventosArray['erro']) echo $eventosArray['erro'];
    else {
        foreach ($eventosArray as $evento) {
            $datastring = $evento['data-do-evento'][8].$evento['data-do-evento'][9].'/'.$evento['data-do-evento'][5].$evento['data-do-evento'][6].'/'.$evento['data-do-evento'][0].$evento['data-do-evento'][1].$evento['data-do-evento'][2].$evento['data-do-evento'][3];
            echo '<p><span class="style1">'.$datastring.'</span> | '.$evento['titulo'].'<br />
            Info: '.$evento['descricao'].'<br />
            Cidade: '.$evento['cidade'].' | País: '.$evento['pais'].'</p>';
        }
       // echo '<p align="right"><a href="agenda.php" onclick="return loadPage($(this).attr(\'href\'))"><img src="arquivos/imagens/moreshows.jpg" width="67" height="13" border="0" /></a></p>';
    }
    ?> 
    </td>
</tr>
<tr>
    <td><p>&nbsp;</p><img src="arquivos/imagens/agenda_passada.jpg" width="505" height="33" /></td>
</tr>
<tr>
  <td width="505">
    <?php
    $eventosArray = listaConteudo('agenda',array('0','30'),array('apelido'=>'data-do-evento','ord'=>'DESC','apenas'=>'< CURDATE()'),array('data-do-evento','titulo','descricao','cidade','pais'));
    if ($eventosArray['erro']) echo $eventosArray['erro'];
    else {
        foreach ($eventosArray as $evento) {
            $datastring = $evento['data-do-evento'][8].$evento['data-do-evento'][9].'/'.$evento['data-do-evento'][5].$evento['data-do-evento'][6].'/'.$evento['data-do-evento'][0].$evento['data-do-evento'][1].$evento['data-do-evento'][2].$evento['data-do-evento'][3];
            echo '<p><span class="style1">'.$datastring.'</span> | '.$evento['titulo'].'<br />
            Info: '.$evento['descricao'].'<br />
            Cidade: '.$evento['cidade'].' | País: '.$evento['pais'].'</p>';
        }
        //echo '<p align="right"><a href="agenda.php" onclick="return loadPage($(this).attr(\'href\'))"><img src="arquivos/imagens/moreshows.jpg" width="67" height="13" border="0" /></a></p>';
    }
    ?> 
    </td>
</tr>
<tr>
  <td height="91" valign="top"><p></p>
    </td>
</tr>
</table>