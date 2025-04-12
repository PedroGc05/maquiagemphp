<?php
session_start();
include_once('includes/functions.php');

// Destruir a sessão
$_SESSION = array();
session_destroy();

// Redirecionar para a página inicial
header('Location: index.php');
exit;
?>
