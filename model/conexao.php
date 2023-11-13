<?php
	class Conexao
	{		
		function conectar($dbname, $host, $user, $pass)
		{
			try {
				$pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $pass);				
			} catch (PDOException $e) {
				echo "PDOException Error.<br/>".$e->getMessage();
				//header('Location: ../v/error.php');

			} catch (Exception $e) {
				echo "Exception Error.\n".$e->getMessage();
			}
			return $pdo;
		}
	}
?>