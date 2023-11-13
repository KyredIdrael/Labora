<?php
	/*if (empty($_SESSION)) session_start();

	if (empty($_SESSION['UserID']) || empty($_SESSION['UserName']) || empty($_SESSION['UserEmail'])) {
		session_destroy();
		header("Location: http://localhost/tazware/v/index.php?error=5"); exit;
	}*/
	if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Endereco") {
        require_once '../model/endereco.php';
        $end = new Endereco();
		$consulta = $end->selectAll();
	}	
	else if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Clinica") {
            require_once '../model/clinica.php';
        $cli = new Clinica();
		$consulta = $cli->selectAll();
	}
	else if (isset($_GET) && isset($_GET['table'])
		&& $_GET['table'] == "Funcionario") {
            require_once '../model/func.php';
        $fun = new Funcionario();
		$consulta = $fun->selectAll();
	}
?>