<?php
error_reporting(0);
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['UserIDid']) || !isset($_SESSION['nome']) || empty($_SESSION['UserEmail'])) {
		session_destroy();
		header("Location: index.php?error=3"); exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Consulta</title>
	<link rel="icon" type="image/x-icon" href="img/icons/favicon.ico"/>
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
	<style type="text/css">
		td{
			padding: 0px 5px;
		}
		img{
			width: 32px;
			height: 32px;
		}
		.dados{
			margin: 0;
			border: groove 2px;
			border-top: none;
			border-left: none;
			border-right: none;	
		}
		.cad{
			border-radius: 6px;
			background-color: lightblue;
		}
		.cad:hover{
			border-color: yellow;
		}
		.cad:active{
			border-color: green;
		}
	</style>
</head>
<body>
	<header id="header"></header>
	<nav id="nav" class="navbar navbar-expand-lg navbar-dark"></nav>
	<table class='container mt-5'>
		<tr class="">
			<td colspan="3" class="text-center">
				<button type="button" class="btn btn-success" onclick="window.location.href='<?php 
				//error_reporting(0);
				if (addslashes($_GET['table']) == "Clinica") {
					echo "frmCadClinica.html";
				} else if (addslashes($_GET['table']) == "Endereco") {
					echo "frmCadEndereco.php";
				} else if (addslashes($_GET['table']) == "ADM"){
					echo "frmCadAdm.php";
				} else if (addslashes($_GET['table']) == "Cliente"){
					echo "frmCadCliente.html";
				}
				?>';">Cadastrar...</button><br/><br/>
				<div style="display: block; float: left;">
					<b>Consultar Cadastro de ...</b>
				</div>
				<div style="display: block; float: left;">
					<label>Cliente</label>
					<input type="radio" name="table" onclick="window.location.href='viewConsulta.php?table=Cliente';" <?php if (addslashes($_GET['table']) == "Cliente") echo "checked";;?>/>&nbsp;
				</div>
				<div style="display: block; float: left;">
					<label>ADM</label>
					<input type="radio" name="table" onclick="window.location.href='viewConsulta.php?table=ADM';" <?php if (addslashes($_GET['table']) == "ADM") echo "checked";;?>/>&nbsp;
				</div>
				<div style="display: block; float: left;">
					<label>Endereço</label>
					<input type="radio" name="table" onclick="window.location.href='viewConsulta.php?table=Endereco';" <?php if (addslashes($_GET['table']) == "Endereco") echo "checked";;?>/>&nbsp;
				</div>
				<div style="display: block; float: left;">
					<label>Clinica</label>
					<input type="radio" name="table" onclick="window.location.href='viewConsulta.php?table=Clinica';" <?php if (addslashes($_GET['table']) == "Clinica") echo "checked";;?>/>&nbsp;
				</div>
				<br/><br/>				
			</td>
		</tr>
		<!--O laço(chamado pelo arquivo abaixo) mostra a consulta completa-->
		<?php require_once '../controller/processaCon.php';?>
	</table>	
	<footer id="footer" class="py-3"></footer>
	<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>