<?php
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
		session_destroy();
		echo "<script>alert('Entre na sua conta ou cadastre-se!');
			window.location.href='../view/login.php'</script>";
	}
	if (isset($_POST['clinica']) && isset($_POST['exame']) &&
	isset($_POST['dataExame']) && isset($_POST['horaExame'])) {
		require_once '../model/exames.php';
		$exa = new Exame();
		$exa->idCliente = $_SESSION['id'];
		$exa->idClinica = addslashes($_POST['clinica']);
		$exa->dataHora = addslashes($_POST['dataExame'])." ".addslashes($_POST['horaExame']);
		$exa->tipoExame = addslashes($_POST['exame']);
		$exa->token = hash("sha256", base64_encode(uniqid()));
		if ($exa->cadastrarExame() == false) {
			echo "<script>window.alert('Não foi possivel cadastrar o exame.\nNão é possivel cadastrar o mesmo serviço.\nNão é possivel cadastrar mais de 3 exames.');
			window.location.href='../view/examesMarcados.php';</script>";
		} else {
			echo "<script>window.alert('Exame Marcado!');
			window.location.href='../view/examesMarcados.php';</script>";
		}
	}
?>