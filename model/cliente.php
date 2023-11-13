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
     * 
     * 
     * 
     * VerificaUsuario
        CadastraUsuario 
         AlteraUsuario
        ConsultaUsuario
        DesabilitaUsuario
     * 
     * 
	 */
	class Cliente
	{
		private $pdo;
		private $id;
		private $nome;
		private $rg;
		private $cpf;
		private $tel;
		private $cel;
		private $email;
		private $senha;
		private $dataNasc;
		private $genero;
		private $end;
		private $nRes;
		private $comp;			

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
        //-----

	    public function verificarUsuario()
	    {
	    	$sql = "SELECT email, id FROM Cliente WHERE email = :email or rg = :rg or cpf = :cpf";
		    $cmd = $this->pdo->prepare($sql);
		    $cmd->bindValue(":email", $this->email);
			$cmd->bindValue(":cpf", $this->cpf);
			$cmd->bindValue(":rg", $this->rg);
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

			$this->idEnd = $end->getIdEnd();

			if ($this->idEnd == false) {
				header("Location: ../view/error.php");
			}

	    	if ($cmd->rowCount() > 0) {
	    		return false;

	    	} else {
				return $this->cadastraCliente();	
	    	}	    	    	
	    }

	    protected function cadastraCliente()    
	    {
	    	/*
	    		status é campo em bit
	    		1 = ativo
	    		0 = inativo
	    	*/
	    	$status = 1;
	    	$sql = "INSERT INTO Cliente(nome, rg, cpf, dataNasc, genero, telefone, celular, email, senha, idEnd, nResidencial, complemento) 
            VALUES(:nome ,:rg, :cpf, :dataNasc, :genero, :tel, :cel, :email, :senha, :id, :nRes, :comp)";
		   $cmd = $this->pdo->prepare($sql);
		   $cmd->bindValue(":nome", $this->nome);
		   $cmd->bindValue(":rg", $this->rg);
		   $cmd->bindValue(":cpf", $this->cpf);
		   $cmd->bindValue(":dataNasc", $this->dataNasc);
		   $cmd->bindValue(":genero", $this->genero);
		   $cmd->bindValue(":tel", $this->tel);
		   $cmd->bindValue(":cel", $this->cel);
		   $cmd->bindValue(":email", $this->email);
		   $cmd->bindValue(":senha", $this->senha);
			$cmd->bindValue(":id", $this->idEnd);
			$cmd->bindValue(":nRes", $this->nRes);
			$cmd->bindValue(":comp", $this->comp);
			$cmd->execute();

			if ($cmd == true || $cmd == 1) {
				return true;

			} else {
				return false;
			}
	    }

		public function getIdCliente()
		{
			$sql = "SELECT id FROM Cliente WHERE cpf = :cpf AND rg = :rg";
		    $cmd = $this->pdo->prepare($sql);
		    $cmd->bindValue(":cpf", $this->cpf);
			$cmd->bindValue(":rg", $this->rg);
			$cmd->execute();
			$id = $cmd->fetch(PDO::FETCH_ASSOC);
			
			$this->idCivil = $id['id'];

			if ($cmd->rowCount() > 0) {
	    		return false;

	    	} else {
	    		return true;	
	    	}
		}
		
	
		protected function alteraUsuario() {
					
			$sql = "UPDATE Cliente SET nome = :nome ,dataNasc = :dataN , genero = :ge , telefone = :tel ,  
			celular = :cel , email = :e, senha = :s , nResidencial = :nRes , complemento = :comp  where id = :id";
		    $cmd = $this->pdo->prepare($sql);
			$cmd->bindValue(":nome", $this->nome);
			$cmd->bindValue(":dataN", $this->dataNasc);
			$cmd->bindValue(":ge", $this->genero);
			$cmd->bindValue(":tel", $this->tel);
			$cmd->bindValue(":cel", $this->cel);
			$cmd->bindValue(":e", $this->email);
			$cmd->bindValue(":s", $this->senha);
			$cmd->bindValue(":nRes", $this->nRes);
			$cmd->bindValue(":comp", $this->comp);
			$cmd->bindValue(":dep", $this->dependente);
			$cmd->bindValue(":id", $this->id);
			$r = $cmd->execute();
			 

			if ($cmd == true || $cmd == 1) {
				return true;

			} else {
				return false;
			}


	}

	protected function ConsultaCliente() {
					
		$sql = "SELECT nome , dataNasc , genero , telefone , celular , email , nResidencial , cwwomplemento FROM Cliente WHERE id = :id";
		$cmd = $this->pdo->prepare($sql);
		$cmd->bindValue(":id", $this->id);
		$r = $cmd->execute();
		 

		if ($cmd == true || $cmd == 1) {
			return true;

		} else {
			return false;
		}


	}

	public function desabilitarCliente(){
        $sql = "UPDATE Cliente WHERE id = :id SET status = 0";
        $cmd = $this->pdo->prepare($sql);
		$cmd->bindValue(":id", $this->id);
        $cmd->execute();
    }

	public function selectAll()
		{
			$cmd = $this->pdo->query("SELECT * FROM Cliente");
			$con = $cmd->fetchAll(PDO::FETCH_ASSOC);
			if (count($con) > 0) {
				for ($i=0; $i < count($con); $i++) {
					echo "<tr>
							<td>
								<p class='dados'>Nome: ".$con[$i]['nome']."</p>
								<p class='dados'>Data de Nascimento: ".$con[$i]['dataNasc']."</p>
								<p class='dados'>Genero: ".$con[$i]['genero']."</p>
								<p class='dados'>Telefone: ".$con[$i]['telefone']."</p>
								<p class='dados'>Celular: ".$con[$i]['celular']."</p>
								<p class='dados'>E-mail: ".$con[$i]['email']."</p>
								<p class='dados'>Nº Residencial: ".$con[$i]['nResidencial']."</p>
								<p class='dados'>idEnd: ".$con[$i]['idEnd']."</p>
								<p class='dados'>Complemento: ".$con[$i]['complemento']."</p>
							</td>
							<td style='width: 5%;'>
									<a href='http://localhost/labora/v/viewAlterar.php?table=Cliente&id_up=".$con[$i]['id']."'>
									<img class='btnAlt' src=src='img/icons/altclaro.png'/>/>
								</a>
							</td>
							<td style='width: 5%;'>
									<a href='/processaDes.php?table=Cliente&id_ex=".$con[$i]['id']."'>
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
            $cmd = $this->pdo->prepare("SELECT id, email FROM Cliente WHERE email = :user AND senha = :pass");
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
                return true;
            }            
        }
	
	}
?>