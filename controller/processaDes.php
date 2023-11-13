<?php
	/*if (empty($_SESSION)) session_start();

	if (empty($_SESSION['UserID']) || empty($_SESSION['UserName']) || empty($_SESSION['UserEmail'])) {
		session_destroy();
		header("Location: http://localhost/tazware/v/index.php?error=5"); exit;
	}*/
	if (isset($_GET) && isset($_GET['id_ex'])
		&& isset($_GET['table'])
		&& ($_GET['table'] == "Clinica")) {
			require_once '../m/Clinica.php';
			$cli = new Clinica();
			$cli->id = addslashes($_GET['id_ex']);
			$cli->dasabilitaClinica();
	}
	else if ($_GET['table'] == "Endereco") {
		$idExclui = addslashes($_GET['id_ex']);
		$pdo->delete($idExclui, 2);		
	}
	header('Location: ../v/consulta.php?table='.addslashes($_GET['table']));
?>