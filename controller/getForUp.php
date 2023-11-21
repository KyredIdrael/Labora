<?php
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
		session_destroy();
		header("Location: public.php"); exit;
	}
	if ($_GET['table'] == "Cliente") {
		require_once '../model/cliente.php';
		$cli = new Cliente();
		$cli->id = addslashes($_GET['id_up']);
		$con = $cli->getForUp();

	} else if ($_GET['table'] == "Funcionario" && isset($_SESSION['nivelAcesso'])) {
		require_once '../model/func.php';
		$func = new Funcionario();
		$func->id = addslashes($_GET['id_up']);
		$con = $func->getForUp();

	} else if ($_GET['table'] == "Endereco" && isset($_SESSION['nivelAcesso'])) {
		require_once '../model/endereco.php';
		$end = new Endereco();
		$end->id = addslashes($_GET['id_up']);
		$con = $end->getForUp();

	} else if ($_GET['table'] == "Clinica" && isset($_SESSION['nivelAcesso'])) {
		require_once '../model/clinica.php';
		$cli = new Clinica();
		$cli->id = addslashes($_GET['id_up']);
		$con = $cli->getForUp();

	} else if ($_GET['table'] == "Exame") {
		require_once '../model/exame.php';
		$exa = new Funcionario();
		$exa->id = addslashes($_GET['id_up']);
		$con = $exa->getForUp();
	}
?>