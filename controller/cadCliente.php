<?php
	if (isset($_POST['nome']) && isset($_POST['email']) &&
		isset($_POST['senha']) && isset($_POST['rg']) &&
		isset($_POST['cpf']) && isset($_POST['dataNasc']) &&
		isset($_POST['genero']) && isset($_POST['cel']) &&
		isset($_POST['cep']) && isset($_POST['uf']) &&
		isset($_POST['cidade']) && isset($_POST['bairro']) &&
		isset($_POST['rua']) && isset($_POST['nRes'])) {

		require_once '../model/cliente.php';
		$cli = new Cliente();

		$cli->nome = addslashes($_POST['nome']);
		$cli->email = addslashes($_POST['email']);
		$cli->senha = hash("sha256", addslashes($_POST['senha']));
		$cli->rg = addslashes($_POST['rg']);		
		$cli->dataNasc = addslashes($_POST['dataNasc']);
		$cli->genero = addslashes($_POST['genero']);

		//Tirar pontos e traços
		require_once 'clearstr.php';
		$str = new Cleaner();
		$cep = $str->cleanNumbers(addslashes($_POST['cep']));
		$cli->tel = $str->cleanNumbers(addslashes($_POST['tel']));
		$cli->cel = $str->cleanNumbers(addslashes($_POST['cel']));
		$cli->cpf =  $str->cleanNumbers(addslashes($_POST['cpf']));

		// A variavel end na classe Cliente recebe um objeto(por conversão do array).	
		$cli->end = (object) array('cep' => $cep, 'uf' => addslashes($_POST['uf']), 'cidade' => addslashes($_POST['cidade']), 'bairro' => addslashes($_POST['bairro']), 'rua' => addslashes($_POST['rua']), 'idEnd' => "");
		$cli->nRes = addslashes($_POST['nRes']);
		$cli->comp = addslashes($_POST['complemento']);

		if ($cli->verificarUsuario() == true) {
			header("Location: ../view/login.php");

		} else {
			echo "<script>window.alert('Cadastro Invalido!!');</script>";
			header("Location: ../view/frmCadCliente.html");
		}

	} else {
		echo "<script>window.alert('Preencha todos os campos!!!');</script>";
		header("Location: ../view/public.php");
	}
	exit;
?>