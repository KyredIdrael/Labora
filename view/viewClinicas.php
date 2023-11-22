<?php
    if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clinicas</title>
        <link rel="icon" type="image/x-icon" href="img/icons/est.ico">
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
        #form-exame{
            display: block;
            box-sizing: border-box;
            position: fixed;
            width: 100%;
            height: 100%;          
            top: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, .2);
            border-radius: 8px;
            box-shadow: 0px 5px 15px -5px black;
        }
        #form{
            margin: 10%;
        }
        </style>        
    </head>
    <body>
        <header id="header"></header>
        <nav id="nav" class="navbar navbar-expand-lg navbar-dark"></nav>
        <main class="container" id="conteudo">
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
            <section>
                <div class="container-fluid" id="form-exame">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-md-auto card p-5" id="form">
                            <form method="POST" action="../controller/cadExame.php">
                                <label for="Clinica" class="form-label">Clinica</label>
                                <input type="text" class="form-control" id="Clinica" placeholder="Clinica" required readonly/>
                                <input type="hidden" name="clinica" id="idClinica" required/>

                                <label for="Servico" class="form-label">Exame</label>
                                <input type="text" name="exame" class="form-control" id="Servico" placeholder="Exame" required readonly/>

                                <label class="form-label">Data do exame</label>
                                <input type="date" name="dataExame" class="form-control" required/>

                                <label class="form-label">Hora</label>
                                <select name="horaExame" class="form-control">
                                    <option value="07:00">07:00</option>
                                    <option value="07:30">07:30</option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:30">08:30</option>
                                    <option value="09:00">09:00</option>
                                    <option value="09:30">09:30</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="14:00">14:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="15:00">15:00</option>
                                    <option value="15:30">15:30</option>
                                    <option value="16:00">16:00</option>
                                    <option value="16:30">16:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="17:30">17:30</option>
                                    <option value="18:00">18:00</option>
                                    <option value="18:30">18:30</option>
                                </select>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-danger" id="cancelarExame">Cancelar</button>
                                    <input type="submit" class="btn btn-primary" value="Marcar Exame">
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </section>            
        </main>
        <footer id="footer" class="py-3"></footer>
        <script type="text/javascript">
            $(".servicos").click(function () {
                let id = parseInt(Number(this.id));
                let str = document.getElementById("c"+id);
                $("#form-exame").show();
                $("#Clinica").val(str.textContent);
                $("#Servico").val(this.text);
                $("#idClinica").val(id);
            });
            $("#cancelarExame").click(function () {
                $("#form-exame").hide();
            })           
        </script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>