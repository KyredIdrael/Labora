<?php
    if (!isset($_SESSION)) session_start();
    if (!isset($_SESSION['id']) || !isset($_SESSION['email']) || empty($_SESSION['nivelAcesso'])) {
        session_destroy();
        header("Location: public.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastra Clinicas</title>
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
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card container-fluid mt-3 pb-4">
                    <form method="POST" action="../controller/cadClinica.php">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <h2 class="my-3">Dados da Cliníca</h2><br />
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                
                                    <label for="Nome" class="form-label">Nome*</label>
                                    <input type="text" name="nome" id="Nome" class="form-control" placeholder="Nome"
                                        autocomplete="true" />

                                    <label for="Email" class="form-label">E-mail*</label>   
                                    <input type="text" name="email" class="form-control" placeholder="E-mail"> 

                                    <label for="Tel" class="form-label">Telefone*</label>
                                    <input type="text" name="tel" id="Tel" class="form-control" placeholder="(__) ____-____" required/>

                                    <label for="servico" class="form-label">Serviço*</label>
                                    <input type="text" id="servico" class="form-control" placeholder="Serviço"
                                        autocomplete="true" />
                                    <button type="button" class="form-control btn btn-secondary my-1" onclick="adicionarServico()">Adicionar Serviço</button>
                                    <button type="button" class="form-control btn btn-danger" onclick="removerServico()">Remover Serviço</button>

                                    <label for="servicos" class="form-label">Lista de Serviços associados</label>
                                    <textarea id="servicos" class="form-control" placeholder="Serviços Associados" readonly></textarea>

                                    <input type="hidden" name="servicos" id="strJson"/>                
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <br /><br />
                                    <h2>Endereço</h2><br />
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                
                                    <label for="Cep" class="form-label" on>CEP*</label>
                                    <input type="text" name="cep" id="Cep" class="form-control" onblur="buscaCep()" maxlength="8" placeholder="_____-___" required />
                
                                    <label for="Uf" class="form-label">UF*</label>
                                    <select class="form-select" id="Uf" name="uf" required>
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
                                    <label for="Cidade" class="form-label">Cidade*</label>
                                    <input type="text" name="cidade" id="Cidade" class="form-control" placeholder="Cidade" required />
                
                                    <label for="Bairro" class="form-label">Bairro*</label>
                                    <input type="text" name="bairro" id="Bairro" class="form-control" placeholder="Bairro" required />
                
                                    <label for="Rua" class="form-label">Rua*</label>
                                    <input type="text" name="rua" id="Rua" class="form-control" placeholder="Rua" required />
                
                                    <label for="nRes" class="form-label">Nº da Residência*</label>
                                    <input type="number" name="nRes" id="nRes" class="form-control" placeholder="Nº da Residência"
                                        required />
                
                                    <label for="Comp" class="form-label">Complemento</label>
                                    <textarea name="complemento" id="Comp" class="form-control mb-2" maxlength="500" rows="3"
                                        placeholder="Complemento"></textarea>              
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button type="button" class="btn btn-danger px-4 py-2" onclick="window.location.href='public.php'">Cancelar</button>
                                    <input type="submit" value="Cadastrar"
                                        class="btn btn-primary px-5 py-2 float-end" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer id="footer" class="py-3 bg-white"></footer>
    <script>
        const servico = document.getElementById('servico');
        const servicos = document.getElementById('servicos');
        const strJson = document.getElementById('strJson');
        let jsonString, array = [];

        function adicionarServico() {            
            array.push(servico.value);
            jsonString = JSON.stringify(array);
            strJson.value = jsonString;
            servicos.value = array.join(', ');
            servico.value = '';
            console.log(strJson.value);
        }

        function removerServico() {
            array.pop();
            jsonString = JSON.stringify(array);
            strJson.value = jsonString;
            servicos.value = array.join(', ');
            console.log(strJson.value);
        }
    </script>
    <script src="js/buscaCEP.js"></script>
</body>

</html>