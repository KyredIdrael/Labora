<?php
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || !isset($_SESSION['nivelAcesso'])) {
		session_destroy();
		header("Location: public.php"); exit;
	}
	if (isset($_POST['nome']) && isset($_POST['servicos']) &&
	isset($_POST['email']) && isset($_POST['tel']) &&	
	isset($_POST['cep']) && isset($_POST['uf']) &&
	isset($_POST['cidade']) && isset($_POST['bairro']) &&
	isset($_POST['rua']) && isset($_POST['nRes'])) {

		require_once '../model/clinica.php';
        $cli = new Clinica();

        $cli->nome = addslashes($_POST['nome']);
        $cli->email = addslashes($_POST['email']);
        
		$cli->servicos = addslashes($_POST['servicos']);
		
		//tirar caracteres especiais
		require_once 'clearstr.php';
		$clean = new Cleaner();
		$cep = $clean->cleanNumbers(addslashes($_POST['cep']));
		$tel = $clean->cleanNumbers(addslashes($_POST['tel']));

		$cli->tel = $tel;
        /*Endereço */
        $cli->end = (object) array('cep' => $cep, 'uf' => addslashes($_POST['uf']), 'cidade' => addslashes($_POST['cidade']), 'bairro' => addslashes($_POST['bairro']), 'rua' => addslashes($_POST['rua']), 'idEnd' => '');
		$cli->nRes = addslashes($_POST['nRes']);
		$cli->comp = addslashes($_POST['complemento']);		
        
		
		if ($cli->verificaClinica() == true) {
			header("Location: ../view/viewConsulta.php?table=Clinica");

		} else {
			echo "<script>
	        	window.alert('Erro no cadastro, verifique se a cliníca já existe, por favor.');
	        	window.location.href='../view/viewConsulta.php?table=Clinica';
	        </script>";
		}

	} else {
        echo "<script>
        	window.alert('Preencha todos os campos');
        	window.location.href='../view/public.php';
        </script>";
	}
	exit;
?>