<?php
// no direct access
defined('_CMS') or die('Restricted access');

session_start();
unset($_SESSION['goats']);
session_destroy();
header("location:index.php"); 
?>