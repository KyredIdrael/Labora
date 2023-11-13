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
        private $nome;
        private $rg;
        private $cpf;
        private $email;
        private $senha;
        private $dataNasc;
        private $gen;
        private $estadoCiv;
        private $tel;
        private $cel;
        private $end;
        private $nRes;
        private $id;
        private $comp;
        private $nivelAcess;

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
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            if ($dados->rowCount() > 0) {
                return false;
            } else {
                $r = $this->cadastraFuncionario();
                if ($r == true || $r == 1) {
                    return true;
                }
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
            $sql = "INSERT INTO Funcionario(nome, rg, cpf, email, senha, dataNasc, genero, estadoCivil, telefone, celular, nResidencial, 
            idEnd, complemento, status, nivelAcesso) VALUES(:nome ,:rg, :cpf, :email, :senha, :dataNasc, :gen, :estadoCiv, :tel,
             :cel, :nRes, :id, :comp, :st, nA)";
            $cmd = $this->pdo->prepare($sql);
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
            $cmd->bindValue(":st", $status);
            $cmd->bindValue(":nA", $this->nivelAcesso);
            $r = $cmd->execute();

            if ($r == true || $r == 1) {
                return true;

            } else {
                return false;
            }
            
        	if (empty($_SESSION)) session_start();
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
            $r = $cmd->execute();
            if ($r == true || $r == 1) {
                return true;

            } else {
                return false;
            }
        }
        public function selectAll()
        {
            $cmd = $this->pdo->query("SELECT * FROM Endereco WHERE status = 1");
            $con = $cmd->fetchAll(PDO::FETCH_ASSOC);
            if (count($con) > 0) {
                for ($i=0; $i < count($con); $i++) {
                    echo "<tr>
                            <td>
                                <p class='dados'>Nome: ".$con[$i]['nome']."</p>
                                <p class='dados'>RG: ".$con[$i]['rg']."</p>
                                <p class='dados'>CPF: ".$con[$i]['cpf']."</p>
                                <p class='dados'>E-mail: ".$con[$i]['email']."</p>
                                <p class='dados'>Celular: ".$con[$i]['celular']."</p>
                                <p class='dados'>Telefone: ".$con[$i]['telefone']."</p>
                                <p class='dados'>Genero: ".$con[$i]['genero']."</p>
                                <p class='dados'>Data de Nascimento: ".$con[$i]['dataNasc']."</p>
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
            if (empty($dados) || $dados == false) {
                return false;

            } else{           
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['id'] = $dados['id'];
                $_SESSION['email'] = $dados['email'];
                $_SESSION['nivelAcesso'] = $dados['nivelAcesso'];
                return true;
            }            
        }
    }

?>