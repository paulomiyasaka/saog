<?php
include_once 'auto_load.class.php';
new auto_load();

class unidades extends conecta{

	protected $nome, $trabalho, $endereco, $gerente, $matricula, $tel_gerente, $tel_gerente2, $tel_centro;
	
	public function setNome($value){
		$this->nome = $value;
	}
	public function getNome(){
		return $this->nome;
	}
	
	public function setTrabalho($value){
		$this->trabalho = $value;
	}
	public function getTrabalho(){
		return $this->trabalho;
	}
	
	public function setEndereco($value){
		$this->endereco = $value;
	}
	public function getEndereco(){
		return $this->endereco;
	}
	
	public function setGerente($value){
		$this->gerente = $value;
	}
	public function getGerente(){
		return $this->gerente;
	}

	public function setMatricula($value){
		$this->matricula = $value;
	}
	public function getMatricula(){
		return $this->matricula;
	}
	
	public function setTelGerente($value){
		$this->tel_gerente = $value;
	}
	public function getTelGerente(){
		return $this->tel_gerente;
	}

	public function setTelGerente2($value){
		$this->tel_gerente2 = $value;
	}
	public function getTelGerente2(){
		return $this->tel_gerente2;
	}
	
	public function setTelCentro($value){
		$this->tel_centro = $value;
	}
	public function getTelCentro(){
		return $this->tel_centro;
	}
	
	//consultar unidades cadastradas
	public function consultarUnidades(){
		
		$sql = "SELECT * FROM unidades WHERE status = :status ORDER BY nome";
		$dados = array(":status" => 1);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();
		
		if($quant > 0){	
			
			return $resultado;
		}else{
			return false;
		}

		
	
	}//consultar unidades
	
	
	
	//cadastrar unidades
	public function cadastrarUnidades(){
		$funcao = new funcoes();
		$nome = strtoupper($this->getNome());
		$trabalho = strtolower($this->getTrabalho());
		$endereco = strtoupper($this->getEndereco());
		$gerente = strtoupper($this->getGerente());
		$matricula = $funcao->somenteNumero($this->getMatricula());
		$tel_gerente = $funcao->somenteNumero($this->getTelGerente());
		$tel_gerente2 = $funcao->somenteNumero($this->getTelGerente2());
		$tel_centro = $funcao->somenteNumero($this->getTelCentro());


		$sql = "INSERT INTO unidades (nome, trabalho, endereco, gerente, matricula, tel_gerente, tel_gerente2, tel_centro) VALUES (:nome, :trabalho, :endereco, :gerente, :matricula, :tel_gerente, :tel_gerente2, :tel_centro)";
		$dados = array(":nome" => $nome, ":trabalho" => $trabalho, ":endereco" => $endereco, ":gerente" => $gerente, ":matricula" => $matricula, ":tel_gerente" => $tel_gerente, ":tel_gerente2" => $tel_gerente2, ":tel_centro" => $tel_centro);

		$query = conecta::executarSQL($sql, $dados);
		$resultado = conecta::lastidSQL();

		//$resultado = true;
		$retorno = "";
		if($resultado){	
			$retorno = "{'resultado':'true'}";						
		}else{
			$retorno = "{'resultado':'false'}";			
		}

		return $retorno;
	
	}//cadastrar unidades
	
	
	
	
	
	
	

}//class


?>