<?php
// no direct access
defined('_GOTCHA') or die('Restricted access');

function render_calendario($elemento = array(),$conteudo = array()) {
	if (!empty($conteudo)) {
		$conteudo_elemento_result = mysql_query('SELECT * FROM elementos WHERE conteudo = '.$conteudo['id'].' AND tipo_elemento = '.$elemento['id']);
		$data = mysql_result($conteudo_elemento_result,0,'valor');
		
		$mes = str_replace(array('01','02','03','03','04','05','06','07','08','09','10','11','12'), array('Janeiro','Fevereiro','Março','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'), $data[5].$data[6]);
		
		$semana = str_replace(array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'), date("l", mktime(0, 0, 0, $data[8].$data[9], $data[5].$data[6], $data[0].$data[1].$data[2].$data[3])));
		
		$value = $semana.', '.$data[8].$data[9].' '.$mes.' '.$data[0].$data[1].$data[2].$data[3];

		$hiddenId = '<input type="hidden" name="id_'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.mysql_result($conteudo_elemento_result,0,'id').'" />';
	} else {
		$value = $elemento['padrao'];
		$hiddenId = '';
	}
	
	echo '<script type="text/javascript">
	$().ready(function(){
		$("#'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'").datepicker({dateFormat: "DD, dd MM yy", firstDay: 1, showOn: "both", buttonImage: "theme/imgs/calendar.png", buttonImageOnly: true, 
				changeMonth:true, changeYear:true, constrainInput: false, duration:"", nextText:"&gt;", prevText:"&lt;", dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"], dayNamesMin: ["Do", "Se", "Te", "Qa", "Qi", "Se", "Sa"], dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"], monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"], monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"] });
	});
	</script>';
	echo '<tr>';
	echo '<th>'.$elemento['label'].'</th>';
	echo '<td>'.$hiddenId.'<input type="text" name="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.$value.'" id="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" /></td>';
	echo '</tr>';
}

function render_texto($elemento = array(),$conteudo = array()) {
	if (!empty($conteudo)) {
		$conteudo_elemento_result = mysql_query('SELECT * FROM elementos WHERE conteudo = '.$conteudo['id'].' AND tipo_elemento = '.$elemento['id']);
		$value = mysql_result($conteudo_elemento_result,0,'valor');
		$hiddenId = '<input type="hidden" name="id_'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.mysql_result($conteudo_elemento_result,0,'id').'" />';
	} else {
		$value = $elemento['padrao'];
		$hiddenId = '';
	}
	
	echo '<tr>';
	echo '<th><strong>'.$elemento['label'].'</strong><br />'.$elemento['descricao'].'</th>';
	echo '<td>'.$hiddenId.'<input type="text" name="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.$value.'" id="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" /></td>';
	echo '</tr>';
}

function render_textarea($elemento = array(),$conteudo = array()) {
	echo '<tr>';
	echo '<th><strong>'.$elemento['label'].'</strong><br />'.$elemento['descricao'].'</th>';
	echo '<td><textarea name="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" id="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" cols="70" rows="10">'.$elemento['padrao'].'</textarea></td>';
	echo '</tr>';
}

function render_html($elemento = array(),$conteudo = array()) {
	if (!empty($conteudo)) {
		$conteudo_elemento_result = mysql_query('SELECT * FROM elementos WHERE conteudo = '.$conteudo['id'].' AND tipo_elemento = '.$elemento['id']);
		$value = mysql_result($conteudo_elemento_result,0,'valor');
		$hiddenId = '<input type="hidden" name="id_'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.mysql_result($conteudo_elemento_result,0,'id').'" />';
	} else {
		$value = $elemento['padrao'];
		$hiddenId = '';
	}

	echo '<script type="text/javascript">
window.onload = function()
{
	CKEDITOR.replace("'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'",
	{
		customConfig : "'.ABS_PATH.'/cms/js/ckeditor/config.js",
		toolbar : "MyToolbar",
		filebrowserBrowseUrl : "'.ABS_PATH.'/cms/js/ckfinder/ckfinder.html",
		filebrowserImageBrowseUrl : "'.ABS_PATH.'/cms/js/ckfinder/ckfinder.html?Type=Images",
		filebrowserFlashBrowseUrl : "'.ABS_PATH.'/cms/js/ckfinder/ckfinder.html?Type=Flash",
		filebrowserUploadUrl : "'.ABS_PATH.'/cms/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
		filebrowserImageUploadUrl : "'.ABS_PATH.'/cms/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
		filebrowserFlashUploadUrl : "'.ABS_PATH.'/cms/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
	});
};
	</script>';
	echo '<tr>';
	echo '<th><strong>'.$elemento['label'].'</strong><br />'.$elemento['descricao'].'</th>';
	echo '<td>'.$hiddenId.'<textarea name="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" id="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" class="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" cols="70" rows="10">'.$value.'</textarea></td>';
	echo '</tr>';
}

function render_checkbox($elemento = array(),$conteudo = array()) {
	//
}

function render_radio($elemento = array(),$conteudo = array()) {
	//
}

function render_select($elemento = array(),$conteudo = array()) {
	//
}

function render_imagem($elemento = array(),$conteudo = array()) {
	if (!empty($conteudo)) {
		$conteudo_elemento_result = mysql_query('SELECT * FROM elementos WHERE conteudo = '.$conteudo['id'].' AND tipo_elemento = '.$elemento['id'].' ORDER BY ordem');
		if (mysql_num_rows($conteudo_elemento_result) > 0) {
			$imagemCount = 0;
			$value = '';
			while ($imagensArray = mysql_fetch_array($conteudo_elemento_result)) {
				list($unique_key, $upload_dir, $file_ext) = explode("\n",$imagensArray['valor']);
				list($unique_key_var, $unique_key_val) = explode("=",$unique_key);
				list($upload_dir_var, $upload_dir_val) = explode("=",$upload_dir);
				list($file_ext_var, $file_ext_val) = explode("=",$file_ext);
			
				$value .= '<li id="img_'.$imagensArray['id'].'" class="ui-state-default"><a href="'.$upload_dir_val.'/'.$unique_key_val.'_resized.'.$file_ext_val.'" class="gallery_'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'"><img src="'.$upload_dir_val.'/'.$unique_key_val.'_thumbnail.'.$file_ext_val.'" border="0" /></a> | <a onclick="removerImagem(\'img_'.$imagensArray['id'].'\');" style="cursor:pointer;">remover</a><input type="hidden" name="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'[]" value="'.$imagensArray['id'].'" /></li>';
				$imagemCount++;
			}
			$hiddenId = '<input type="hidden" name="id_'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.mysql_result($conteudo_elemento_result,0,'id').'" />';
			$vazio = false;
		} else {
			$value = $elemento['padrao'];
			$hiddenId = '';
			$vazio = true;
		}
	} else {
		$value = $elemento['padrao'];
		$hiddenId = '';
		$vazio = true;
	}
	
	list($tw, $th) = explode("{&}",$elemento['parametros']);
	
	$tipo_conteudo_result = mysql_query('SELECT apelido FROM tipo_conteudo WHERE id = '.$elemento['tipo_conteudo']);
	$tipo_conteudo = mysql_result($tipo_conteudo_result,0,'apelido');
?>
    <tr>
    <th><strong><?php echo $elemento['label']; ?></strong><br /><?php echo $elemento['descricao']; ?></th>
    <td>
    <script type="text/javascript">
	$(function() {
		$('.gallery_<?php echo $elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido']; ?>').lightBox();
	});
	</script>	
	<script type="text/javascript">
    <!--
    function adicionarImagem(){
        var key = Math.floor(Math.random()*9999999999);
        var texto = '<li id="img_'+key+'" class="ui-state-default"><a onclick="uploadImagem('+key+');" style="cursor: pointer;">fazer upload da imagem</a> | <a onclick="removerImagem(\'img_'+key+'\');" style="cursor: pointer;">remover</a></li>';
        $('#lista_<?php echo $elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido']; ?>').append(texto);
        <?php if($elemento['multiplo'] == 0) { ?>
        $('#addimg').empty();
        <?php } ?>
    }
    function removerImagem(key){
        $('#'+key).remove();
        <?php if($elemento['multiplo'] == 0) { ?>
        $('#addimg').html('<a onclick="adicionarImagem();" style="cursor: pointer;">adicionar imagem</a>');
        <?php } ?>
    }
    function uploadImagem(key){
        window.open('index.php?ctrl=imguploadcrop&tipo=<?php echo $tipo_conteudo; ?>&upload_key='+key+'<?php echo '&'.$tw.'&'.$th; ?>','uploadimage','scrollbars=yes, fullscreen=no, width=900px, height=800, top=50, left=150');
    }
    function atualizaImagem(key,thumbnail,resized){
        $('#img_'+key).empty();
        $('#img_'+key).html('<a href="'+resized+'" class="gallery_<?php echo $elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido']; ?>" target="_blank"><img src="'+thumbnail+'" border="0" /></a> | <a onclick="removerImagem(\'img_'+key+'\');" style="cursor: pointer;">remover</a><input type="hidden" value="'+key+'" name="<?php echo $elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido']; ?>[]" />');
    }

    $(function() {
        $('.sortable').sortable();
        $('.sortable').disableSelection();
    });
    //-->
    </script>

    <ul id="lista_<?php echo $elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido']; ?>" class="sortable"><?php echo $value; ?></ul>
    <?php if (($elemento['multiplo'] == 1) || $vazio) { ?>
    <div id="addimg"><a onclick="adicionarImagem();" style="cursor: pointer;">adicionar imagem</a></div>
    <?php } ?>
    </td>
    </tr>
<?php
}

function render_audio($elemento = array(),$conteudo = array()) {
	//
}

function render_video($elemento = array(),$conteudo = array()) {
	if (!empty($conteudo)) {
		$conteudo_elemento_result = mysql_query('SELECT * FROM elementos WHERE conteudo = '.$conteudo['id'].' AND tipo_elemento = '.$elemento['id']);
		$value = mysql_result($conteudo_elemento_result,0,'valor');
		$hiddenId = '<input type="hidden" name="id_'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" value="'.mysql_result($conteudo_elemento_result,0,'id').'" />';
	} else {
		$value = $elemento['padrao'];
		$hiddenId = '';
	}
	
	$parametros = explode('\n',$elemento['parametros']);
	foreach ($parametros as $parametrosValue) {
		$parametro = explode('=',$parametrosValue);
		switch ($parametro[0]) {
			case 'tipo':
				switch ($parametro[1]) {
					case 'embed':
						$result = $hiddenId.'<textarea name="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" id="'.$elemento['id'].'_'.$elemento['tipo'].'_'.$elemento['apelido'].'" cols="70" rows="10">'.$value.'</textarea>';
						break;
				}
				break;
		}
	}
	echo '<tr>';
	echo '<th><strong>'.$elemento['label'].'</strong><br />'.$elemento['descricao'].'</th>';
	echo '<td>'.$result.'</td>';
	echo '</tr>';
}

function render_flash($elemento = array(),$conteudo = array()) {
	//
}

function render_arquivo($elemento = array(),$conteudo = array()) {
	//
}


function renderizar_elementos($elemento = array(),$conteudo = array()) {
	switch ($elemento['tipo']) {
		case "calendario": render_calendario($elemento,$conteudo); break;
		case "texto": render_texto($elemento,$conteudo); break;
		case "textarea": render_textarea($elemento,$conteudo); break;
		case "html": render_html($elemento,$conteudo); break;
		case "checkbox": render_checkbox($elemento,$conteudo); break;
		case "radio": render_radio($elemento,$conteudo); break;
		case "select": render_select($elemento,$conteudo); break;
		case "imagem": render_imagem($elemento,$conteudo); break;
		case "audio": render_audio($elemento,$conteudo); break;
		case "video": render_video($elemento,$conteudo); break;
		case "flash": render_flash($elemento,$conteudo); break;
		case "arquivo": render_arquivo($elemento,$conteudo); break;
	}
}
?>