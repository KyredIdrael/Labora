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

class Clinica {
    private $pdo;
    private $id;
    private $nome;
    private $email;
    private $tel;
    private $end;
    private $nRes;
    private $servicos;
    private $comp;
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

    public function verificaClinica()
    {
        $sql = "SELECT * FROM Clinica WHERE telefone = :tel OR email = :email";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":tel", $this->tel);
        $cmd->bindValue(":email", $this->email);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);

        // Cadastra Endereço
        require_once 'endereco.php';
        $end = new Endereco();
        $end->cep = $this->end->cep;
        $end->uf = $this->end->uf;
        $end->cidade = $this->end->cidade;
        $end->bairro = $this->end->bairro;
        $end->rua = $this->end->rua;
        
        $end->cadastrarEndereco();
        // Pega id do endereço para a foreign key
        $end->getIdEnd();

        // Atribue a variavel id da class endereco
        // à variavel idEnd no objeto end
        
        $this->end->idEnd = $end->id;

        if ($cmd->rowCount() > 0 && $dados['status'] == 0) {
            $r = $this->alteraDados();
            return $r;

        } else if($cmd->rowCount() > 0 && $dados['status'] == 1) {
            return false;
        }
        else {
            $r = $this->cadastraClinica();
            return $r;
        }
    }

    protected function cadastraClinica()
    {       
        $status = 1;
        $sql = "INSERT INTO Clinica (nome, email, telefone, nRes, idEnd, servicos, status) VALUES (:n, :em, :tel, :nRes, :id, :se, :st)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":n", $this->nome);       
        $cmd->bindValue(":em", $this->email);
        $cmd->bindValue(":tel", $this->tel);
        $cmd->bindValue(":nRes", $this->nRes);
        $cmd->bindValue(":id", $this->end->idEnd);
        $cmd->bindValue(":se", $this->servicos);
        $cmd->bindParam(':st', $status, PDO::PARAM_INT, 1);
        $r = $cmd->execute();
        if ($r == 1 || $r=true) {
            return true;
        } else {
            return false;
        }
    }

    public function alteraDados(){
        $status = 1;
        $sql = "UPDATE Clinica SET nome = :n, email = :em, telefone = :tel, idEnd = :id, servicos = :se, status = :st";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":n", $this->nome);
        $cmd->bindValue(":em", $this->email);
        $cmd->bindValue(":tel", $this->tel);
        $cmd->bindValue(":id", $this->end->idEnd);
        $cmd->bindValue(":se", $this->servicos);
        $cmd->bindParam(':st', $status, PDO::PARAM_INT, 1);
        $r = $cmd->execute();
        if($r == 1 || $r == true){
            return true;

        } else{
            return false;
        }
    }

    public function dasabilitaClinica(){
        $sql = "UPDATE Clinica SET status = 0 WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id);
        $r = $cmd->execute();
        if($r == 1 || $r == true){
            return true;
        } else{
            return false;
        }
    }

    public function selectAll(){
        $cmd = $this->pdo->query("SELECT * FROM Clinica WHERE status = 1");
        $con = $cmd->fetchAll(PDO::FETCH_ASSOC);
        if (count($con) > 0) {
            
            for ($i=0; $i < count($con); $i++) {
                $str = stripslashes($con[$i]['servicos']);
                preg_replace("/[\x00-\x1F\x80-\xFF]/", '', $str);
                $this->servicos = json_decode($str, true);
                echo "<tr>
                        <td>
                            <p class='dados'>Código de clinica: ".$con[$i]['id']."</p>
                            <p class='dados'>Nome: ".$con[$i]['nome']."</p>
                            <p class='dados'>Serviços:<br/>";
                echo $this->mostraServicos($this->servicos);
                echo "</ul></p>
                    <p class='dados'>E-mail: ".$con[$i]['email']."
                    </p>
                    <p class='dados'>Telefone: ".$con[$i]['telefone']."
                    </p>
                    <p class='dados'>Endereco: ".$con[$i]['idEnd']."</p>
                    <p> Status: ".$con[$i]['status']."</p>
                    </td>
                    <td style='width: 5%;'>
                        <a href='../v/viewAlterar.php?table=Clinica&id_up=".$con[$i]['id']."'>
                            <img class='btnAlt' src='img/icons/altclaro.png'/>
                        </a>
                    </td>
                    <td style='width: 5%;'>
                        <a href='../c/processa_ex.php?table=Clinica&id_ex=".$con[$i]['id']."'>
                            <img class='btnDel' src='img/icons/delclaro.png'/>
                        </a>
                    </td>					
                </tr>
                <tr><td><hr/></td></tr>";
            }
        }
    }
    
    public function getClinicas() {
        $cmd = $this->pdo->query("SELECT * FROM Clinica WHERE status = 1");
        $con = $cmd->fetchAll(PDO::FETCH_ASSOC);
        if (count($con) > 0) {
            require_once 'endereco.php';
            $end = new Endereco();
            foreach ($con as $registro) {
                $end->id = $registro['idEnd'];
                $end->getEndById();
                $endereco = $end->rua.", ".$registro['nRes']." - ".$end->bairro.", ".$end->cidade." - ".$end->uf. ", ".$end->cep;
                $str = stripslashes($registro['servicos']);
                $str = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str);
                $this->servicos = json_decode($str, true);

                echo '<div class="col-sm-12 col-md-6 card">
                            <h4>'.$registro['nome'].'</h4>
                            <p>
                                <strong class="dTitle">Serviços</strong>:<br/>';
                $this->mostraServicos($this->servicos);
                echo '</p>
                    <p>
                        <strong class="dTitle">Endereço</strong>: '.$endereco.'
                    </p>
                    <p>
                        <strong class="dTitle">Contato</strong><br/>
                        Telefone: '.$registro['telefone'].'<br/>
                        Email: '.$registro['email'].'
                    </p>
                </div>';
            }
        }
    }

    protected function mostraServicos($array) {
        foreach ($array as $key) {
            echo "- ".$key."<br/>";
        }
    }
}
?>