<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <style>
        #div-Clinica{
        border: solid black;
        }
        </style>
        <title>Document</title>
    </head>
    <body>
        <header id="header"></header>
        <nav id="nav" class="navbar navbar-expand-lg navbar-dark"></nav>
        <main class="container">
            <div class="row">
                <div class="col-12 text-center">
                    Para começar o cadastro de um exame basta clicar no serviço da cliníca.
                </div>
            </div>
            <div class="row justify-content-center">
                <?php require_once '../controller/processaConClinicas.php';?>
            </div>            
        </main>
        <footer id="footer" class="py-3"></footer>
    </body>
</html>