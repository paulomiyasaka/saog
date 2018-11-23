<?php

include_once 'auto_load.class.php';
new auto_load();

class acao extends conecta{

	//consultar unidades
	protected function consultarUnidades(){
		
		$sql = "SELECT * FROM unidades";
		$dados = array();
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();
		
		if($quant > 0){	
			
			return $resultado;
		}else{
			return false;
		}

	}
	
	//cadastrar
	public function cadastrar($sql, $dados){
		$acao = conecta::executarSQL($sql, $dados);
		$lastID = conecta::lastidSQL();
		return $lastID;
	
	}

	
	//consultar unidades para os plantões
	protected function consultarUnidadesPlantao(){
		
		$sql = "SELECT * FROM unidades ORDER BY data_inicial AND hora_inicial ASC";
		$dados = array();
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();
		
		if($quant > 0){				
			return $resultado;
		}else{
			return false;
		}

	}


	




}




?>