<?php
require_once('funcs.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {  ### CARREGA O CONTEUDO PELO ID
	$galeria = carregaConteudo($_GET['id'],array('titulo','video'));
	if ($galeria['erro']) echo $galeria['erro'];
	else {
		/*$url = $galeria['video'];//'http://www.youtube.com/watch?v=wTnChGG2CM0';
		$pattern = '%http://www\.youtube\.com/watch\?([a-z])=([a-z])([a-zA-Z0-9]+)%';
		$replace = '<object width="425" height="344"><param name="movie" value="http://www.youtube.com/$1/$2$3&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/$1/$2$3&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>';
		$video = preg_replace($pattern, $replace, $url);*/
		
$url = $galeria['video'];//'http://www.youtube.com/watch?v=wTnChGG2CM0';

parse_str(parse_url($url, PHP_URL_QUERY), $qstring);

$video = <<<EOF
<object width="425" height="344">
   <param name="movie" value="http://www.youtube.com/v/{$qstring['v']}&hl=en&fs=1"></param>
   <param name="allowFullScreen" value="true"></param>
   <param name="allowscriptaccess" value="always"></param>
   <embed src="http://www.youtube.com/v/{$qstring['v']}&hl=en&fs=1"
          type="application/x-shockwave-flash"
          allowscriptaccess="always"
          allowfullscreen="true"
          width="425"
          height="344"></embed>
</object>
EOF;
		
		$titulo = $galeria['titulo']
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titulo; ?></title>
</head>

<body>
<?php echo $video; ?>
</body>
</html>
        <?php
	}
} else {
	echo "Nenhum v&iacute;deo dispon&iacute;vel!";
}
?>
