<?php
error_reporting(0);
	if (empty($_SESSION)) session_start();

	if (empty($_SESSION['id']) || empty($_SESSION['email']) || empty($_SESSION['nivelAcesso'])) {
		session_destroy();
		header("Location: ../view/public.php");
		exit;
	}
	if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Endereco") {
        require_once '../model/endereco.php';
        $end = new Endereco();
		$consulta = $end->selectAll();
		echo $consulta;
	}	
	else if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Clinica") {
        require_once '../model/clinica.php';
        $cli = new Clinica();
		$consulta = $cli->selectAll();
		echo $consulta;
	}
	else if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Funcionario") {
        require_once '../model/func.php';
        $fun = new Funcionario();
		$consulta = $fun->selectAll();
		echo $consulta;
	}
	else if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Cliente") {
        require_once '../model/cliente.php';
        $fun = new Cliente();
		$consulta = $fun->selectAll();
		echo $consulta;
	}
?>