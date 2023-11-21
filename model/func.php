<?php
    /*
	 * 
	 * REGRAS DE PROGAMAÇÃO PARA O SISTEMA
	 *
	 * 1. camelCase para variaveis e funções.
	 * 1.1. Ex: function validaEmail(), $numRes.  
	 * 2. PascalCase para Classes.
	 * 2.1. Ex: class Usuario.
	 * 3. SCREAMING_SNAKE_CASE para constantes.
	 * 3.1. Ex: $IP_LOCAL, $_VAR_, nunca começar com 2 underline
	 * 4. Variavel padrão de chamada da prepare = $cmd.
	 * 5. Ex: $cmd = $this->pdo->prepare().
	 * 5. Comentarios somente de multiplas linhas. 
	 * 6. Não usar abreviações em nome de função como (cadFunc), fazer como no exemplo 6.1  
	 * 6.1. Ex: cadastraFuncionario(), (eu sei q e(acento) chato mas temos q fazer coisas q as vezez ñ nos convem)
	 *  
	 */
    class Funcionario {

        private $pdo;
        private $id;
        private $nome;
        private $rg;
        private $cpf;
        private $dataNasc;
        private $genero;
        private $estadoCiv;
        private $email;
        private $senha;
        private $tel;
        private $cel;
        private $end;
        private $nRes;
        private $comp;
        private $nivelAcesso;
        private $status;

        function __construct()
        {
            require_once 'conexao.php';		
            $con = new Conexao();
            $this->pdo = $con->conectar("bdlabora","localhost","root","");
        }
        function __set($atributo, $value)
        {
            $this->$atributo = $value;
        }
        function __get($atributo)
        {
            return $this->$atributo;
        }

        // - é private, + é public e # é protected 


        public function verificaFuncionario() {
            $sql = "SELECT email, id, status FROM Funcionario WHERE email = :email OR cpf = :cpf";
            $cmd = $this->pdo->prepare($sql);
            $cmd->bindValue(":email", $this->email);
            $cmd->bindValue(":cpf", $this->cpf);
            $cmd->execute();
            $cmd->fetch(PDO::FETCH_ASSOC);

            require_once '../model/endereco.php';
            $end = new Endereco();

            $end->cep = $this->end->cep;
            $end->uf = $this->end->uf;
            $end->cidade = $this->end->cidade;
            $end->bairro = $this->end->bairro;
            $end->rua = $this->end->bairro;

            $end->cadastrarEndereco();
            $end->getIdEnd();

            $this->end->idEnd = $end->id;

            if ($cmd->rowCount() > 0) {
                return false;

            } else {
                return $this->cadastraFuncionario();
            }            
        }

        protected function cadastraFuncionario()    
        {
            /*
                status é campo em bit
                1 = ativo
                0 = inativo
            */
            $status = 1;
            $nivelAcesso = 1;
            $sql = "INSERT INTO Funcionario(nome, rg, cpf, email, senha, dataNasc, genero, estadoCivil, telefone, celular, nResidencial, 
            idEnd, complemento, status, nivelAcesso) VALUES(:nome ,:rg, :cpf, :email, :senha, :dataNasc, :gen, :estadoCiv, :tel,
             :cel, :nRes, :id, :comp, :st, :nA)";
            $cmd = $this->pdo->prepare($sql);
            $cmd->bindValue(":nome", $this->nome);
            $cmd->bindValue(":rg", $this->rg);
            $cmd->bindValue(":cpf", $this->cpf);
            $cmd->bindValue(":email", $this->email);
            $cmd->bindValue(":senha", $this->senha);
            $cmd->bindValue(":dataNasc", $this->dataNasc);
            $cmd->bindValue(":gen", $this->genero);
            $cmd->bindValue(":estadoCiv", $this->estadoCiv);
            $cmd->bindValue(":tel", $this->tel);
            $cmd->bindValue(":cel", $this->cel);
            $cmd->bindValue(":nRes", $this->nRes);
            $cmd->bindValue(":id", $this->end->idEnd);
            $cmd->bindValue(":comp", $this->comp);
            $cmd->bindParam(':st', $status, PDO::PARAM_INT, 1);
            $cmd->bindValue(":nA", $nivelAcesso);
            $cmd->execute();

            if ($cmd == true || $cmd == 1) {
                return true;

            } else {
                return false;
            }
        }

        public function alteraFuncionario(){
            $cmd= $this->pdo->prepare("update Funcionario SET nome = :nome, rg = :rg, cpf = :cpf, email = :email, senha = :senha, dataNasc = :dataNasc, genero = :gen, telefone = :tel, celular = :cel, idEnd = :id, nResidencial = :nRes, complemento = :comp");

            $cmd->bindValue(":nome", $this->nome);
            $cmd->bindValue(":rg", $this->rg);
            $cmd->bindValue(":cpf", $this->cpf);
            $cmd->bindValue(":email", $this->email);
            $cmd->bindValue(":senha", $this->senha);
            $cmd->bindValue(":dataNasc", $this->dataNasc);
            $cmd->bindValue(":gen", $this->genero);
            $cmd->bindValue(":estadoCivil", $this->estadoCiv);
            $cmd->bindValue(":tel", $this->tel);
            $cmd->bindValue(":cel", $this->cel);
            $cmd->bindValue(":nRes", $this->nRes);
            $cmd->bindValue(":id", $this->idEnd);
            $cmd->bindValue(":comp", $this->complemento);
            $cmd->execute();
            if ($cmd == true || $cmd == 1) {
                return true;

            } else {
                return false;
            }
        }
        public function selectAll()
        {
            $cmd = $this->pdo->query("SELECT * FROM Funcionario WHERE status = 1");
            $con = $cmd->fetchAll(PDO::FETCH_ASSOC);
            if (count($con) > 0) {
                for ($i = 0; $i < count($con); $i++) {
                    $date = $date=date_create($con[$i]['dataNasc']);
                    echo "<tr>
                            <td>
                                <p class='dados'>Nome: ".$con[$i]['nome']."</p>
                                <p class='dados'>RG: ".$con[$i]['rg']."</p>
                                <p class='dados'>CPF: ".$con[$i]['cpf']."</p>
                                <p class='dados'>E-mail: ".$con[$i]['email']."</p>
                                <p class='dados'>Celular: ".$con[$i]['celular']."</p>
                                <p class='dados'>Telefone: ".$con[$i]['telefone']."</p>
                                <p class='dados'>Genero: ".$con[$i]['genero']."</p>
                                <p class='dados'>Data de Nascimento: ".date_format($date, "d/m/Y")."</p>
                                <p class='dados'>Estado Civil: ".$con[$i]['estadoCivil']."</p>
                                <p class='dados'>Nº Residencial: ".$con[$i]['genero']."</p>
                                <p class='dados'>idEnd: ".$con[$i]['idEnd']."</p>
                                <p>Complemento: ".$con[$i]['complemento']."</p>
                            </td>
                            <td style='width: 5%;'>
                                <a href='../v/viewalterar.php?table=Funcionario&id_up=".$con[$i]['id']."'>
                                    <img class='btnAlt' src='img/icons/altclaro.png'/>
                                </a>
                            </td>
                            <td style='width: 5%;'>
                                <a href='http://localhost/tazware/c/processa_ex.php?table=Funcionario&id_ex=".$con[$i]['id']."'>
                                    <img class='btnDel' src='img/icons/delclaro.png'/>
                                </a>
                            </td>                   
                        </tr>
                    <tr><td><hr/></td></tr>";
                }
            }                
        }

        public function validarLogin()
        {
            $cmd = $this->pdo->prepare("SELECT id, email, nivelAcesso FROM Funcionario WHERE email = :user AND senha = :pass");
            $cmd->bindValue(':user', $this->email);
            $cmd->bindValue(':pass', $this->senha);
            $cmd->execute();
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            if ($dados == false) {
                return false;

            } else{           
                if (!isset($_SESSION)) {
                    session_start();
                }
                echo "<pre>";
                print_r($dados);
                echo "</pre>";
                var_dump($dados);

                $_SESSION['id'] = $dados['id'];
                $_SESSION['email'] = $dados['email'];
                $_SESSION['nivelAcesso'] = $dados['nivelAcesso'];
                return true;
            }            
        }

        public function desabilitarFuncionario()
        {
            $sql = "UPDATE Funcionario WHERE id = :id SET status = 0";
            $cmd = $this->pdo->prepare($sql);
            $cmd->bindValue(":id", $this->id);
            $cmd->execute();
        }

        public function getForUp()
        {
            $cmd = $this->pdo->prepare("SELECT * FROM Funcionario WHERE id = :id");         
            $cmd->bindValue(":id", $this->id);
            $cmd->execute();
            $con = $cmd->fetch(PDO::FETCH_ASSOC);
            require_once 'endereco.php';
            $end = new Endereco();
            $end->id = $con['idEnd'];
            $end->getEndById();
            if ($cmd->rowCount() > 0) {
                echo "<div class='container mt-3 pb-4'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 col-md-6 col-sm-12'>
                            <br/><h2>Dados Pessoais</h2><br/>
                        </div>
                    </div>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 col-md-6 col-sm-12 mb-5'>

                            <input type='hidden' name='id' value='".$con['id']."'/>
                            <label for='Nome' class='form-label'>Nome Completo</label>
                            <input type='text' name='nome' id='Nome' class='form-control' placeholder='Nome Completo' value='".$con['nome']."' required/>
                            
                            <label for='Rg' class='form-label'>RG</label>
                            <input type='text' name='rg' id='Rg' class='form-control' placeholder='RG' maxlength='10' value='".$con['rg']."' required/>
                            
                            <label for='Cpf' class='form-label'>CPF</label>
                            <input type='text' name='cpf' id='Cpf' class='form-control' placeholder='___.___.___.-__' value='".$con['cpf']."' required/>
                            
                            <label for='DataNasc' class='form-label'>Data de Nascimento</label>
                            <input type='date' name='dataNasc' id='DataNasc' class='form-control' value='".$con['dataNasc']."' required/>
                            
                            <label for='Genero' class='form-label'>Gênero</label>
                            <select name='genero' id='Genero' class='form-select'>
                                <option value='".$con['genero']."' selected>".$con['genero']."</option>
                                <option value='M'>Masculino</option>
                                <option value='F'>Feminino</option>
                            </select>
                            <label for='Tel' class='form-label'>Telefone</label>
                            <input type='phone' name='tel' id='Tel' class='form-control' placeholder='(__) ____-____' autocomplete='true' value='".$con['telefone']."' required/>
                            
                            <label for='Cel' class='form-label'>Celular</label>
                            <input type='phone' name='cel' id='Cel' class='form-control' placeholder='(__) _____-____' autocomplete='true' value='".$con['celular']."' required/>
                        </div>
                    </div>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 col-md-6 col-sm-12 mb-3'>
                            <h2>Dados de Usuario</h2>
                        </div>
                    </div>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 col-md-6 col-sm-12'>
                            
                            <label for='Email' class='form-label'>Email</label>
                            <input type='email' name='email' id='Email' class='form-control' placeholder='Email' autocomplete='true' maxlength='50' value='".$con['email']."' required/>
                            <label for='Senha' class='form-label'>Senha</label>
                            <div class='input-group mb-5'>
                                <input type='password' name='senha' id='Senha' class='form-control' placeholder='Senha' autocomplete='true' minlength='8' required/>
                                <div class='input-group-text'>
                                    <button class='btn mt-0' type='button' id='ms'>Mostrar Senha</button>
                                </div>
                            </div>                      
                        </div>
                    </div>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 col-md-6 col-sm-12 mb-3'>
                            <h2>Endereço</h2>
                        </div>
                    </div>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 col-md-6 col-sm-12'>
                            
                            <label for='Cep' class='form-label' on>CEP</label>
                            <input type='text' name='cep' id='Cep' class='form-control' maxlength='9' onblur='buscaCep()' placeholder='_____-___' value='".$end->cep."' required/>
                            
                            <label for='Uf' class='form-label'>UF</label>
                            <select class='form-select' id='Uf' name='uf' required>
                                <option value='".$end->uf."' selected>".$end->uf."</option>
                                <option value='AC'>AC</option>
                                <option value='AL'>AL</option>
                                <option value='AP'>AP</option>
                                <option value='AM'>AM</option>
                                <option value='BA'>BA</option>
                                <option value='CE'>CE</option>
                                <option value='DF'>DF</option>
                                <option value='ES'>ES</option>
                                <option value='GO'>GO</option>
                                <option value='MA'>MA</option>
                                <option value='MT'>MT</option>
                                <option value='MS'>MS</option>
                                <option value='MG'>MG</option>
                                <option value='PA'>PA</option>
                                <option value='PB'>PB</option>
                                <option value='PR'>PR</option>
                                <option value='PE'>PE</option>
                                <option value='PI'>PI</option>
                                <option value='RJ'>RJ</option>
                                <option value='RN'>RN</option>
                                <option value='RS'>RS</option>
                                <option value='RO'>RO</option>
                                <option value='RR'>RR</option>
                                <option value='SC'>SC</option>
                                <option value='SP'>SP</option>
                                <option value='SE'>SE</option>
                                <option value='TO'>TO</option>
                            </select>
                            <label for='Cidade' class='form-label'>Cidade</label>
                            <input type='text' name='cidade' id='Cidade' class='form-control' placeholder='Cidade' value='".$end->cidade."' required/>
                            <label for='Bairro' class='form-label'>Bairro</label>
                            <input type='text' name='bairro' id='Bairro' class='form-control' placeholder='Bairro' value='".$end->bairro."' required/>
                            <label for='Rua' class='form-label'>Rua</label>
                            <input type='text' name='rua' id='Rua' class='form-control' placeholder='Rua' value='".$end->rua."' required/>
                            <label for='nRes' class='form-label'>Nº da Residência</label>
                            <input type='number' name='nRes' id='nRes' class='form-control' placeholder='Nº da Residência' value='".$con['nResidencial']."' required/>
                            <label for='Comp' class='form-label'>Complemento</label>
                            <textarea name='complemento' id='Comp' class='form-control' maxlength='500' rows='3' placeholder='Complemento' value='".$con['complemento']."'></textarea><br/>
                        </div>
                    </div>
                </div>";
            }
        }
    }

?>