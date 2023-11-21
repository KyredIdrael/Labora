<?php
//error_reporting(0);
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
		session_destroy();
		header("Location: public.php"); exit;
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dados Pessoais</title>
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
	<nav id="nav"></nav>
	<div class="container"></div>
	<?php require_once '../controller/meusDados.php'; ?>
	<footer id="footer"></footer>
</body>
</html>