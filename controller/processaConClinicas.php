<?php
	require_once '../model/clinica.php';
    $cli = new Clinica();
	$consulta = $cli->getClinicas();
?>