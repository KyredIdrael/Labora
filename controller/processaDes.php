<?php
	/*if (empty($_SESSION)) session_start();

	if (empty($_SESSION['UserID']) || empty($_SESSION['UserName']) || empty($_SESSION['UserEmail'])) {
		session_destroy();
		header("Location: http://localhost/tazware/v/index.php?error=5"); exit;
	}*/
	if (isset($_GET) && isset($_GET['id_ex'])
		&& isset($_GET['table'])
		&& ($_GET['table'] == "Clinica")) {
			require_once '../model/Clinica.php';
			$cli = new Clinica();
			$cli->id = addslashes($_GET['id_ex']);
			$cli->dasabilitaClinica();

	} else if ($_GET['table'] == "Endereco") {
		require_once '../model/Clinica.php';
		$end = new Endereco();
		$end->id = addslashes($_GET['id_ex']);
		$end->dasbilitaEndereco();

	} else if ($_GET['table'] == "Cliente") {
		require_once '../model/cliente.php';
		$cli = new Cliente();
		$cli->id = addslashes($_GET['id_ex']);
		$cli->desabilitaCliente();		
	}
	header('Location: ../v/consulta.php?table='.addslashes($_GET['table']));
?>