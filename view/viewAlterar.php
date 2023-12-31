<?php
//error_reporting(0);
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || empty($_SESSION['nivelAcesso'])) {
		session_destroy();
		header("Location: public.php"); exit;
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Alterar</title>
		<link rel="icon" type="image/x-icon" href="img/icons/cajado.ico">		
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
	<body>
		<header id="header"></header>
		<nav id="nav" class="navbar navbar-expand-lg navbar-dark"></nav>
		<main class="container">
			<form method="POST" action="../controller/processaUp.php?table=<?php echo addslashes($_GET['table']);?>">
				<?php require_once '../controller/GetForUp.php';?>
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-6">
						<button type="button" class="btn btn-danger px-4" onclick="window.location.href='http://localhost/labora/v/viewConsulta.php';">Cancelar</button>
						<input type="submit" value="Alterar" class="btn btn-primary px-4 float-end">
					</div>
				</div>				
			</form>
		</main>
		<footer id="footer" class="py-3"></footer>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/buscaCEP.js"></script>
	</body>
</html>