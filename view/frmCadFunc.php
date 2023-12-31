<?php
error_reporting(0);
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || empty($_SESSION['nivelAcesso'])) {
		session_destroy();
		header("Location: public.php");
	}
	$e = addslashes($_GET['error']);
	if ($e == true) {
		echo "<script>window.alert('Cadastro Invalido!!');</script>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cadastro</title>
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<script src="js/jquery-3.7.1.min.js"></script>
		<script src="js/jquerymask.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				$("#header").load('header.html');
				$("#nav").load('nav.php');
				$("#footer").load('footer.html');
			})
		</script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body style="background-color: #103331;">
	<header id="header"></header>
	<main id="main">
		<form method="POST" action="../controller/cadFuncionario.php">
			<div class="container card mt-3 pb-4">
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<br/><h2>Dados Pessoais</h2><br/>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12 mb-5">
						<label for="Nome" class="form-label">Nome Completo</label>
						<input type="text" name="nome" id="Nome" class="form-control" placeholder="Nome Completo" required/>
						
						<label for="Rg" class="form-label">RG</label>
						<input type="text" name="rg" id="Rg" class="form-control" placeholder="RG" maxlength="10" required/>

						<label for="Cpf" class="form-label">CPF</label>
						<input type="text" name="cpf" id="Cpf" class="form-control" placeholder="___.___.___.-__" required/>
					

						<label for="DataNasc" class="form-label">Data de Nascimento</label>
						<input type="date" name="dataNasc" id="DataNasc" class="form-control" required/>
						
						<label for="Genero" class="form-label">Gênero</label>
						<select name="genero" id="Genero" class="form-select">
							<option selected>Selecione o gênero</option>
							<option value="M">Masculino</option>
							<option value="F">Feminino</option>
						</select>

                        <label for="EstadoCivil" class="form-label">Estado Civil</label>
						<select name="estadocivil" id="EstadoCivil" class="form-select">
							<option selected>Selecione o Estado Civil</option>
							<option value="solteiro">Solteiro</option>
							<option value="casado">Casado</option>
                            <option value="noivo">Noivo</option>
                            <option value="viúvo">Viúvo</option>
                            <option value="uniao">União Estavel</option>
						</select>
						<label for="Tel" class="form-label">Telefone</label>
						<input type="phone" name="tel" id="Tel" class="form-control" placeholder="(__) ____-____" autocomplete="true" required/>
						
						<label for="Cel" class="form-label">Celular</label>
						<input type="phone" name="cel" id="Cel" class="form-control" placeholder="(__) _____-____" autocomplete="true" required/>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
						<h2>Dados de Usuario</h2>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12">
						
						<label for="Email" class="form-label">Email</label>
						<input type="email" name="email" id="Email" class="form-control" placeholder="Email" autocomplete="true" maxlength="50" required/>
						<label for="Senha" class="form-label">Senha</label>
						<div class="input-group mb-5">
							<input type="password" name="senha" id="Senha" class="form-control" placeholder="Senha" autocomplete="true" minlength="8" required/>
							<div class="input-group-text">
								<button class="btn mt-0" type="button" id="ms">Mostrar Senha</button>
							</div>
						</div>	
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
						<h2>Endereço</h2>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12">
						
						<label for="Cep" class="form-label" on>CEP</label>
						<input type="text" name="cep" id="Cep" class="form-control" maxlength="9" onblur="buscaCep()" placeholder="_____-___" required/>
						
						<label for="Uf" class="form-label">UF</label>
						<select class="form-select" id="Uf" name="uf" required readonly>
							<option value="" selected></option>
							<option value="AC">AC</option>
							<option value="AL">AL</option>
							<option value="AP">AP</option>
							<option value="AM">AM</option>
							<option value="BA">BA</option>
							<option value="CE">CE</option>
							<option value="DF">DF</option>
							<option value="ES">ES</option>
							<option value="GO">GO</option>
							<option value="MA">MA</option>
							<option value="MT">MT</option>
							<option value="MS">MS</option>
							<option value="MG">MG</option>
							<option value="PA">PA</option>
							<option value="PB">PB</option>
							<option value="PR">PR</option>
							<option value="PE">PE</option>
							<option value="PI">PI</option>
							<option value="RJ">RJ</option>
							<option value="RN">RN</option>
							<option value="RS">RS</option>
							<option value="RO">RO</option>
							<option value="RR">RR</option>
							<option value="SC">SC</option>
							<option value="SP">SP</option>
							<option value="SE">SE</option>
							<option value="TO">TO</option>
						</select>
						
						<label for="Cidade" class="form-label">Cidade</label>
						<input type="text" name="cidade" id="Cidade" class="form-control" placeholder="Cidade" required readonly/>

						<label for="Bairro" class="form-label">Bairro</label>
						<input type="text" name="bairro" id="Bairro" class="form-control" placeholder="Bairro" required readonly/>

						<label for="Rua" class="form-label">Rua</label>
						<input type="text" name="rua" id="Rua" class="form-control" placeholder="Rua" required readonly/>

						<label for="nRes" class="form-label">Nº da Residência</label>
						<input type="number" name="nRes" id="nRes" class="form-control" placeholder="Nº da Residência" required/>

						<label for="Comp" class="form-label">Complemento</label>
						<textarea name="complemento" id="Comp" class="form-control" maxlength="500" rows="3" placeholder="Complemento"></textarea><br/>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-6 col-sm-12 pb-3">
						<button type="button" class="btn btn-danger px-5 py-2" onclick="window.location.href='public.php'">Cancelar</button>
						<input type="submit" value="Cadastrar" class="btn btn-primary float-end px-5 py-2"/>
					</div>
				</div>
			</div>
		</form>
	</main>
	<footer id="footer" class="py-3 bg-white"></footer>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript">
		const tipo = document.getElementById('Senha');
		$("#ms").click(function(e){
			
			if (tipo.type == "text") {
				tipo.type = "password";
				$(this).text("Mostrar Senha");

			} else {
				tipo.type = "text";
				$(this).text("Esconder Senha");
			}
		});
	</script>
	<script src="js/buscaCEP.js"></script>
	</body>
</html>