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
-->
</style>

<table width="505" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td><img src="arquivos/imagens/media.jpg" width="505" height="41" /></td>
</tr>
<tr>
  <td width="505" valign="top" background="arquivos/imagens/bgnews.jpg"><p class="style1 style1">Na Midía &gt;&gt; revistas, entrevistas...</p>
    <table width="505" border="0" cellspacing="0" cellpadding="5">
      <tr><td>
      <script type="text/javascript">
      $(document).ready(function(){
            $("#slider").easySlider({prevText: '<< Voltar',nextText: 'Avançar >>',orientation: 'horizontal'});
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
		//$numtotal = count($assessoria['imagem']);
		foreach($assessoria['imagem'] as $imagem) {
			
			list($unique_key, $upload_dir, $file_ext) = explode("\n",$imagem);
			list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
			list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
			list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
			if ((($counter%3)==0) && ($counter != 0)) echo '</li><li>';
			if ($imgcounter < 1) $display = '';
			else $display = 'display:none;';
			
			//if 
			
			echo '<a href="cms/'.$upload_dir_val.'/'.$unique_key_val.'_resized.'.$file_ext_val.'" class="lightbox" style="margin: 0 15px; '.$display.'" title="'.$assessoria['titulo'].'"><img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" width="130" height="160" border="0" /></a>';
			$imgcounter++;
		}
		//echo $hrefLink.$imgList;
		$counter++;
	}
}
?> 
            </li></ul>
        </div>
     </td> </tr>
    </table>
    <!--<p align="center">paginas [1 , 2 , 3]</p>-->
    <p align="center" class="style2" style="display:block;width:100%;text-align:center; margin: 10px 0;">............................................................................................................................................................................................................................................................</p>
    <p><span class="style1">Videos &gt;&gt; shows, aulas, workshop...</span></p>
<?php

$videosArray = listaConteudo('video',array('0','100'),'',array('titulo','miniatura','descricao'));
if ($videosArray['erro']) echo $videosArray['erro'];
else {
	foreach ($videosArray as $video) {
		list($unique_key, $upload_dir, $file_ext) = explode("\n",$video['miniatura']);
		list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
		list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
		list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
        echo '<table width="505" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="94"><a href="javascript:return false" onclick="javascript: window.open(\'video.php?id='.$video['idConteudo'].'\',\'youtube\',\'scrollbars=yes, fullscreen=no, width=442, height=368, top=50, left=150\')"<img src="cms/'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" border="0" /></a></td>
                <td width="308"><strong>'.$video['titulo'].'</strong><br/>'.$video['descricao'].'</td>
                <td width="73"><a href="javascript:return false" onclick="javascript: window.open(\'video.php?id='.$video['idConteudo'].'\',\'youtube\',\'scrollbars=yes, fullscreen=no, width=442, height=368, top=50, left=150\')"><img src="arquivos/imagens/seta.jpg" width="73" height="70" border="0" /></a></td>
              </tr>
            </table>';
	}
}
?> 
    <!--<p align="center">paginas [1 , 2 , 3]</p>-->    </td>
</tr>
<tr>
  <td height="13">&nbsp;</td>
</tr>
</table>