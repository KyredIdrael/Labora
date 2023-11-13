<?php
	if (empty(addslashes($_POST['usuario'])) || empty(addslashes($_POST['email'])) || empty(addslashes($_POST['senha']))) {
		echo "<script>window.alert('Preencha todos os dados!!!');
			window.location.href='../view/login.php';</script>";
			
	} else {
		if (addslashes($_POST['usuario']) == "Cliente") {
			require_once '../model/cliente.php';
			$cli = new Cliente();
			$cli->email = addslashes($_POST['email']);
			$cli->senha = hash("sha256", addslashes($_POST['senha']));
			if ($cli->validarLogin() == true) {
				header("Location: ../view/public.php");

			} else {
				echo "<script>window.alert('E-mail ou Senha Invalidos!!!');
				window.location.href='../view/login.php';</script>";
			}

		} else if (addslashes($_POST['usuario']) == "Funcionario") {
			require_once '../model/func.php';
			$func = new Funcionario();
			$func->email = addslashes($_POST['email']);
			$func->senha = hash("sha256", addslashes($_POST['senha']));
			
			if ($func->validarLogin() == true) {
				header("Location: ../view/public.php");

			} else {
				echo "<script>window.alert('E-mail ou Senha Invalidos!!!');
				window.location.href='../view/login.php';</script>";
			}

		} else {
			echo "<script>window.alert('Usuario Invalido!!!');
			window.location.href='../view/login.php';</script>";
		}		
	}
?>