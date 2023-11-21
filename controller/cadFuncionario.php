<?php
	if (isset($_POST['nome']) && isset($_POST['email']) &&
		isset($_POST['senha']) && isset($_POST['rg']) &&
		isset($_POST['cpf']) && isset($_POST['dataNasc']) &&
		isset($_POST['genero']) && isset($_POST['cel']) &&
		isset($_POST['cep']) && isset($_POST['uf']) &&
		isset($_POST['cidade']) && isset($_POST['bairro']) &&
        isset($_POST['estadocivil']) && isset($_POST['tel']) &&
		isset($_POST['rua']) && isset($_POST['nRes'])) {

		require_once '../model/func.php';
		$func = new Funcionario();

		$func->nome = addslashes($_POST['nome']);
		$func->email = addslashes($_POST['email']);
		$func->senha = hash("sha256", addslashes($_POST['senha']));
		$func->rg = addslashes($_POST['rg']);
		$func->estadoCiv = addslashes($_POST['estadocivil']);
		$func->dataNasc = addslashes($_POST['dataNasc']);
		$func->genero = addslashes($_POST['genero']);

		//Tirar pontos e traços
		require_once 'clearstr.php';
		$str = new Cleaner();
		$cep = $str->cleanNumbers(addslashes($_POST['cep']));
		$func->tel = $str->cleanNumbers(addslashes($_POST['tel']));
		$func->cel = $str->cleanNumbers(addslashes($_POST['cel']));
		$func->cpf =  $str->cleanNumbers(addslashes($_POST['cpf']));

		// A variavel end na classe Cliente recebe um objeto(por conversão do array).	
		$func->end = (object) array('cep' => $cep, 'uf' => addslashes($_POST['uf']), 'cidade' => addslashes($_POST['cidade']), 'bairro' => addslashes($_POST['bairro']), 'rua' => addslashes($_POST['rua']), 'idEnd' => "");
		$func->nRes = addslashes($_POST['nRes']);
		$func->comp = addslashes($_POST['complemento']);

		if ($func->verificaFuncionario() == true) {
			header("Location: ../view/login.php");

		} else {			
			header("Location: ../view/frmCadFunc.php?error=true");
		}

	} else {		
		header("Location: ../view/public.php");
	}
	exit;
?>