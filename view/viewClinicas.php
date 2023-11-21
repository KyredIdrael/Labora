<?php
    if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="img/icons/chapeu.ico">
        <script src="js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#header").load('header.html');
                $("#nav").load('nav.php');
                $("#footer").load('footer.html');
                $("#form-exame").hide();
            })
        </script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <style>
        #div-Clinica{
        border: solid black;
        }
        </style>
        <title>Clinicas</title>
    </head>
    <body>
        <header id="header"></header>
        <nav id="nav" class="navbar navbar-expand-lg navbar-dark"></nav>
        <main class="container">
            <section class="row">
                <div class="col-12 text-center">
                    Para começar o cadastro de um exame basta clicar no serviço da cliníca.
                </div>
            </section>
            <article class="row justify-content-center">
                <?php 
                    require_once '../model/clinica.php';
                    $cli = new Clinica();
                    $consulta = $cli->getClinicas();
                ?>
            </article>
            <section class="container-fluid" id="form-exame">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-auto">
                        <div class="input-group">
                            <label for="Clinica"></label>
                            <input type="text" class="form-control" name="clinica" id="Clinica" placeholder="Clinica" readonly/>
                        </div>
                        <div class="input-group">
                            <label for="Servico"></label>
                            <input type="text" class="form-control" id="Servico" placeholder="Exame" readonly/>
                        </div>
                    </div>
                </div>
            </section>
        </main>        
        <footer id="footer" class="py-3"></footer>
    </body>
</html>