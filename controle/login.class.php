<?php

include_once 'auto_load.class.php';
new auto_load();

class login extends conecta{

	protected $matricula;

	public function setMatricula($valor){
		$this->matricula = $valor;
	}

	public function getMatricula(){
		return $this->matricula;
	}


	public function logar(){

		$usuario = $this->getMatricula();

		$sql = "SELECT matricula, nome, lotacao, funcao, telefone FROM colaboradores WHERE matricula = :matricula AND status = :status";
		$dados = array(":matricula" => $usuario, ":status" => 1);

		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetch(PDO::FETCH_OBJ);
		$quant = $query->rowCount();		
		if($quant == 1){					
			//return $resultado;			
			return $resultado;
		}else{
			return false;
		}



	}



}



?>