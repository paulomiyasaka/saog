<?php
include_once 'auto_load.class.php';
new auto_load();

class distritos extends conecta{

	protected $numero_distrito, $id_unidade, $roteiros, $id_distritos;
	
	public function setNumeroDistrito($value){
		$this->numero_distrito = $value;
	}
	public function getNumeroDistrito(){
		return $this->numero_distrito;
	}
	
	public function setIdUnidade($value){
		$this->id_unidade = $value;
	}
	public function getIdUnidade(){
		return $this->id_unidade;
	}
	
	public function setRoteiros($value){
		$this->roteiros = $value;
	}
	public function getRoteiros(){
		return $this->roteiros;
	}

	public function setIdDistrito($value){
		$this->id_distritos = $value;
	}
	public function getIdDistrito(){
		return $this->id_distritos;
	}
	
	
	//consultar distritos cadastradas
	public function consultarDistritos($id_unidade){
		
		$sql = "SELECT DISTINCT numero_distrito, id_distritos FROM distritos WHERE id_unidade = :id_unidade AND status = :status ORDER BY numero_distrito ASC";
		$dados = array(":id_unidade" => $id_unidade, ":status" => 1);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = count($resultado);
		
		if($quant > 0){	
			
			return $resultado;
		}else{
			return false;
		}

		
	
	}//consultar distritos

		//consultar roteiros cadastradas
	public function consultarRoteiros($id_distritos){
		
		$sql = "SELECT roteiro FROM distritos WHERE id_distritos = :id_distritos AND status = :status LIMIT 1";
		$dados = array(":id_distritos" => $id_distritos, ":status" => 1);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		

		foreach ($resultado as $key => $value) {
			$resultado = $value->roteiro;
		}
		$quant = count($resultado);

		if($quant > 0){

			$lista = explode(";", $resultado);
			//$quant = count($resultado);

			$html = "";

			$html .= "<p><b>Roteiro:</b></p>";
			//$html .= "<br>";
			$html .= "<ul>";
			for ($i=0; $i < $quant; $i++) { 
				$html .= "<li>".$lista[$i]."</li>";
			}

			$html .= "</ul>";

			return $html;
			



		}else{
			return false;
		}
		

		
	
	}//consultar roteiros





	//listar distritos disponíveis para cadastrar plantão
	public function listarDistritos(){
		$id = $this->getIdUnidade();
		$lista = $this->consultarDistritos($id);		
		$quant = count($lista);
		$html = "";
		$i = 0;
		//var_dump($lista);
		//echo "ID: ".$this->getIdUnidade();
		$html .= "<div class=\"input-group-prepend\">
					<label class=\"input-group-text\" for=\"distrito\">Selecione um distrito</label>
				  </div>";
		$html .= "<select class=\"custom-select\" onchange=\"listarRoteiros();\" id=\"id_distrito\" name=\"id_distrito\" style=\"height: 35px; width: 100%\" required>";
				

		if($lista){

			$html .= "<option value=\"N\" selected>Escolha um distrito</option>";

			foreach($lista as $row){
				 $html .= "<option value=\"".$row->id_distritos."\">".$row->numero_distrito."</option>";
			}

		}else{
			$html .= "<option value=\"N\">Não há distritos</option>";

		}
			$html .= "</select>";
			return $html;
	
	}//listar distritos para o plantão

	//listar roteiros disponíveis para cadastrar plantão
	public function listarRoteiros(){
		$id = $this->getIdDistrito();
		$lista = $this->consultarRoteiros($id);		
		$quant = count($lista);
		$html = "";
		$i = 0;
		//var_dump($lista);
		//echo "ID: ".$this->getIdUnidade();
		//$html .= "<div class=\"form-group\">
		//		    <label for=\"lista_roteiros\">Roteiro: </label>
		//		    <textarea class=\"form-control\" id=\"lista_roteiros\" rows=\"3\">";

				   $html .= $lista;


		//$html .= "</textarea>
		//		  </div>";

			return $html;
	
	}//listar roteiros para o plantão
	
	
	
	//cadastrar unidades
	public function cadastrarDistritos(){
		$funcao = new funcoes();
		$numero_distrito = $funcao->somenteNumero($this->getNumeroDistrito());
		$id_unidade = $funcao->somenteNumero($this->getIdUnidade());
		$roteiro = strtolower($this->getRoteiros());


		$sql = "INSERT INTO distritos (id_unidade, numero_distrito, roteiro) VALUES (:id_unidade, :numero_distrito, :roteiro)";
		$dados = array(":id_unidade" => $id_unidade, ":numero_distrito" => $numero_distrito, ":roteiro" => $roteiro);

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