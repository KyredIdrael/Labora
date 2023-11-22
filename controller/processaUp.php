<?php
	if (empty($_SESSION)) session_start();

	if (empty($_SESSION['id']) || empty($_SESSION['email'])) {
		session_destroy();
		header("Location: ../view/public.php");
	}

	if (isset($_GET['table']) && $_GET['table'] == "Cliente" && empty($_SESSION['nivelAcesso'])
		&& ($_POST['idUser'] == $_SESSION['id'])) {

		if (isset($_POST) && isset($_POST['nome'])
			&& isset($_POST['dataNasc']) && isset($_POST['genero'])
			&& isset($_POST['email']) && isset($_POST['senha'])
			&& isset($_POST['tel']) && isset($_POST['cel']) && isset($_POST['nRes'])
			&& isset($_POST['idUser'])) {
			require_once '../model/cliente.php';
			$cli = new Cliente();

			$cli->id = addslashes($_POST['id']);
			$cli->nome = addslashes($_POST['nome']);

			//Formatando data para o banco de dados
			$nasc = str_replace("/", "-", addslashes($_POST['dataNasc']));
	        $cli->dataNasc = date('Y-m-d', strtotime($nasc));

	        $cli->genero = addslashes($_POST['genero']);
			$cli->email = addslashes($_POST['email']);
			$cli->senha = addslashes($_POST['senha']);
	        $cli->nRes = addslashes($_POST['nRes']);
	        $cli->comp = addslashes($_POST['complemento']);

			//Tirar pontos e traços
			require_once 'clearstr.php';
			$str = new Cleaner();
			$cep = $str->cleanNumbers(addslashes($_POST['cep']));
			$cli->tel = $str->cleanNumbers(addslashes($_POST['tel']));
			$cli->cel = $str->cleanNumbers(addslashes($_POST['cel']));

			//Array pra facilitar e exercitar
			$cli->end = (object) array('nome' => $nome, 'dataNasc' => addslashes($_POST['dataN']), 'genero' => addslashes($_POST['genero']),
				'telefone' => addslashes($_POST['telefone']), 'celular' => addslashes($_POST['celular']),
				'email' => addslashes($_POST['email']), 'senha' => addslashes($_POST['senha']) , 'nResidencial' => addslashes($_POST['nResidencial']) , 'complemento' => addslashes($_POST['complemento']));
			if ($cli->alteraUsuario() == true) {
				header("Location: ../view/dadosPessoais.php");
			} else {
				header("Location: ../view/error.php");
			}
		}

    } else if (isset($_GET['table']) && $_GET['table'] == "Cliente" && isset($_SESSION['nivelAcesso'])) {

		if (isset($_POST['id']) && isset($_POST['nome'])
			&& isset($_POST['rg']) && isset($_POST['cpf'])
			&& isset($_POST['dataNasc']) && isset($_POST['genero'])
			&& isset($_POST['email']) && isset($_POST['senha'])
			&& isset($_POST['tel']) && isset($_POST['cel'])
			&& isset($_POST['cep']) && isset($_POST['uf'])
			&& isset($_POST['cidade']) && isset($_POST['bairro'])
			&& isset($_POST['rua']) && isset($_POST['nRes'])) {
			require_once '../model/cliente.php';
			$cli = new Cliente();
			$cli->id = addslashes($_POST['id']);
			$cli->nome = addslashes($_POST['nome']);
			$cli->rg = addslashes($_POST['rg']);
			$cli->cpf = addslashes($_POST['cpf']);

			//Formatando data para o banco de dados
			$nasc = str_replace("/", "-", addslashes($_POST['dataNasc']));
	        $cli->dataNasc = date('Y-m-d', strtotime($nasc));
	        $cli->genero = addslashes($_POST['genero']);
			$cli->email = addslashes($_POST['email']);
			$cli->senha = hash('sha256', addslashes($_POST['senha']));
	        $cli->nRes = addslashes($_POST['nRes']);
	        $cli->comp = addslashes($_POST['complemento']);

			//Tirar pontos e traços
			require_once 'clearstr.php';
			$str = new Cleaner();
			$cep = $str->cleanNumbers(addslashes($_POST['cep']));
			$cli->tel = $str->cleanNumbers(addslashes($_POST['tel']));
			$cli->cel = $str->cleanNumbers(addslashes($_POST['cel']));
			$cli->cpf =  $str->cleanNumbers(addslashes($_POST['cpf']));

			$cli->end = (object) array('cep' => $cep, 'uf' => addslashes($_POST['uf']), 'cidade' => addslashes($_POST['cidade']), 'bairro' => addslashes($_POST['bairro']), 'rua' => addslashes($_POST['rua']), 'idEnd' => '');
			if ($cli->alteraCliente() == true) {
				header("Location: ../view/dadosPessoais.php");
			} else {
				header("Location: ../view/error.php");
			}
		}
	}else {
		header("Location: ../view/public.php");
	}
?>