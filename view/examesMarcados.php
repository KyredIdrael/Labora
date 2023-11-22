<?php
//error_reporting(0);
	if (!isset($_SESSION)) session_start();
	if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
		session_destroy();
		header("Location: ../view/public.php"); exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Exames Marcados</title>
	<link rel="icon" type="image/x-icon" href="img/icons/est.ico">
	<script src="js/jquery-3.7.1.min.js"></script>
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
		<div class="row justify-content-center">
			<?php
				require_once '../model/exames.php';
				$exa = new Exame();
				$exa->idCliente = $_SESSION['id'];
				$con = $exa->consultaExames();
			?>
		</div>	
	</main>
	<footer id="footer"></footer>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript">
		/*$.ajax({
	        url: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=',
	        type: 'get',
	        //contentType: 'application/json',
	        data:{},
	        header:{},
	        //dataType: 'json',
	        success: function(data){
	            retornoJson = data;
	        }
	    }).done(function() {
	        if (retornoJson.erro) {
	            alert("CEP "+cep+" Inválido !");

	        } else {
	            document.getElementById('Rua').value = retornoJson.logradouro;
	            document.getElementById('Bairro').value = retornoJson.bairro;
	            document.getElementById('Cidade').value = retornoJson.localidade;
	            document.getElementById('Uf').value = retornoJson.uf;
	        }
	    });*/
	</script>
</body>
</html>