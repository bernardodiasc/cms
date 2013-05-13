<?php
require_once('funcs.php');
?>
<style type="text/css">
<!--
.style1 {font-size: 16px}
.style2 {
	font-size: 9px;
	color: #392211;
}
.style4 {font-size: 12px}
.style5 {font-size: 8px; color: #392211; }
-->
</style>

<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/media.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505" valign="top" background="arquivos/imagens/bgnews.jpg"><p align="justify" class="style1 style1">Na Midía &gt;&gt; revistas, entrevistas...</p>
    <div align="justify">
      <table width="505" border="0" cellspacing="0" cellpadding="5">
        <tr><td>
          <script type="text/javascript">
      $(document).ready(function(){
            $("#slider").easySlider({prevId: 'btnPrev1',nextId: 'btnNext1',prevText: '<< Voltar',nextText: 'Avançar >>'});
			$("#videos").easySlider({prevId: 'btnPrev2',nextId: 'btnNext2',prevText: '<< Voltar',nextText: 'Avançar >>'});
        });
	  $(function() {
	  		$('.lightbox').lightBox();
	  }); 
      </script>
          <div id="slider">
            <ul><li>
              
              <?php
$assessoriasArray = listaConteudo('na-midia',array('0','100'),'',array('imagem','titulo'));
if ($assessoriasArray['erro']) echo $assessoriasArray['erro'];
else {
	$counter = 0;
	foreach ($assessoriasArray as $assessoria) {
		$imgcounter = 0;
		$numtotal = count($assessoria['imagem']);
		$imagesEcho = '';
		$hrefLink = '';
		
		if ((($counter%3)==0) && ($counter != 0)) echo '</li><li>';
		
		foreach($assessoria['imagem'] as $imagem) {
			
			list($unique_key, $upload_dir, $file_ext) = explode("\n",$imagem);
			list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
			list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
			list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
			if ($numtotal == 1) {
				$hrefLink = '<a href="cms/'.$upload_dir_val.'/'.$unique_key_val.'_resized.'.$file_ext_val.'" class="lightbox" style="margin: 0 15px;" title="'.$assessoria['titulo'].'">';
				$imagesEcho = '<img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" width="130" height="160" border="0" />';
			} else {
				if ($imgcounter == 0) $imagesEcho = '<img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" width="130" height="160" border="0" />';
				else if ($imgcounter == 1) $hrefLink = '<a href="cms/'.$upload_dir_val.'/'.$unique_key_val.'_original.'.$file_ext_val.'" class="lightbox" style="margin: 0 15px;" title="'.$assessoria['titulo'].'">';
			}
			
			$imgcounter++;
		}
		echo $hrefLink.$imagesEcho.'</a>';
		$counter++;
	}
}
?> 
              </li></ul>
            </div>
         </td> </tr>
      </table>
      <!--<p align="center">paginas [1 , 2 , 3]</p>-->
    </div>
    <p align="justify" class="style2" style="display:block;width:100%;text-align:center; margin: 10px 0;">...........................................................</p>
    <p align="justify"><span class="style1">Videos &gt;&gt; shows, aulas, workshop...</span></p>
  <div id="videos" style="display:block; clear:both; height:350px;">
            <ul><li><table width="500" cellpadding="0" cellspacing="0"><tr>
<?php

$videosArray = listaConteudo('video',array('0','100'),'',array('titulo','miniatura','descricao'));
if ($videosArray['erro']) echo $videosArray['erro'];
else {
	$counter = 0;
	foreach ($videosArray as $video) {
		list($unique_key, $upload_dir, $file_ext) = explode("\n",$video['miniatura']);
		list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
		list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
		list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
		if ((($counter%4)==0) && ($counter != 0)) echo '</tr></table></li><li><table width="500" cellpadding="0" cellspacing="0"><tr>';
		if ((($counter%2)==0) && ($counter != 0)) echo '</tr><tr>';
		
        echo '<td><table width="250" border="0" cellspacing="0" cellpadding="5">
              <tr><td><a href="javascript:void(0);" onclick="javascript: window.open(\'video.php?id='.$video['idConteudo'].'\',\'youtube\',\'scrollbars=yes, fullscreen=no, width=442, height=368, top=50, left=150\')"><img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" border="0" /></a></td></tr>
              <tr><td><strong>'.$video['titulo'].'</strong><br/>'.$video['descricao'].'</td></tr>
              <tr><td><a href="javascript:void(0);" onclick="javascript: window.open(\'video.php?id='.$video['idConteudo'].'\',\'youtube\',\'scrollbars=yes, fullscreen=no, width=442, height=368, top=50, left=150\')"><img src="arquivos/imagens/assistir.jpg" width="56" height="12" border="0" /></a></td></tr>
            </table></td>';
		
		$counter++;
	}
}
?> 
    <!--<p align="center">paginas [1 , 2 , 3]</p>-->    
    </tr></table></li></ul>
        </div>
    </td>
</tr>
<tr>
  <td height="13"><p align="center"><span class="style2" style="display:block;width:100%;text-align:center; margin: 10px 0;">.......................................................</span></p>
    <div align="justify">
      <table width="497" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="497"><div align="justify">Wallpapers, escolha o wallpapers para sua resolução e clique para fazer o Download.</div></td>
          </tr>
      </table>
      <table width="350" border="0" cellspacing="0" cellpadding="8">
        <tr>
          <td><img src="arquivos/wallpapers/wall01_thumb.jpg" width="150" height="112" /></td>
            <td><img src="arquivos/wallpapers/wallpaper2_thumb.jpg" width="150" height="113" /></td>
            <td><img src="arquivos/wallpapers/wallpaper3_thumb.jpg" width="150" height="113" /></td>
          </tr>
        <tr>
          <td><div align="center"><span class="style4"><a href="arquivos/wallpapers/wall01_1280x1024.jpg" target="_blank">1280 x 1024</a> / <a href="arquivos/wallpapers/wall01_1280x1024.jpg" target="_blank">1024 x 768</a></span></div></td>
            <td><div align="center"><span class="style4"><a href="arquivos/wallpapers/wallpaper2_1280.jpg" target="_blank">1280 x 1024</a> / <a href="arquivos/wallpapers/wallpaper2_1024.jpg" target="_blank">1024 x 768</a></span></div></td>
            <td><div align="center"><span class="style4"><a href="arquivos/wallpapers/wallpaper2_1280.jpg" target="_blank">1280 x 1024</a> / <a href="arquivos/wallpapers/wallpaper3_1024.jpg" target="_blank">1024 x 768</a></span></div></td>
          </tr>
      </table>
    </div>
    <p align="justify"><span class="style2" style="display:block;width:100%;text-align:center; margin: 10px 0;">....................................................................</span></p>
    
      <div align="justify">
        <table width="493" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="493"><div align="justify">Divulgue Marcelo Barbosa!!! basta copiar os códigos abaixo dos banner’s e     colar no seu myspace, orkut, fotolog e similares.</div></td>
          </tr>
        </table>
      </div>
      <p align="justify"><img src="arquivos/banners/banner01.jpg" width="468" height="90" /></p>
    <div align="justify">
      <table width="468" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="468">&lt;a href=&quot;http://www.kikoloureiro.com.br&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;http://www.marcelobarbosa.com.br/arquivos/banners/banner01.jpg&quot; </td>
          </tr>
      </table>
    </div>
    <p align="justify"><img src="arquivos/banners/banner02.jpg" width="468" height="90" /></p>
    <div align="justify">
      <table width="466" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="466">&lt;a href=&quot;http://www.kmarcelobarbosa.com.br&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;http://www.marcelobarbosa.com.br/arquivos/banners/banner02.jpg&quot; </td>
          </tr>
      </table>
    </div></td>
</tr>
</table>