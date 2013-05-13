<?php
// no direct access
defined('_CMS') or die('Restricted access');

echo  '<h1>Infos de acesso a admin</h1><p>ip/data do último acesso: '.$_SESSION['ip_data_acesso'].'</p>';

echo "<p><a href='index.php?pag=logout'>sair</a></p>";
?>