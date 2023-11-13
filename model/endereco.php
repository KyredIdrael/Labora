<?php
class Endereco {
    private $pdo;
    private $id;
    private $cep;
    private $uf;
    private $cidade;
    private $bairro;
    private $rua;
    private $status;

    public function __construct() {
        require_once 'conexao.php';
        $con = new Conexao();
        $this->pdo = $con->conectar("bdlabora","localhost","root","");
    }
    public function __set($atributo, $value) {
        $this->$atributo = $value;
    }
    public function __get($atributo) {
        return $this->$atributo;
    }


    public function cadastrarEndereco() {
		$cmd = $this->pdo->prepare('SELECT cep FROM Endereco WHERE cep = :cep');
		$cmd->bindparam(":cep", $this->cep);
		$cmd->execute(); 
		$cmd->fetch(PDO::FETCH_ASSOC);
		if ($cmd->rowCount() > 0) {
			$this->alterarEndereco();
            return false;
		}
		else{
			$status = 1;
			$cmd = $this->pdo->prepare('INSERT INTO Endereco (cep, uf, cidade, bairro, rua, status) VALUES (:cep, :uf, :cid, :bairro, :rua, :stat)');
			$cmd->bindValue(":cep", $this->cep);
			$cmd->bindValue(":uf", $this->uf);
			$cmd->bindValue(":cid", $this->cidade);
			$cmd->bindValue(":bairro", $this->bairro);
			$cmd->bindValue(":rua", $this->rua);
			$cmd->bindParam(':stat', $status, PDO::PARAM_INT, 1);
			$cmd->execute();
			return true;
		}
    }

    public function consultaEndereco() {
        $sql = "SELECT * FROM Endereco";
        $cmd = $this->pdo->prepare($sql);
        $cmd->execute();
        $cmd->fetchAll(PDO::FETCH_ASSOC);
        if ($cmd->rowCount() > 0) {
            return true;
 
        } else {
            return false;
        }
    }

    public function alterarEndereco() {
        $status = 1;
        $sql = "UPDATE Endereco SET uf = :uf, cidade = :cidade, bairro = :bairro, rua = :rua, status = :stat WHERE cep = :cep";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":cep", $this->cep);
        $cmd->bindValue(":uf", $this->uf);
        $cmd->bindValue(":cidade", $this->cidade);
        $cmd->bindValue(":bairro", $this->bairro);
        $cmd->bindValue(":rua", $this->rua);
        $cmd->bindParam(':stat', $status, PDO::PARAM_INT, 1);
        $r = $cmd->execute();
        if($r == true || $r == 1){
            return true;
        } else {
            return false;
        }
    }

    public function desabilitarEndereco() {
        $sql = "UPDATE Endereco SET status = :st WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":st", $this->status);
        $cmd->bindValue(":id", $this->id);
        $r = $cmd->execute();
        if($r == true || $r == 1){
            return true;
        } else {
            return false;
        }
    }

	public function getIdEnd() {
		$sql = "SELECT id FROM Endereco WHERE cep = :c";
		$cmd = $this->pdo->prepare($sql);
		$cmd->bindValue(":c", $this->cep);
		$cmd->execute();
		$array = $cmd->fetch(PDO::FETCH_ASSOC);
		$this->id = $array['id'];
		return true;
	}
    public function selectAll(){
        $cmd = $this->pdo->query("SELECT id, cep, uf, cidade, bairro, rua, status FROM Endereco WHERE status = 1");
		$con = $cmd->fetchAll(PDO::FETCH_ASSOC);
		if (count($con) > 0) {
			for ($i=0; $i < count($con); $i++) {
				echo "<tr>
						<td>
							<p class='dados'>CEP: ".$con[$i]['cep']."</p>
							<p class='dados'>UF: ".$con[$i]['uf']."</p>
							<p class='dados'>Cidade: ".$con[$i]['cidade']."</p>
							<p class='dados'>Bairro: ".$con[$i]['bairro']."</p>
							<p class='dados'>Rua: ".$con[$i]['rua']."</p>
							<p>Status: ".$con[$i]['status']."</p>
						</td>
						<td style='width: 5%;'>
							<a href='../v/viewalterar.php?table=Endereco&id_up=".$con[$i]['id']."'>
								<img class='btnAlt' src='img/icons/altclaro.png'/>
							</a>
						</td>
						<td style='width: 5%;'>
							<a href='http://localhost/tazware/c/processa_ex.php?table=Endereco&id_ex=".$con[$i]['id']."'>
								<img class='btnDel' src='img/icons/delclaro.png'/>
							</a>
						</td>					
					</tr>
				<tr><td><hr/></td></tr>";
			}
		}
    }
}
?>