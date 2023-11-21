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
	class Exame
	{
		private $pdo;
		private $id;
		private $idCliente;		
		private $idClinica;
		private $tipoExame;
		private $token;
		private $dataHoraExame;
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

	    public function cadastraExame() {
	    	$sql = "SELECT * FROM Exame WHERE idCliente = :idCliente AND tipoExame = :tE AND status = 0";
	    	$cmd = $this->pdo->prepare($sql);
	    	$cmd->bindValue(":idCliente", $this->idCliente);
	    	$cmd->bindValue(":tE", $this->tipoExame);
	    	$cmd->execute();
	    	$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
	    	unset($cmd);
	    	if ($dados->rowCount() > 0) {
	    	   	return false;

	    	} else {
	    		$status = 0;
		    	$sql = "INSERT INTO Exame(idCliente, idClinica, tipoExame, token, dataHoraExame, status) VALUES (:idCliente, :idClinica, :tE, :token, :dHE, :st)";
		    	$cmd = $this->pdo->prepare();
		    	$cmd->bindValue(":idCliente", $this->);
		    	$cmd->bindValue(":idClinica", $this->);
		    	$cmd->bindValue(":tE", $this->);
		    	$cmd->bindValue(":token", $this->);
		    	$cmd->bindValue(":dHE", $this->);
		    	$cmd->bindParam(':st', $status, PDO::PARAM_INT, 1);
		    	$r = $cmd->execute();

		    	if($r == true || $r == 1) {
		    		return true;

		    	} else {
		    		return false;
		    	}
	    	}
	    }

	    public function alteraExame()
	    {
	    	$status = 0;
	    	$sql = "INSERT INTO exame(idCliente, idClinica, tipoExame, token, dataHoraExame, status) VALUES (:idCliente, :idClinica, :tE, :token, :dHE, :st)";
	    	$cmd = $this->pdo->prepare();
	    	$cmd->bindValue(":idCliente", $this->);
	    	$cmd->bindValue(":idClinica", $this->);
	    	$cmd->bindValue(":tE", $this->);
	    	$cmd->bindValue(":token", $this->);
	    	$cmd->bindValue(":dHE", $this->);
	    	$cmd->bindParam(':st', $status, PDO::PARAM_INT, 1);
	    	$cmd->execute();

	    	if($cmd == true || $cmd == 1) {
	    		return true;

	    	} else {
	    		return false;
	    	}
	    }
	    public function consultaExame($status)
	    {
	    	$sql = "SELECT * FROM Exame";
	    	$cmd->query($sql);
	    	$con = $cmd->fetchAll(PDO::FETCH_ASSOC);
	    	echo "";
	    }
	}
?>