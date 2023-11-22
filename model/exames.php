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
		private $dataHora;
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

	    public function cadastrarExame() {
	    	$sql = "SELECT * FROM Exame WHERE token = :token";
	    	$cmd = $this->pdo->prepare($sql);
	    	$cmd->bindValue(":token", $this->token);
	    	$cmd->execute();
	    	$con = $cmd->fetchAll(PDO::FETCH_ASSOC);
	    	if (empty($con['token'])) {
	    		$bdToken = 0;
	    	}
	    	$token = $this->token;
	    	if ($bdToken == $token) {
	    		$this->token = hash("sha256", base64_encode(uniqid()));
	    		$this->cadastrarExame();
	    	}
	    	unset($con);
	    	$sql = "SELECT * FROM Exame WHERE (tipoExame = :tipo AND idCliente = :id AND status = 1) OR (SELECT COUNT(idCliente) FROM exame WHERE idCliente = :id AND status = 1) = 3";
	    	$cmd = $this->pdo->prepare($sql);
	    	$cmd->bindValue(":id", $this->idCliente);
	    	$cmd->bindValue(":tipo", $this->tipoExame);
	    	$cmd->execute();
	    	$con = $cmd->fetchAll(PDO::FETCH_ASSOC);
	    	if (count($con) > 0) {	    				
	    	   	return false;

	    	} else {
	    		$status = 1;
		    	$sql = "INSERT INTO Exame(idCliente, idClinica, tipoExame, token, dataHoraExame, status) VALUES (:idCliente, :idClinica, :tE, :token, :dHE, :st)";
		    	$cmd = $this->pdo->prepare($sql);
		    	$cmd->bindValue(":idCliente", $this->idCliente);
		    	$cmd->bindValue(":idClinica", $this->idClinica);
		    	$cmd->bindValue(":tE", $this->tipoExame);
		    	$cmd->bindValue(":token", $this->token);
		    	$cmd->bindValue(":dHE", $this->dataHora);
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
	    	$status = 1;
	    	$sql = "INSERT INTO exame(idCliente, idClinica, tipoExame, token, dataHoraExame, status) VALUES (:idCliente, :idClinica, :tE, :token, :dHE, :st)";
	    	$cmd = $this->pdo->prepare();
	    	$cmd->bindValue(":idCliente", $this->idCliente);
	    	$cmd->bindValue(":idClinica", $this->idClinica);
	    	$cmd->bindValue(":tE", $this->tipoExame);
	    	$cmd->bindValue(":token", $this->token);
	    	$cmd->bindValue(":dHE", $this->dataHora);
	    	$cmd->bindParam(':st', $status, PDO::PARAM_INT, 1);
	    	$cmd->execute();

	    	if($cmd == true || $cmd == 1) {
	    		return true;

	    	} else {
	    		return false;
	    	}
	    }

	    public function consultaExames()
	    {
	    	$sql = "SELECT * FROM Exame WHERE idCliente = :id AND status = 1";
	    	$cmd = $this->pdo->prepare($sql);
	    	$cmd->bindValue(":id", $this->idCliente);
	    	$cmd->execute();
	    	$con = $cmd->fetchAll(PDO::FETCH_ASSOC);
	    	//var_dump($con);
	    	require_once 'clinica.php';
	    	foreach ($con as $key => $array) {
	    		$cli = new Clinica();
			    $cli->id = $array['idClinica'];	    	
			    $nome = $cli->getClinica(); 
			    $base64 = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.
			    base64_encode('{"nome":"", "tipoExame":"'.$array['tipoExame'].'","dataHora":"'.
			    	$array['dataHoraExame'].'", "token":"'.$array['token'].'"}');

		    	echo '<div class="col-sm-12 col-md-4 card text-center">
					<p>Clinica: '.$nome.'</p>
					<p>Exame: '.$array['tipoExame'].'</p>
					<p>Data e Hora: '.$array['dataHoraExame'].'</p>
					<center><img idClinica width="150" height="150" src="'.$base64.'"}"/></center>
				</div>';	
	    	}

	    }
	}
?>