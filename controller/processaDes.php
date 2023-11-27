<?php
	if (empty($_SESSION)) session_start();

	if (empty($_SESSION['id']) || empty($_SESSION['email']) || empty($_SESSION['nivelAcesso'])) {
		session_destroy();
		header("Location: ../view/public.php");
		exit;
	}
	if (isset($_GET) && isset($_GET['id_ex']) && isset($_GET['table'])) {
		if ($_GET['table'] == "Clinica") {
			require_once '../model/Clinica.php';
			$cli = new Clinica();		
			$cli->id = addslashes($_GET['id_ex']);
			$cli->dasabilitaClinica();

		} else if ($_GET['table'] == "Endereco") {
			require_once '../model/Clinica.php';
			$end = new Endereco();
			$end->id = addslashes($_GET['id_ex']);
			$end->dasbilitaEndereco();

		} else if ($_GET['table'] == "Funcionario") {
			require_once '../model/func.php';
			$func = new Funcionario();
			$func->id = addslashes($_GET['id_ex']);
			$func->desabilitaFuncionario();		
		}
	} else {
		echo "<script>
	        	window.alert('Falha na aplicação');
	        	window.location.href='../view/viewConsulta.php?table=Clinica';
	        </script>";
	}
	
	header('Location: ../view/viewconsulta.php?table='.addslashes($_GET['table']));
?>