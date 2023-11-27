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
        $cmd = $this->pdo->query("SELECT * FROM Clinica");
        $con = $cmd->fetchAll(PDO::FETCH_ASSOC);
        if (count($con) > 0) {
            require_once 'endereco.php';
            $end = new Endereco(); 
            for ($i=0; $i < count($con); $i++) {
                $end->id = $con[$i]['idEnd'];
                $end->getEndById();
                $endereco = $end->rua.", ".$con[$i]['nRes']." - ".$end->bairro.", ".$end->cidade." - ".$end->uf. ", ".$end->cep;

                $str = preg_replace("/[\x00-\x1F\x80-\xFF]/", '', stripslashes($con[$i]['servicos']));
                $this->servicos  = json_decode($str, true);
                echo "<tr>
                        <td>
                            <p class='dados'>Código de clinica: ".$con[$i]['id']."</p>
                            <p class='dados'>Nome: ".$con[$i]['nome']."</p>
                            <p class='dados'>Serviços:<br/>";
                foreach ($this->servicos as $servico) {
                    echo "- ".$servico."<br/>";
                }
                echo "</ul></p>
                    <p class='dados'>E-mail: ".$con[$i]['email']."
                    </p>
                    <p class='dados'>Telefone: ".$con[$i]['telefone']."
                    </p>
                    <p class='dados'>Endereco: ".$endereco."</p>
                    <p> Status: ".$con[$i]['status']."</p>
                    </td>
                    <td style='width: 5%;'>
                        <a href='viewAlterar.php?table=Clinica&id_up=".$con[$i]['id']."'>
                            <img class='btnAlt' src='img/icons/altclaro.png'/>
                        </a>
                    </td>
                    <td style='width: 5%;'>
                        <a href='../controller/processaDes.php?table=Clinica&id_ex=".$con[$i]['id']."'>
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
            $i = 0; 
            foreach ($con as $registro) {
                $end->id = $registro['idEnd'];
                $end->getEndById();
                $endereco = $end->rua.", ".$registro['nRes']." - ".$end->bairro.", ".$end->cidade." - ".$end->uf. ", ".$end->cep;
                $str = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', stripslashes($registro['servicos']));
                $this->servicos = json_decode($str, true);

                echo '<div class="col-sm-12 col-md-6 card">
                            <h4 id="c'.$registro['id'].'">'.$registro['nome'].'</h4>
                            <p>
                                <strong class="dTitle">Serviços</strong>:<br/>';
                foreach ($this->servicos as $servico) {
                    echo "<a class='servicos link-offset-1 link-offset-2-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover' id='".$registro['id'].".".$i."'>".$servico."</a><br/>";
                    $i++;
                }
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

    public function getClinica()
    {
        $cmd = $this->pdo->prepare("SELECT nome FROM Clinica WHERE id = :id");
        $cmd->bindValue(":id", $this->id);
        $cmd->execute(); 
        $con = $cmd->fetchAll(PDO::FETCH_ASSOC);
        if (count($con) > 0) {
            return $con[0]['nome'];
        }
    }
    public function getForUp()
    {
        $cmd = $this->pdo->prepare("SELECT * FROM Clinica WHERE id = :id");
        $cmd->bindValue(":id", $this->id);
        $cmd->execute(); 
        $con = $cmd->fetch(PDO::FETCH_ASSOC);
        
        require_once 'endereco.php';
        $end = new Endereco();
        if (count($con) > 0) {
            $end->id = $con['idEnd'];
            $end->getEndById();
            echo '<div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                                 <h2 class="my-3">Dados da Cliníca</h2><br />
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <input type="hidden" name="id" value="'.$con['id'].'"/>

                            <label for="Nome" class="form-label">Nome*</label>
                            <input type="text" name="nome" id="Nome" class="form-control" placeholder="Nome" autocomplete="true" value="'.$con['nome'].'"/>

                            <label for="Email" class="form-label">E-mail*</label>   
                            <input type="text" name="email" class="form-control" placeholder="E-mail" value="'.$con['email'].'"> 

                            <label for="Tel" class="form-label">Telefone*</label>
                            <input type="text" name="tel" id="Tel" class="form-control" placeholder="(__) ____-____" value="'.$con['telefone'].'" required/>

                            <label for="servico" class="form-label">Serviço*</label>
                            <input type="text" id="servico" class="form-control" placeholder="Serviço" autocomplete="true"/>
                            
                            <button type="button" class="form-control btn btn-secondary my-1" onclick="adicionarServico()">Adicionar Serviço</button>
                            <button type="button" class="form-control btn btn-danger" onclick="removerServico()">Remover Serviço</button>

                            <label for="servicos" class="form-label">Lista de Serviços associados</label>
                            <textarea id="servicos" class="form-control" placeholder="Serviços Associados" readonly></textarea>

                            <input type="hidden" name="servicos" id="strJson"/>                
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <br/><br/>
                            <h2>Endereço</h2><br/>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                
                            <label for="Cep" class="form-label" on>CEP*</label>
                            <input type="text" name="cep" id="Cep" class="form-control" onblur="buscaCep()" maxlength="8" placeholder="_____-___"  value="'.$end->cep.'" required/>
                
                            <label for="Uf" class="form-label">UF*</label>
                            <select class="form-select" id="Uf" name="uf" required>
                                <option  value="'.$end->uf.'" selected> value="'.$end->uf.'"</option>
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
                            <input type="text" name="cidade" id="Cidade" class="form-control" placeholder="Cidade" value="'.$end->cidade.'" required />
                
                            <label for="Bairro" class="form-label">Bairro*</label>
                            <input type="text" name="bairro" id="Bairro" class="form-control" placeholder="Bairro" value="'.$end->bairro.'" required />
                
                            <label for="Rua" class="form-label">Rua*</label>
                            <input type="text" name="rua" id="Rua" class="form-control" placeholder="Rua" value="'.$end->rua.'" required />
                
                            <label for="nRes" class="form-label">Nº da Residência*</label>
                            <input type="number" name="nRes" id="nRes" class="form-control" placeholder="Nº da Residência" value="'.$con['nRes'].'" required />
                            
                            <label for="Comp" class="form-label">Complemento</label>
                            <textarea name="complemento" id="Comp" class="form-control mb-2" maxlength="500" rows="3" placeholder="Complemento" value="'.$con['complemento'].'"></textarea>              
                        </div>
                    </div>';
        }
    }
}
?>