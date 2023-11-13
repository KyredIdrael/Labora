<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>
		<link rel="icon" type="image/x-icon" href="img/icons/chapeu.ico">
		<script src="js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				$("#header").load('header.php');
				$("#nav").load('nav.php');
				$("#footer").load('footer.php');
			})
		</script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body style="background-color: #0A395B;" class="bg-gradient">
		<header id="header"></header>
		<main>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-6 card bg-white shadow bg-opacity-75 py-5 my-4">
						<form method="POST" action="../controller/validaLogin.php">
							
							<h2 class="text-center mb-4">Acessar Conta <strong>Labora</strong></h2>

							<label for="Email" class="form-label">E-mail</label>
							<input type="email" name="email" id="Email" class="form-control mb-5" maxlength="40" required/>
							
							<label for="Senha" class="form-label">Password</label>
							<div class="input-group input-group-sm">
								<input type="password" name="senha" id="Senha" class="form-control" maxlength="32" required/>
								<div class="input-group-text">
									<button type="button" id="msSenha" class="btn" onclick="shSenha()">Mostrar Senha</button>
								</div>								
							</div>

							<div class="col-4">
								<label for="Usuario" class="form-label mt-4">Usuario</label>
								<select name="usuario" id="Usuario" class="form-select col-1">
									<option value="Cliente" selected>Cliente</option>
									<option value="Funcionario">Funcionario</option>
								</select>
							</div>							
							<div class="mt-5">
								<a href="frmCadCliente.html" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 mt-5"><b>Criar Conta</b></a>
							<button type="submit" id="btnEnviar" class="btn btn-primary float-end px-5 py-2">Entrar</button>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</main>
		<footer id="footer" class="py-3 bg-white"></footer>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript">
			function shSenha() {
				senha = document.querySelector('#Senha');
				if (senha.type == "text"){
					senha.type = "password"
					document.getElementById('msSenha').innerHTML = "Mostrar Senha"
				}
				else{
					senha.type = "text"
					document.getElementById('msSenha').innerHTML = "Esconder Senha"
				}
			}
		</script>
	</body>
</html>