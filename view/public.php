<?php 
	if (!isset($_SESSION)) session_start(); 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Home</title>
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
	<body>
		<header id="header"></header>
		<nav id="nav" class="navbar navbar-expand-lg navbar-dark"></nav>
		
					<?php 
						if (empty($_SESSION['id']) && empty($_SESSION['email'])) {
							echo '
							<main id="main" class="container">
								<div class="row justify-content-center">
									<div class="col-5">
								<p class="mt-5">O AgendME é um serviço de agendamento Exames Médicos.</p>
								<ul>
									<li>Exames de Rotina</li>
									<li>Cardiologia</li>
									<li>Ginecologia e Obstetrícia</li>
									<li>Psiquiatria</li>
									<li>Dentre outros</li>
								</ul>
								<p class="txt-center">Ache a clinica mais proxima de você!!!</p>
								<p>Ainda não tem uma conta <b><a href="frmCadCliente.html" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Cadastre-se Aqui</a></b></p>
									</div>
								</div>			
							</main>';
							
						} else if (isset($_SESSION['id']) && isset($_SESSION['email']) && empty($_SESSION['nivelAcesso'])) {
							echo '
								<nav class="container">
									<div class="row justify-content-center">
										<button type="button" class="btnNav col-sm-12 col-md-auto" onclick="window.location.href=public.php">Dados Pessoais</button>
										<button type="button" class="btnNav col-sm-12 col-md-auto">Exames Marcados</button>
									</div>										
								</nav>';

						} else if (isset($_SESSION['id']) && isset($_SESSION['email']) && isset($_SESSION['nivelAcesso'])) {
							echo '
							<nav class="container">
								<div class="row justify-content-center">
									<button type="button" class="btnNav col-sm-12 col-md-auto" onclick="window.location.href=public.php">Dados Pessoais</button>
									<div class="nav-item dropdown col-sm-12 col-md-auto">
										<button type="button" class="btnNav dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Cadastra</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="frmCadClinica.html">Clinica</a></li>
											<li><a class="dropdown-item" href="frmCadFunc.html">Funcionarios</a></li>
										</ul>
									</div>
									<div class="nav-item dropdown col-sm-12 col-md-auto">
										<button type="button" class="btnNav dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Consulta</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="viewConsulta.php?table=Clinica">Clinicas</a></li>
											<li><a class="dropdown-item" href="viewConsulta.php?table=Endereco">Endereços</a></li>
											<li><a class="dropdown-item" href="viewConsulta.php?table=Funcionario">Funcionarios</a></li>
											<li><a class="dropdown-item" href="viewConsulta.php?table=Cliente">Clientes</a></li>
										</ul>
									</div>
								</div>								
							</nav>';
						}
					?>					
		<footer id="footer" class="py-3"></footer>
		<script src="js/bootstrap.bundle.min.js"></script>
	</body>
</html>