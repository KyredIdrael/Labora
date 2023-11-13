<?php

if (isset($_POST['nome']) && isset($_POST['servicos']) &&
isset($_POST['email']) && isset($_POST['tel']) &&	
isset($_POST['cep']) && isset($_POST['uf']) &&
isset($_POST['cidade']) && isset($_POST['bairro']) &&
isset($_POST['rua']) && isset($_POST['nRes'])) {

		require_once '../model/clinica.php';
        $cli = new Clinica();

        $cli->nome = addslashes($_POST['nome']);
        $cli->email = addslashes($_POST['email']);
        
		$servico = substr(addslashes($_POST['servicos']), 0, -1);

		$cli->servicos = $servico."}";

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
			//header("Location: ../view/viewConsulta.php?table=Clinica");
			//header("Location: ../view/viewconsulta.php?cad=1");

		} else {
			//header("Location: ../view/cadClinica.html?table=Clinica");
			//header("Location: ../view/login.php?alert=true&cad=0");
		}

	} else {
        echo "fa";//"<script>alert('Preencha todos os campos');location.href='../view/public.php';</script>";
		//header("Location: ../v/cadClinica.html");
		//header("Location: ../v/login.php?alert=true&error=1");
	}
	/*
		Teste de variaveis
	
	echo "<pre>";
	print_r($cli->nome);
	echo "</pre><pre>";
	print_r($cli->rg);
	echo "</pre><pre>";
	print_r($cli->cpf);
	echo "</pre><pre>";
	print_r($cli->dataNasc);
	echo "</pre><pre>";
	print_r($cli->genero);
	echo "</pre><pre>";
	print_r($cli->tel);
	echo "</pre><pre>";
	print_r($cli->cel);
	echo "</pre><pre>";
	print_r($cli->end);
	echo "</pre><pre>";
	print_r($cli->nRes);
	echo "</pre><pre>";
	print_r($cli->comp);
	echo "</pre><pre>";
	print_r($cli->pergSec);
	echo "</pre><pre>";
	print_r($cli->respSec);
	echo "</pre><pre>";
	print_r($cli->preferencial);
	echo "</pre><pre>";
	print_r($cli->dependente);
	echo "</pre><pre>";
	echo "</pre>";

	var_dump($cli->nome);
	var_dump($cli->rg);
	var_dump($cli->cpf);
	var_dump($cli->dataNasc);
	var_dump($cli->genero);
	var_dump($cli->tel);
	var_dump($cli->cel);
	var_dump($cli->end);
	var_dump($cli->nRes);
	var_dump($cli->comp);
	var_dump($cli->pergSec);
	var_dump($cli->respSec);
	var_dump($cli->preferencial);
	var_dump($cli->dependente);
	*/
	
	exit;
?>