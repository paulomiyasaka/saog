<?php
include_once 'auto_load.class.php';
new auto_load();
header("Content-Type: text/html; charset=UTF-8",true);

class plantao extends conecta{

	protected $id_plantao, $id_unidade, $id_distritos, $nome_unidade, $data_inicio, $data_final, $hora_inicio, $hora_final, $vagas, $tipo_trabalho, $motorista;
	
	public function setIdPlantao($valor){
		$this->id_plantao = $valor;		
	}	
	public function getIdPlantao(){
		return $this->id_plantao;		
	}


	public function setIdUnidade($valor){
		$this->id_unidade = $valor;		
	}	
	public function getIdUnidade(){
		return $this->id_unidade;		
	}

	public function setIdDistrito($valor){
		$this->id_distritos = $valor;		
	}	
	public function getIdDistrito(){
		return $this->id_distritos;		
	}
	
	public function setNomeUnidade($valor){
		$this->nome_unidade = $valor;		
	}	
	public function getNomeUnidade(){
		return $this->nome_unidade;		
	}
	
	public function setDataInicio($valor){
		$this->data_inicio = $valor;		
	}	
	public function getDataInicio(){
		return $this->data_inicio;		
	}
	
	public function setDataFinal($valor){
		$this->data_final = $valor;
		
	}	
	public function getDataFinal(){
		return $this->data_final;		
	}
	
	public function setHoraInicio($valor){
		$this->hora_inicio = $valor;		
	}	
	public function getHoraInicio(){
		return $this->hora_inicio;		
	}
	
	public function setHoraFinal($valor){
		$this->hora_final = $valor;		
	}	
	public function getHoraFinal(){
		return $this->hora_final;		
	}
	
	public function setVagas($valor){
		$this->vagas = $valor;
	}
	
	public function getVagas(){
		return $this->vagas;
	}

	public function setMotorista($valor){
		$this->motorista = $valor;
	}
	
	public function getMotorista(){
		return $this->motorista;
	}
	
	public function setTipoTrabalho($valor){
		$this->tipo_trabalho = $valor;
	}
	
	public function getTipoTrabalho(){
		return $this->tipo_trabalho;
	}










	
	//listar unidades disponíveis para cadastrar plantão
	public function listarUnidadesPlantao(){
		$unid = new unidades();
		$unidades = $unid->consultarUnidades();		
		$quant = count($unidades);
		$i = 0;
		 $html = "";
		 $html .= "<select class=\"custom-select\" id=\"id_unidade\" name=\"id_unidade\" onchange=\"habilitarAlterar(); listarDistritos();\" style=\"height: 35px; width: 100%\" required>
				<option value=\"0\">Escolha a Unidade</option>";

		foreach($unidades as $row){
			$html .= "<option value=\"".$row->id_unidade."\">".$row->nome." - ".ucwords(strtolower($row->trabalho))."</option>";
		}

		$html .= "</select>";

		echo $html;
			
	
	}//listar unidades para o plantão
	


	public function listarUnidadesPlantao2(){
		$unid = new unidades();
		$unidades = $unid->consultarUnidades();		
		$quant = count($unidades);
		$i = 0;
		 $html = "";
		 $html .= "<select class=\"custom-select\" id=\"id_unidade2\" name=\"id_unidade2\" style=\"height: 35px; width: 100%\" required>
				<option value=\"0\">Escolha a Unidade</option>";

		foreach($unidades as $row){
			$html .= "<option value=\"$row->id_unidade\">".$row->nome." - ".ucwords(strtolower($row->trabalho))."</option>";
		}

		$html .= "</select>";

		echo $html;
			
	
	}//listar unidades para o plantão




	public function cadastradosPlantao(){





	}






	
	
	//cadastrar plantão
	public function cadastrarPlantao(){
		date_default_timezone_set('America/Sao_Paulo');
		$funcoes = new funcoes();
		
		$id_unidade = (int) $this->getIdUnidade();
		$id_distritos = (int) $this->getIdUnidade();
		$data_inicio = $this->getDataInicio();
		$hora_inicio = $this->getHoraInicio();
		
		$dataInicioConverter = $funcoes->converterData($data_inicio);
		$horaInicioConverter = $funcoes->converterHora($hora_inicio);
		$turno_inicio = $dataInicioConverter ." ". $horaInicioConverter;
		$turno_inicio = date("Y-m-d H:i:s", strtotime($turno_inicio));
		
		$data_final = $this->getDataFinal();
		$hora_final = $this->getHoraFinal();
		
		$dataFinalConverter = $funcoes->converterData($data_final);
		$horaFinalConverter = $funcoes->converterHora($hora_final);
		$turno_final = $dataFinalConverter ." ". $horaFinalConverter;
		$turno_final = date("Y-m-d H:i:s", strtotime($turno_final));
		
		$vagas = (int) $this->getVagas();	
		$motorista = (int) $this->getMotorista();		
		
		$agora = date("Y-m-d H:i:s"); 

		$resultado = false;
		
		if($id_unidade != NULL && $agora < $turno_inicio || $agora < $turno_final && $turno_inicio < $turno_final && $vagas > 0){

			$sql = "SELECT COUNT(id_plantao) AS quant FROM plantao WHERE id_unidade = :id_unidade AND id_distritos = :id_distritos AND ((turno_inicio BETWEEN :turno_inicio AND :turno_final) OR (turno_final BETWEEN :turno_inicio AND :turno_final)) LIMIT 1";
			$dados = array(':id_unidade' => $id_unidade, ':id_distritos' => $id_distritos, ':turno_inicio' => $turno_inicio, ':turno_final' => $turno_final);
			$query = conecta::executarSQL($sql, $dados);
			$result = $query->fetchAll(PDO::FETCH_OBJ);
			$cadastrar = true;

			foreach($result as $k => $v){
				if($v->quant > 0){
					$cadastrar = false;
				}
				//$cadastrado = $v;
			}

			$sql = null;
			$dados = null;

			if($cadastrar){

							
			$sql = "INSERT INTO plantao (id_unidade, id_distritos, turno_inicio, turno_final, vagas, motorista) VALUES (:id_unidade, :id_distritos, :turno_inicio, :turno_final, :vagas, :motorista)";
			$dados = array(':id_unidade' => $id_unidade, ':id_distritos' => $id_distritos, ':turno_inicio' => $turno_inicio, ':turno_final' => $turno_final, ':vagas' => $vagas, ':motorista' => $motorista);
			
			
			$cadastrar = conecta::executarSQL($sql, $dados);
			$resultado = conecta::lastidSQL();

			//$resultado = true;
			
			}

		}


		$retorno = "";
		if($resultado){	
			$retorno = "{'resultado':'true'}";						
		}else{
			$retorno = "{'resultado':'false'}";			
			
		}

		return $retorno;
	
	}//cadastrar plantão


	//alterar plantão
	public function alterarPlantao(){
		
		$funcoes = new funcoes();
		
		$id_plantao = (int) $this->getIdPlantao();
		$id_unidade = (int) $this->getIdUnidade();
		$id_distritos = $this->getIdDistrito();
		if($id_distritos != NULL){
			$id_distritos = (int) $id_distritos;
		}else{
			$id_distritos = NULL;
		}
		$data_inicio = $this->getDataInicio();
		$hora_inicio = $this->getHoraInicio();

		$dataInicioConverter = $funcoes->converterData($data_inicio);
		$horaInicioConverter = $funcoes->converterHora($hora_inicio);
		$turno_inicio = $dataInicioConverter ." ". $horaInicioConverter;
		//$turno_inicio = date("Y-m-d H:i:s", strtotime($turno_inicio));

		//date_timezone_set('America/Sao_Paulo');
		$turno_inicio = date_create($turno_inicio,timezone_open("America/Sao_Paulo"));
		$turno_inicio = date_format($turno_inicio,"Y-m-d H:i:s");

		
		$data_final = $this->getDataFinal();
		$hora_final = $this->getHoraFinal();
		
		$dataFinalConverter = $funcoes->converterData($data_final);
		$horaFinalConverter = $funcoes->converterHora($hora_final);
		$turno_final = $dataFinalConverter ." ". $horaFinalConverter;
		//$turno_final = date("Y-m-d H:i:s", strtotime($turno_final));

		$turno_final = date_create($turno_final,timezone_open("America/Sao_Paulo"));
		$turno_final = date_format($turno_final,"Y-m-d H:i:s");
		
		$vagas = (int) $this->getVagas();	
		$motorista = (int) $this->getMotorista();		
		
		$agora = date("Y-m-d H:i:s", time()); 

		$resultado = false;
		$dados = "";
		if($id_unidade != NULL && $agora < $turno_inicio && $agora < $turno_final && $turno_inicio < $turno_final && $vagas > 0){

		
		$sql = "UPDATE plantao SET id_unidade = :id_unidade, id_distritos = :id_distritos, turno_inicio = :turno_inicio, turno_final = :turno_final, vagas = :vagas, motorista = :motorista WHERE id_plantao = :id_plantao";
		$dados = array(':id_unidade' => $id_unidade, ":id_distritos" => $id_distritos, ':turno_inicio' => $turno_inicio, ':turno_final' => $turno_final, ':vagas' => $vagas, ':motorista' => $motorista, ":id_plantao" => $id_plantao);
		//var_dump($dados);

		//return $dados;
		$cadastrar = conecta::executarSQL($sql, $dados);
		if($cadastrar->rowCount() > 0){
			$resultado = true;
		}

		
		
		}else{
			$resultado = false;
		}

		
		return $resultado;
	
	}//alterar plantão






	//gerar horários para o plantão
	public function gerarHorario(){

		echo "<option value='NULL' selected>Selecione um horário</option>";

		for($i = 0; $i <= 23; $i++){
			if($i < 10){
				echo "<option value='$i'>0".$i.":00</option>";
			}else{
				echo "<option value='$i'>".$i.":00</option>";
			}
			
		}

	

	}//gerar horario


	

	public function plantaoPassado(){
		$quant = 0;

		if(isset($_SESSION['matricula'])){

			$matricula = $_SESSION['matricula'];
			$gerente = $this->verificarGerente($_SESSION['matricula']);
			
			$resultado = false;
			if($gerente){

				$sql = "SELECT p.*, u.* FROM plantao as p INNER JOIN unidades as u ON p.id_unidade = u.id_unidade WHERE p.turno_final <= now() AND p.status = :status AND u.matricula = :matricula ORDER BY p.turno_final DESC";
				$dados = array("matricula" => $matricula, ":status" => 1);
				$query = conecta::executarSQL($sql, $dados);
				$resultado = $query->fetchAll(PDO::FETCH_OBJ);
				$quant = $query->rowCount();

			}else{

				$sql = "SELECT p.*, u.* FROM plantao as p INNER JOIN unidades as u ON p.id_unidade = u.id_unidade AND p.turno_final <= now() WHERE p.status = :status ORDER BY p.turno_final DESC";
				$dados = array(":status" => 1);
				$query = conecta::executarSQL($sql, $dados);
				$resultado = $query->fetchAll(PDO::FETCH_OBJ);
				$quant = $query->rowCount();


			}
		}

		
		if($quant > 0){				
			$i = 0;
			//while($i < $quant){

			 echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\">
				      <h1 class=\"display-4\">Plantões Anteriores</h1>      
				    </div>
					</div>
					</div>";

					echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\">
				      <h4 class=\"lead text-center\">Nestes plantões os gerentes devem registrar a presença dos colaboradores inscritos no plantão.</h4>      
				    </div>
					</div>						
					</div>
					";


			echo "<div class=\"row justify-content-md-center\">";

			foreach ($resultado as $row) {		


				$funcoes = new funcoes();
			    $data = $funcoes->montarDataPlantao($row->turno_inicio, $row->turno_final);
			    $id_plantao = $row->id_plantao;
			    $motorista = $row->motorista;
			   	 


			echo "<div class=\"col-sm-12 col-md-6 col-lg-4 text-center\" style=\"margin-top: 15px; margin-bottom: 15px;\">
			<div class=\"card\">

			  <div class=\"card-body border border-dark\">
			  	<div class=\"alert alert-secondary\" role=\"alert\">
			    <h3 class=\"card-title\">".$row->nome."<br>".ucwords(strtolower($row->trabalho))."</h3>
			    <h4 class=\"card-subtitle mb-2 text-muted\">".$row->endereco."</h4>
			    </div>			    			    
			    <hr>";
			    



			echo "<h4 class=\"card-text text-center\">".$data."</h4><br>
			    <h5 class=\"card-text text-left\"><b>Gerente:</b> ".ucwords(strtolower($row->gerente))."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_gerente, 0, 5)."-".substr($row->tel_gerente, 5, 8)."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_gerente2, 0, 5)."-".substr($row->tel_gerente2, 5, 8)."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_centro, 0, 4)."-".substr($row->tel_centro, 4, 7)."</h5>
			    <hr>";
	    

			if(isset($_SESSION['matricula'])){

				$id_colaborador = $this->verificarMatricula($matricula);


			$cadastrado = $this->verificarCadastroPlantao($id_colaborador, $id_plantao);
			$vagas_disponiveis = $this->contarVagas($id_plantao);
			$vagas_total = $this->vagasDisponiveis($id_plantao);
			$inscritos = $vagas_total - $vagas_disponiveis;

			$gerente = $this->verificarGerente($_SESSION['matricula']);
			$unid = $this->plantaoUnidade($id_plantao);
			if($gerente == $unid){
				$gerente = true;
			}else{
				$gerente = false;
			}

			$adm = $this->verificarAdministrador($matricula);


				if($adm || $gerente){

					if($vagas_disponiveis != $vagas_total){
						$id_plantao_64 = base64_encode($id_plantao);
						
					 echo "<a id=\"btn_inscritos\" href=\"inscritos_plantao.php?p=".$id_plantao_64."\" class=\"btn btn-primary card-link\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Veja a lista de inscritos e registre o efetivo do plantão.\" ><b>Inscritos no Plantão</b> <span class=\"badge badge-dark\">". $inscritos." / ". $vagas_total ."</span></a>";

					}else{
						echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Não houve inscritos neste plantao.\">";
						echo "<button id=\"btn_inscritos\" type=\"button\" class=\"btn btn-secundary card-link\" onclick=\"verInscritos(".$id_plantao.");\" style=\"pointer-events: none;\" disabled><b>Sem inscrições no Plantão</b> <span class=\"badge badge-light text-light\">". $inscritos ." / ". $vagas_total ."</span></button>";
						echo "</span>";
					}

				}


			}
			
			  echo "</div>
			  		</div>					
					</div>";

			$i++;
			
			//}

			}



		}else{
			echo "<div class=\"col-12 align-self-center\"><div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\"><h1 class=\"display-4\">Não Há Plantões Realizados</h1></div>";

		}


	}





	//listar plantões disponíveis
	public function listarPlantao(){

		
		$sql = "SELECT p.*, u.* FROM plantao as p INNER JOIN unidades as u ON p.id_unidade = u.id_unidade AND p.turno_final > now() WHERE p.status = :status ORDER BY p.turno_inicio ASC";
		$dados = array(":status" => 1);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();

		if($quant > 0){				
			$i = 0;
			//while($i < $quant){

			 echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\">
				      <h1 class=\"display-4\">Plantões Ativos</h1>      
				    </div>
					</div>
					</div>";

					echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\">
				      <h4 class=\"lead text-justify\">Este sistema permite a inscrição de colaboradores que estejam <b>dispostos a contribuir</b> nos plantões criados para o tratamento ou distribuição de encomendas.</h4>
				      <br>
				      <h4 class=\"lead text-center\"><b>Para a inscrição no plantão ou o agendamento de folga, o colaborador deverá COMUNICAR o seu gestor imediato com antecendência.</b></h4>
				      <br>       
				    </div>
					</div>						
					</div>
					";


			echo "<div class=\"row justify-content-md-center\">";

			foreach ($resultado as $row) {		


				$funcoes = new funcoes();
			    $data = $funcoes->montarDataPlantao($row->turno_inicio, $row->turno_final);
			    $id_plantao = $row->id_plantao;
			    $motorista = $row->motorista;
			    /*
			    if($motorista){
			    	$motorista = "Precisará de motoristas";
			    }else{
			    	$motorista = false;
			    }
				*/
				$adm = false;
				$matricula = false;
			 	if(isset($_SESSION['matricula'])){

					$matricula = $_SESSION['matricula'];
			    	$adm = $this->verificarAdministrador($matricula);
				}

			echo "<div class=\"col-sm-12 col-md-6 col-lg-4 text-center\" style=\"margin-top: 15px; margin-bottom: 15px;\">
			<div class=\"card\">

			  <div class=\"card-body border border-dark\">
			  	<div class=\"alert alert-secondary\" role=\"alert\">";
			  	
			    
			    $quant = count($row->id_distritos);

			    $sql_d = "SELECT roteiro, numero_distrito FROM distritos WHERE id_distritos = :id_distritos";
			    $dados_d = array(":id_distritos" => $row->id_distritos);
			    $q = conecta::executarSQL($sql_d, $dados_d);
			    $resultado_d = $q->fetchAll(PDO::FETCH_OBJ);
			    $roteiro = "";
			    $numero_distrito = "";
			    foreach ($resultado_d as $k => $v) {
			    	 $numero_distrito = $v->numero_distrito;
			    	$lista = explode(";", $v->roteiro);
			    	$quant = count($lista);
			    	if($quant > 1){
					$roteiro .= "<p><b>Roteiro:</b></p>";
					//$html .= "<br>";
					$roteiro .= "<ul>";
					for ($i=0; $i < $quant; $i++) { 
						$roteiro .= "<li>".strtoupper($lista[$i])."</li>";
					}

						$roteiro .= "</ul><br>";

				    }else{
				    	$roteiro .= "<p><b>Roteiro:</b></p>";					
						$roteiro .= "<ul>";
						$roteiro .= "<li>".strtoupper($lista[0])."</li>";
						$roteiro .= "</ul><br>";
				    }

			    }


			    if($adm){
			  		echo "<i class=\"material-icons float-left btn-outline-info\" style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#modalPlantao\" onclick=\"editPlantao(".$id_plantao.");\">edit</i>
			  	<i class=\"material-icons float-right btn-outline-danger\" style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#modalDelete\" onclick=\"delPlantao(".$id_plantao.");\">delete</i>";
			  	}
			  	
			    echo "<h3 class=\"card-title\">".$row->nome."<br>".ucwords(strtolower($row->trabalho))."</h3>";
			    
			    if($numero_distrito != "" && $numero_distrito != NULL){
			    	echo "<h4 class=\"card-subtitle mb-2 text-dark\">Distrito: ".$numero_distrito."</h4>";
			    }else{
			    	//echo "<h4 class=\"card-subtitle mb-2 text-muted\">".$row->endereco."</h4>";
			    	echo "<h4 class=\"card-subtitle mb-2 text-muted\"></h4>";
			    }
			    
			    echo "</div><hr>";
			  
			    


			echo "<h4 class=\"card-text text-center\">".$data."</h4>
			<h5 class=\"card-text text-left\">".$roteiro."</h5>
			    <h5 class=\"card-text text-left\"><b>Gerente:</b> ".ucwords(strtolower($row->gerente))."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_gerente, 0, 5)."-".substr($row->tel_gerente, 5, 8)."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_gerente2, 0, 5)."-".substr($row->tel_gerente2, 5, 8)."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_centro, 0, 4)."-".substr($row->tel_centro, 4, 7)."</h5>
			    <hr>";
			    /*
			    if($motorista){
			    	echo "<h4 class=\"card-subtitle mb-2 alert alert-primary\" role=\"alert\">".$motorista."</h4><hr>";
			    }
			    */
			    //echo "<a href=\"#\" class=\"btn btn-primary card-link text-center\">Inscrever-se</a>";
			//echo "<button id=\"inscrever_plantao\" type=\"button\" class=\"btn btn-primary card-link text-center\" data-toggle=\"modal\" data-target=\"#modalInscrever\" onclick=\"idPlantao(".$row->id_plantao.");\">Inscrever-se</button>";		    

			if($matricula){		


				$id_colaborador = $this->verificarMatricula($matricula);


			$cadastrado = $this->verificarCadastroPlantao($id_colaborador, $id_plantao);
			$vagas_disponiveis = $this->contarVagas($id_plantao);
			$vagas_total = $this->vagasDisponiveis($id_plantao);

			if($cadastrado){
				echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Cancelar Inscrição\">";
				echo "<button id=\"cancelar_inscrever_plantao\" type=\"button\" class=\"btn btn-danger card-link text-center\" data-toggle=\"modal\" data-target=\"#modalCancelInscrever\" onclick=\"idPlantao(".$id_plantao.");\">Cancelar</button>";
				echo "</span>";
			}else{
				if($vagas_disponiveis){

					$mesmo_horario = $this->plantaoMesmoHorario($_SESSION['matricula'], $id_plantao);
					
					if($mesmo_horario){

						echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Você já está inscrito em plantão no mesmo horário\">";
						echo "<button id=\"inscrever_plantao\" type=\"button\" class=\"btn btn-primary card-link text-center\" data-toggle=\"modal\" data-target=\"#modalInscrever\" onclick=\"idPlantao(".$id_plantao.");\"  style=\"pointer-events: none;\" disabled>Inscrever-se</button>";
						echo "</span>";

					}else if(($row->trabalho == "TRATAMENTO" || $row->trabalho == "Tratamento" || $row->trabalho == "tratamento") && !$mesmo_horario){

						echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Inscrição\">";
						echo "<button id=\"inscrever_plantao\" type=\"button\" class=\"btn btn-primary card-link\" onclick=\"idPlantao(".$id_plantao.");\" data-toggle=\"modal\" data-target=\"#modalInscreverTratamento\">Inscrever-se</button>";
						echo "</span>";

					}else if(!$mesmo_horario){

						echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Inscrição\">";
						echo "<button id=\"inscrever_plantao\" type=\"button\" class=\"btn btn-primary card-link\" onclick=\"idPlantao(".$id_plantao.");\" data-toggle=\"modal\" data-target=\"#modalInscreverMotorista\">Inscrever-se</button>";
						echo "</span>";
					}
					
					
					
				}else{
					echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Vagas Esgotadas.\">";
					echo "<button id=\"inscrever_plantao\" type=\"button\" class=\"btn btn-secundary card-link text-center\" data-toggle=\"modal\" data-target=\"#modalInscrever\" onclick=\"idPlantao(".$id_plantao.");\"  style=\"pointer-events: none;\" disabled>Inscrever-se</button>";
					echo "</span>";
				}
				
			}

			$gerente = $this->verificarGerente($_SESSION['matricula']);
			$unid = $this->plantaoUnidade($id_plantao);
			if($gerente == $unid){
				$gerente = true;
			}else{
				$gerente = false;
			}

			$adm = $this->verificarAdministrador($matricula);


				if($adm || $gerente || true){

					if($vagas_disponiveis != $vagas_total){
						$id_plantao_64 = base64_encode($id_plantao);
						
					 echo "<a id=\"btn_inscritos\" href=\"inscritos_plantao.php?p=".$id_plantao_64."\" class=\"btn btn-info card-link\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Veja a lista de inscritos.\" ><b>Vagas Disponíveis:</b> <span class=\"badge badge-dark\">". $vagas_disponiveis ." / ". $vagas_total ."</span></a>";

					}else{
						echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Nenhum inscrito no momento.\">";
						echo "<button id=\"btn_inscritos\" type=\"button\" class=\"btn btn-secundary card-link\" onclick=\"verInscritos(".$id_plantao.");\" style=\"pointer-events: none;\" disabled><b>Vagas Disponíveis:</b> <span class=\"badge badge-light text-light\">". $vagas_disponiveis ." / ". $vagas_total ."</span></button>";
						echo "</span>";
					}

				}else{

					if($vagas_disponiveis > 0){

					echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Há vaga disponível.\">";
					 echo "<button type=\"button\" class=\"btn btn-secundary card-link\">Vagas Disponíveis: <span class=\"badge badge-light\">". $vagas_disponiveis ." / ". $vagas_total ."</span></button>";
					 echo "</span>";

					}else{

						echo "<span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Não há mais vaga disponível.\">";
					 echo "<button type=\"button\" class=\"btn btn-secundary card-link\" style=\"pointer-events: none;\" disabled>Vagas Disponíveis: <span class=\"badge badge-light\">". $vagas_disponiveis ." / ". $vagas_total ."</span></button>";
					 echo "</span>";

					}
				}
			}
			
			  echo "</div>
			  		</div>					
					</div>";

			$i++;
			
			//}

			}

			echo "</div>
					
					<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<h4 class=\"lead text-justify\"><br><hr><b>Benefícios</b> - Para trabalhos aos sábados ou em trabalho no CTE durante a madrugada, desde que seja jornada dupla, o empregado terá direito a <b>uma folga</b>. Para trabalho aos domingos o empregado terá direito a <b>duas folgas.</b></h4>
					</div>
					</div>
					<hr>
					<br>";


		}else{
			echo "<div class=\"col-12 align-self-center\"><div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\"><h1 class=\"display-4\">Não Há Plantões Ativos</h1></div>";

		}

	}//listar plantao


	


	//listar plantões cancelados
	public function listarPlantaoCancelado(){

		
		$sql = "SELECT p.*, u.* FROM plantao as p INNER JOIN unidades as u ON p.id_unidade = u.id_unidade WHERE p.status = :status ORDER BY p.turno_inicio DESC";
		$dados = array(":status" => 0);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();

		if($quant > 0){				
			$i = 0;
		

			 echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\">
				      <h1 class=\"display-4\">Plantões Cancelados</h1>      
				    </div>
					</div>
					</div>";

					echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-sm-12 col-md-8 col-lg-6  align-self-center\">
					<div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\">
				      <h4 class=\"lead text-center\">Permitido editar e reativar plantões.</h4>				      
				    </div>
					</div>						
					</div>
					";


			echo "<div class=\"row justify-content-md-center\">";

			foreach ($resultado as $row) {		


				$funcoes = new funcoes();
			    $data = $funcoes->montarDataPlantao($row->turno_inicio, $row->turno_final);
			    $id_plantao = $row->id_plantao;
			    $motorista = $row->motorista;
			
				$adm = false;
				$matricula = false;
			 	if(isset($_SESSION['matricula'])){

					$matricula = $_SESSION['matricula'];
			    	$adm = $this->verificarAdministrador($matricula);
				}

			echo "<div class=\"col-sm-12 col-md-6 col-lg-4 text-center\" style=\"margin-top: 15px; margin-bottom: 15px;\">
			<div class=\"card\">

			  <div class=\"card-body border border-dark\">
			  	<div class=\"alert alert-secondary\" role=\"alert\">";
			  	if($adm){
			  		echo "<i class=\"material-icons float-left btn-outline-info\" style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#modalPlantao\" onclick=\"editPlantao(".$id_plantao.");\">edit</i>
			  	<i class=\"material-icons float-right btn-outline-danger\" style=\"cursor: pointer;\" data-toggle=\"modal\" data-target=\"#modalReativar\" onclick=\"ativarPlantao(".$id_plantao.");\">undo</i>";
			  	}
			  	
			    echo "<h3 class=\"card-title\">".$row->nome."<br>".ucwords(strtolower($row->trabalho))."</h3>
			    <h4 class=\"card-subtitle mb-2 text-muted\">".$row->endereco."</h4>
			    </div>			    			    
			    <hr>";
			    



			echo "<h4 class=\"card-text text-center\">".$data."</h4><br>
			    <h5 class=\"card-text text-left\"><b>Gerente:</b> ".ucwords(strtolower($row->gerente))."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_gerente, 0, 5)."-".substr($row->tel_gerente, 5, 8)."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_gerente2, 0, 5)."-".substr($row->tel_gerente2, 5, 8)."</h5>
			    <h5 class=\"card-text text-left\"><b>Telefone:</b> ".substr($row->tel_centro, 0, 4)."-".substr($row->tel_centro, 4, 7)."</h5>
			    <hr>";
			    
			
			  echo "</div>
			  		</div>					
					</div>";

			$i++;
			
			

			}

		
		}else{
			echo "<div class=\"col-12 align-self-center\"><div class=\"pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center\"><h1 class=\"display-4\">Não Há Plantões Cancelados</h1></div>";

		}





	}//listar plantao



	//contar vagas disponíveis
	public function contarVagas($id_plantao){
		
		$sql =  "SELECT COUNT(id_plantao) AS quant FROM cadastrados WHERE id_plantao = :id_plantao AND status = :status";
		$dados = array(":id_plantao" => $id_plantao, ":status" => 1);
		$query = conecta::executarSQL($sql, $dados);
		$quant = $query->fetchAll(PDO::FETCH_OBJ);
		
		foreach ($quant as $row) {

			$quant = $row->quant;
		}

		$vagas = $this->vagasDisponiveis($id_plantao);

		return (int) ($vagas - $quant);
	}



	public function vagasDisponiveis($id_plantao){

		$sql = "SELECT vagas FROM plantao WHERE id_plantao = :id_plantao AND status = :status";
		$dados = array(":id_plantao" => $id_plantao, ":status" => 1);
		$query = conecta::executarSQL($sql, $dados);
		$vagas = $query->fetchAll(PDO::FETCH_OBJ);

		foreach ($vagas as $row) {

			$vagas = $row->vagas;
		}

		return (int) $vagas;

	}




	//verificar se é administrador
	public function verificarAdministrador($matricula){
		$sql = "SELECT a.id_administrador, a.id_colaborador FROM administrador AS a LEFT JOIN colaboradores AS c ON a.id_colaborador = c.id_colaborador WHERE c.matricula = :matricula AND a.status = :status";

			$dados = array(':matricula' => $matricula, ":status" => 1);
			$query = conecta::executarSQL($sql, $dados);
			//$resultado = $query->fetchAll(PDO::FETCH_OBJ);		

			$result = $query->rowCount();
			if($result){
				$result = true;
			}else{
				$result = false;
			}

			return $result;
	}


//verificar se o colaborador já está cadastrado no plantao
	public function verificarCadastroPlantao($id_colaborador, $id_plantao){

		$sql = "SELECT id_cadastrado FROM cadastrados WHERE id_plantao = :id_plantao AND id_colaborador = :id_colaborador";

			$dados = array(':id_plantao' => $id_plantao, ':id_colaborador' => $id_colaborador);

			$query = conecta::executarSQL($sql, $dados);
			$resultado = $query->fetchAll(PDO::FETCH_OBJ);
			$result = "";		
			foreach ($resultado as $row) {
				$result = $row->id_cadastrado;
			}
			
			if($result){
				$result = true;
			}else{
				$result = false;
			}
			
			return $result;
	}







	//botao cadastrar - deve ser apresentado somente para os administradores do sistema
	public function botaoCadastrarPlantao(){

		if(isset($_SESSION['matricula'])){
			$matricula = $_SESSION['matricula'];

			//$sql = "SELECT c.id_colaborador FROM colaboradores AS c LEFT JOIN a.id_aministrador  WHERE c.matricula = :matricula";
			$adm = $this->verificarAdministrador($matricula);
			$gerente = $this->verificarGerente($matricula);
			
			if($adm){
				echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-8  text-center\">
					<h4>Clique no botão abaixo para cadastrar um novo plantão ou uma unidade.</h4><br>
					</div>
					</div>

					<div class=\"row justify-content-around\">
					<div class=\"col text-center\">						
						<button type=\"button\" class=\"btn btn-outline-info border-info\" data-toggle=\"modal\" data-target=\"#modalPlantao\" onclick=\"limparForm();\">Cadastrar Plantão</button>

					</div>
					<div class=\"col text-center\">
						<a href=\"listar_plantao.php\" class=\"btn btn-outline-info border-info\">Plantões Ativos</a>
					</div>
					<div class=\"col text-center\">
						<a href=\"plantao_passado.php\" class=\"btn btn-outline-info border-info\">Plantões Anteriores</a>
					</div>
					<div class=\"col text-center\">
						<a href=\"plantao_cancelado.php\" class=\"btn btn-outline-info border-info\">Plantões Cancelados</a>
					</div>
					<div class=\"col text-center\">
						<button type=\"button\" class=\"btn btn-outline-info border-info\" data-toggle=\"modal\" data-target=\"#modalUnidade\">Cadastrar Unidade</button>

					</div>
					<div class=\"col text-center\">
						<button type=\"button\" class=\"btn btn-outline-info border-info\" data-toggle=\"modal\" data-target=\"#modalDistritos\">Cadastrar Distritos</button>

					</div>					
					</div>";

			}else if($gerente){

				echo "<div class=\"row justify-content-md-center\">
					<div class=\"col-8  text-center\">
					<h4>Clique no botão abaixo para listar plantões ativos ou plantões que já foram realizados.</h4><br>
					</div>
					</div>

					<div class=\"row justify-content-around\">
					<div class=\"col-4 text-center\">
						<a href=\"listar_plantao.php\" class=\"btn btn-outline-info border-info\">Plantões Ativos</a>
					</div>
					<div class=\"col-4 text-center\">
						<a href=\"plantao_passado.php\" class=\"btn btn-outline-info border-info\">Plantões Anteriores</a>
					</div>	
						
					</div>";

			}
		}else{
			echo "<script> window.location.href='../index.php';</script>";
		}

		
	}



	public function verificarMatricula($matricula){

		$sql = "SELECT id_colaborador FROM colaboradores WHERE matricula = :matricula AND status = :status";
			$dados = array(":matricula"  => $matricula, ":status" => 1);

			$query = conecta::executarSQL($sql, $dados);
			$resultado = $query->fetch(PDO::FETCH_OBJ);
			$quant = $query->rowCount();
			if($quant){
				return (int) $resultado->id_colaborador;
			}else{
				return false;
			}

	}


	public function cadastrarInscricao($id_colaborador, $id_plantao, $motorista){
		
		$sql = "INSERT INTO cadastrados (id_colaborador, id_plantao, motorista) VALUES (:id_colaborador, :id_plantao, :motorista)";
			$dados = array(":id_colaborador" => $id_colaborador, ":id_plantao"  => $id_plantao, ":motorista"  => $motorista);

			$cadastro = $this->verificarCadastroPlantao($id_colaborador, $id_plantao);

			if($cadastro != "false"){

				$query = conecta::executarSQL($sql, $dados);
				$resultado = $query->fetch(PDO::FETCH_OBJ);
				$quant = conecta::lastidSQL();
				if($quant){
					return (int) $quant;
				}else{
					return false;
				}


			}else{
				return false;
			}
			


	}




	public function motorista($id_plantao){

		$sql = "SELECT motorista FROM plantao WHERE id_plantao = :id_plantao AND status = :status";
			$dados = array(":id_plantao"  => $id_plantao, ":status" => 1);

			$query = conecta::executarSQL($sql, $dados);
			$resultado = $query->fetch(PDO::FETCH_OBJ);
			$quant = $query->rowCount();
			if($quant){
				return $resultado;
			}else{
				return false;
			}


	}



	public function cancelarInscricao($id_plantao, $matricula){
			
			$id_colaborador = $this->verificarMatricula($matricula);
			$sql = "SELECT * FROM cadastrados WHERE id_plantao = :id_plantao AND id_colaborador = :id_colaborador";
			$dados = array(":id_plantao" => $id_plantao, ":id_colaborador" => $id_colaborador);
			$query = conecta::executarSQL($sql, $dados);
			$resultado = $query->fetchAll(PDO::FETCH_OBJ);

			$id_cadastrado = 0;
			$motorista = 0;
			$presenca = NULL;
			$status = 1;
			$data = "";

			foreach ($resultado as $row) {
				$id_cadastrado = $row->id_cadastrado;
				$motorista = $row->motorista;
				$presenca = $row->presenca;
				$status = $row->status;
				$data = $row->data;
			}


			$sql = "INSERT INTO inscricao_cancelada (id_cadastrado, id_colaborador, id_plantao, motorista, presenca, status, data_cad) VALUES (:id_cadastrado, :id_colaborador, :id_plantao, :motorista, :presenca, :status, :data_cad)";
			$dados = array(":id_cadastrado" => $id_cadastrado, ":id_colaborador" => $id_colaborador, ":id_plantao" => $id_plantao, ":motorista" => $motorista, ":presenca" => $presenca, ":status" => $status, ":data_cad" => $data);

			$query = conecta::executarSQL($sql, $dados);
			$resultado = $query->fetch(PDO::FETCH_OBJ);
			$quant = conecta::lastidSQL();

			if($quant){


				$sql = "DELETE FROM cadastrados WHERE id_cadastrado = :id_cadastrado";

				//$sql = "UPDATE cadastrados SET status = :status WHERE id_plantao = :id_plantao AND id_colaborador = :id_colaborador";
				$dados = array(":id_cadastrado" => $id_cadastrado);

				$query = conecta::executarSQL($sql, $dados);
				//$resultado = $query->fetch();
				//$quant = conecta::lastidSQL();
				
				if($query){
					return true;
				}else{
					return false;
				}



			}else{
				return false;
			}




			


	}




	public function verInscritos($id_plantao){

		$sql = "SELECT cad.id_cadastrado AS id_cadastrado, cad.id_colaborador AS id_colaborador, cad.presenca AS presenca, cad.motorista, colab.nome AS nome, colab.lotacao AS lotacao FROM cadastrados AS cad INNER JOIN colaboradores AS colab ON cad.id_colaborador = colab.id_colaborador WHERE cad.id_plantao = :id_plantao ORDER BY nome ASC";
		$dados = array(":id_plantao" => $id_plantao);

		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();
		$usuario_presente = false;

		$gerente = $this->verificarGerente($_SESSION['matricula']);
		$adm = $this->verificarAdministrador($_SESSION['matricula']);
			
		if($quant > 0){

			//$sql = "SELECT COUNT(turno_final) AS quant, motorista, turno_inicio, turno_final FROM plantao WHERE id_plantao = :id_plantao AND turno_final < now()";

			$sql = "SELECT COUNT(turno_final) AS quant, motorista, turno_inicio, turno_final FROM plantao WHERE id_plantao = :id_plantao";
			$dados = array(":id_plantao" => $id_plantao);
			$query = conecta::executarSQL($sql, $dados);
			$data = $query->fetchAll(PDO::FETCH_OBJ);
			$presenca = false;
			$motorista = false;
			$jornada = null;
			$final = null;
			foreach ($data as $d => $v_data) {
				$motorista = $v_data->motorista;
				$turno_final = $v_data->quant;
				if($turno_final > 0){
					$presenca = true;
					$inicio = new DateTime($v_data->turno_inicio);
					$inicio->format("Y-m-d H:i:s");
					$final = new DateTime($v_data->turno_final);
					$final->format("Y-m-d H:i:s");
					$jornada = $inicio->diff($final);
					$jornada = $jornada->h;
				}
			}
			
			$id_cadastrado = NULL;

			//se o plantão precisar de motorizados
			if($motorista){
				$i = 1;
				$quant_motorista = 0;
				$quant_pedestre = 0;
				foreach ($resultado as $row) {
					$id_cadastrado = $row->id_cadastrado;

					echo "<tr>
				      <th scope=\"row\" class=\"text-center\">$i</th>";
				      if($row->motorista){				      	
				      	$quant_motorista++;
				     	 echo "<td><div class=\"form-check\">
					        <i class=\"material-icons\">local_shipping</i>
					      </div></td>";
			     	

				      }else if(!$row->motorista){				      	
				      	$quant_pedestre++;
				      	echo "<td><div class=\"form-check\">
					        <i class=\"material-icons\">directions_walk</i>
					      </div></td>";
					  	
				      }
				      $final = date("Y-m-d H:i:s",strtotime($final->format("Y-m-d H:i:s")));
				      $agora = date("Y-m-d H:i:s",time());
				        if($presenca && $final < $agora && ($gerente || $adm)){		     
				   		$usuario_presente = $row->presenca;

				   		$sql = "SELECT entrada1, saida1, entrada2, saida2 FROM presenca WHERE id_cadastrado = :id_cadastrado";
				   		$dados = array(":id_cadastrado" => $id_cadastrado);
				   		$query = conecta::executarSQL($sql, $dados);
				   		$horario = $query->fetchAll(PDO::FETCH_OBJ);
				   		$h1 = null;
				   		$h2 = null;
				   		$h3 = null;
				   		$h4 = null;

				   		foreach ($horario as $hora) {
				   			$h1 = $hora->entrada1;
				   			$h2 = $hora->saida1;
				   			$h3 = $hora->entrada2;
				   			$h4 = $hora->saida2;
				   		}

				   		if($usuario_presente == '1'){
				   			echo "<div class=\"form-check\">";
				   				//echo "<i class=\"material-icons\">check</i>";
				   			if($h1 != NULL){
				   				$h1 = new DateTime($h1);
				   				$h1 = $h1->format("H:i");

				   				echo "<td><div class=\"form-group\">
				   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario1=\"horario1[]\" placeholder=\"hh:mm\" value=\"".$h1."\">				   						
				   					</div></td>";
				   			}
				   			if($h2 != NULL){
				   				$h2 = new DateTime($h2);
				   				$h2 = $h2->format("H:i");
				   				echo "<td><div class=\"form-group\">
				   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario2=\"horario2[]\" placeholder=\"hh:mm\" value=\"".$h2."\">
				   					</div></td>";
				   			}
				   			if($h3 != NULL){
				   				$h3 = new DateTime($h3);
				   				$h3 = $h3->format("H:i");
			   					echo "<td><div class=\"form-group\">
			   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario3=\"horario3[]\" placeholder=\"hh:mm\" value=\"".$h3."\">
			   					</div></td>";
			   				}
			   				if($h4 != NULL){
			   					$h4 = new DateTime($h4);
				   				$h4 = $h4->format("H:i");
			   					echo "<td><div class=\"form-group\">
			   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario4=\"horario4[]\" placeholder=\"hh:mm\" value=\"".$h4."\">
			   					</div></td>";
			   				}
				   				
				   			

				   			echo "</div>";

				   		}else if($usuario_presente == '0'){
				   			echo "<td><div class=\"form-check\">
				   				<i class=\"material-icons\">clear</i>
				   				</div></td>";

				   		}if($usuario_presente == null){				   			
				   			echo "<td><div class=\"form-group\">
				   				
				   				<input type=\"hidden\" name=\"user[]\" value=\"$id_cadastrado\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario1=\"horario1[]\" placeholder=\"hh:mm\">
				   					</div>				   					
				   					</td>

				   					<td>
				   					<div class=\"form-group\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario2=\"horario2[]\" placeholder=\"hh:mm\">
				   					</div>				   					
				   					</td>";
				   					if($jornada >= 8){

				   						echo "<td>
				   					<div class=\"form-group\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario3=\"horario3[]\" placeholder=\"hh:mm\">
				   					</div>
				   					</td>

				   					<td>
				   					<div class=\"form-group\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario4=\"horario4[]\" placeholder=\"hh:mm\">
				   					</div>
				   					</td>";

				   					}
				   				
				   		}
					      	
				      	
					      
					   }
				    echo  "<td>$row->nome</td>
				      		<td>$row->lotacao</td>";
				       
					echo "</tr>";
				    $i++;

				}	

				echo "<tr class=\"table-light\">
				<td><br></td>				
				<td><br></td>				
				<td><br></td>
				<td><br></td>";
				if($presenca){	
					if($jornada >= 8){
						echo "<td><br></td>";
						echo "<td><br></td>";
					}else{
						echo "<td><br></td>";
					}
					
				}
				echo "</tr>";

				$total = $quant_motorista + $quant_pedestre;
				/*
				echo "<tr class=\"table-light\">
				<td><b>Total:</b></td>
				<td> $total</td>
				<td><br></td>
				<td><br></td>";
				if($presenca){	
					if($jornada >= 8){
						echo "<td><br></td>";
						echo "<td><br></td>";
					}else{
						echo "<td><br></td>";
					}
					
				}
				echo "</tr>";
				*/
				echo "<tr class=\"table-success\">
				<td><b>Total:</b></td>
				<td> $total</td>";
				if($presenca){	
					if($jornada >= 8){
						echo "<td colspan=\"10\"><br></td>";						
					}else{
						echo "<td colspan=\"6\"><br></td>";
					}
					
				}else{
						echo "<td colspan=\"6\"><br></td>";
					}
				echo "</tr>";

			//se o plantão não precisar de motorista
			}else{
				$total = 0;
				$i = 1;

				$h1 = null;
		   		$h2 = null;
		   		$h3 = null;
		   		$h4 = null;
		   		$usuario_presente = NULL;

				foreach ($resultado as $row) {
					$id_cadastrado = $row->id_cadastrado;
					$usuario_presente = $row->presenca;
					$sql = "SELECT entrada1, saida1, entrada2, saida2 FROM presenca WHERE id_cadastrado = :id_cadastrado";
			   		$dados = array(":id_cadastrado" => $id_cadastrado);
			   		$query = conecta::executarSQL($sql, $dados);
			   		$horario = $query->fetchAll(PDO::FETCH_OBJ);
				   		

				   		foreach ($horario as $hora) {
				   			$h1 = $hora->entrada1;
				   			$h2 = $hora->saida1;
				   			$h3 = $hora->entrada2;
				   			$h4 = $hora->saida2;
				   		}
					$total++;
					echo "<tr>
					<th scope=\"row\" class=\"text-center\">$i</th>";

					echo "<td><div class=\"form-check\">
					        <i class=\"material-icons\">title</i>
					      </div></td>";
				  
				        //if($presenca){					        
					      $final = date("Y-m-d H:i:s",strtotime($final->format("Y-m-d H:i:s")));
				      $agora = date("Y-m-d H:i:s",time());
				        if($presenca && $final < $agora && ($gerente || $adm)){

				   		if($usuario_presente == '1'){
				   			echo "<div class=\"form-check\">";
				   				//echo "<i class=\"material-icons\">check</i>";
				   			if($h1 != NULL){
				   				$h1 = new DateTime($h1);
				   				$h1 = $h1->format("H:i");

				   				echo "<td><div class=\"form-group\">
				   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario1=\"horario1[]\" placeholder=\"hh:mm\" value=\"".$h1."\">				   						
				   					</div></td>";
				   			}
				   			if($h2 != NULL){
				   				$h2 = new DateTime($h2);
				   				$h2 = $h2->format("H:i");
				   				echo "<td><div class=\"form-group\">
				   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario2=\"horario2[]\" placeholder=\"hh:mm\" value=\"".$h2."\">
				   					</div></td>";
				   			}
				   			if($h3 != NULL){
				   				$h3 = new DateTime($h3);
				   				$h3 = $h3->format("H:i");
			   					echo "<td><div class=\"form-group\">
			   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario3=\"horario3[]\" placeholder=\"hh:mm\" value=\"".$h3."\">
			   					</div></td>";
			   				}
			   				if($h4 != NULL){
			   					$h4 = new DateTime($h4);
				   				$h4 = $h4->format("H:i");
			   					echo "<td><div class=\"form-group\">
			   						<input class=\"form-control-plaintext mx-mb-2 text-center\" readonly type=\"text\" horario4=\"horario4[]\" placeholder=\"hh:mm\" value=\"".$h4."\">
			   					</div></td>";
			   				}
				   				
				   			

				   			echo "</div>";

				   		}else if($usuario_presente == '0'){
				   			if($jornada >= 8){
				   				echo "<td colspan=\"4\"><div class=\"form-check\">
				   				<i class=\"material-icons text-danger\">clear</i>
				   				</div></td>";
				   			}else{
				   				echo "<td colspan=\"2\"><div class=\"form-check\">
				   				<i class=\"material-icons text-danger\">clear</i>
				   				</div></td>";
				   			}
				   			

				   		}if($usuario_presente == null){			

				   			//echo "<input class=\"form-check-input\" type=\"checkbox\" name=\"user[]\" value=\"$row->id_colaborador\"><br>";	   			
								
								echo "<td><div class=\"form-group\">
				   				
				   				<input type=\"hidden\" name=\"user[]\" value=\"$row->id_cadastrado\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario1=\"horario1[]\" placeholder=\"hh:mm\">
				   					</div>				   					
				   					</td>

				   					<td>
				   					<div class=\"form-group\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario2=\"horario2[]\" placeholder=\"hh:mm\">
				   					</div>				   					
				   					</td>";

				   					if($jornada >= 8){

				   						echo "<td>
				   					<div class=\"form-group\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario3=\"horario3[]\" placeholder=\"hh:mm\">
				   					</div>
				   					</td>

				   					<td>
				   					<div class=\"form-group\">
				   						<input class=\"form-control mx-mb-2 text-center\" type=\"text\" horario4=\"horario4[]\" placeholder=\"hh:mm\">
				   					</div>
				   					</td>";

				   					}


				   		}     
				   	
					      	
				      	//echo "<td><div class=\"form-check\">
					        //<input class=\"form-check-input\" type=\"checkbox\" name=\"user[]\" value=\"$row->id_colaborador\">
					     // </div></td>";
					      
					   }
				    echo  "<td>$row->nome</td>
				      <td>$row->lotacao</td>";
				       
					echo "</tr>";
				    $i++;

				}

				


				echo "<tr class=\"table-success\">
				<td><b>Total:</b></td>
				<td> $total</td>";
				if($presenca){	
					if($jornada >= 8){
						echo "<td colspan=\"10\"><br></td>";						
					}else{
						echo "<td colspan=\"6\"><br></td>";
					}
					
				}else{
						echo "<td colspan=\"6\"><br></td>";
					}
				

			}

			echo "<input class=\"form-check-input\" type=\"hidden\" id=\"pre_id_plantao\" name=\"id_plantao\" value=\"".$id_plantao."\"><br>";	   			
				echo "</tr>";
				
	

			
			return $resultado;

		}else{
			return false;
		}

		

	}
	
	
	public function verificarGerente($matricula){

		$sql = "SELECT count(id_unidade) AS quant, id_unidade FROM unidades WHERE matricula = :matricula";
		$dados = array(":matricula" => $matricula);

		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$result = "";
		$id = null;		
		foreach ($resultado as $row) {
			$result = $row->quant;
			$id = $row->id_unidade;
		}

		if($result == 1){
			return $id;
		}else{
			return false;
		}

	}



	public function plantaoUnidade($id_plantao){

		$sql = "SELECT id_unidade FROM plantao WHERE id_plantao = :id_plantao";
		$dados = array(":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();
		$id_unidade = null;

		if($quant > 0){
			foreach ($resultado as $row) {
				$id_unidade = $row->id_unidade;
			}
			return $id_unidade;
		}else{
			return false;
		}



	}

	public function dadosPlantao($id_plantao){
		$sql = "SELECT * FROM plantao WHERE id_plantao = :id_plantao";
		$dados = array(":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();

		if($quant > 0){
			return $resultado;
		}else{
			return false;
		}


	}


	public function dadosUnidade($id_unidade){

		$sql = "SELECT * FROM unidades WHERE id_unidade = :id_unidade";
		$dados = array(":id_unidade" => $id_unidade);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$quant = $query->rowCount();
		if($quant > 0){
			return $resultado;
		}else{
			return false;
		}


	}

	public function plantaoMesmoHorario($matricula, $id_plantao){

			$id_colaborador = $this->verificarMatricula($matricula);
			$dadosPlantao = $this->dadosPlantao($id_plantao);
			$turno_inicio = null;
			$turno_final = null;
			foreach ($dadosPlantao as $row) {
				$turno_inicio = $row->turno_inicio;
				$turno_final = $row->turno_final;
			}

			$sql = "SELECT DISTINCT c.id_colaborador AS id FROM cadastrados AS c INNER JOIN plantao AS p ON c.id_plantao = p.id_plantao AND c.id_colaborador = :id_colaborador WHERE (p.turno_inicio BETWEEN :turno_inicio AND :turno_final) OR (p.turno_final BETWEEN :turno_inicio2 AND :turno_final2)";
			$dados = array(":id_colaborador" => $id_colaborador, ":turno_inicio" => $turno_inicio, "turno_final" => $turno_final, ":turno_inicio2" => $turno_inicio, "turno_final2" => $turno_final);
			$query = conecta::executarSQL($sql, $dados);
			$resultado = $query->fetchAll(PDO::FETCH_OBJ);
			//var_dump($resultado);
			$ids = 0;
			foreach ($resultado as $row) {
				$ids = $row->id;
			}

			if($ids != 0){
				return $ids;
			}else{

				return false;	
			}
			


	}

	//public function horaCamposMarcados($data_turno, $campoMarcado){
	public function horaCamposMarcados($data_inicio, $data_final, $campoMarcado){

		$hora = null;
		$data_turno = null;
		$inicio = $data_inicio;
		$final = $data_final;
		$ini = $inicio->modify("-2 hours");
		$ini = $inicio->format("Y-m-d H:i:s");

		$fim = $final->modify("+2 hours");
		$fim = $final->format("Y-m-d H:i:s");

		$turno_inicio = $inicio->format('Y-m-d');
		$turno_final = $final->format('Y-m-d');


		if($turno_inicio == $turno_final){
			

			if($campoMarcado != null){
				$data_turno = $turno_inicio;
				$hora = $data_turno." ".$campoMarcado;
				$hora = new DateTime($hora);
				$hora = $hora->format("Y-m-d H:i:s");
				if($hora < $ini || $hora > $fim){
					$hora = null;
				}

			}

		}else{

			if($campoMarcado != null){

				$data_turno = $turno_inicio;
				$hora = $data_turno." ".$campoMarcado;
				$hora = new DateTime($hora);
				$hora = $hora->format("Y-m-d H:i:s");

				if($hora < $ini){
					$data_turno = $turno_final;
					$hora = $data_turno." ".$campoMarcado;
					$hora = new DateTime($hora);
					$hora = $hora->format("Y-m-d H:i:s");
					
				}					
			}

		}

		if($hora >= $ini && $hora <= $fim){
			return $hora;
		}else{
			return null;
		}

		//return $hora;

	}



	public function registrarHorarios($id_plantao, $id_cadastrado, $camposMarcados1, $camposMarcados2, $camposMarcados3, $camposMarcados4){
		date_default_timezone_set('America/Sao_Paulo');
		$turno_inicio = null;
		$turno_final = null;
		$data_turno = null;
		$jornada = null;
		
		$sql = "SELECT turno_inicio, turno_final FROM plantao WHERE id_plantao = :id_plantao";
		$dados = array(":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		
		$presencas = array();
		$quant = count($id_cadastrado);
		
		for($i = 0; $i < $quant; $i++){

			foreach ($resultado as $row){

				$turno_inicio = new DateTime($row->turno_inicio);
				$turno_inicio->format("Y-m-d H:i:s");
				$turno_final = new DateTime($row->turno_final);
				$turno_final->format("Y-m-d H:i:s");
				$jornada = $turno_inicio->diff($turno_final);
				$jornada = $jornada->h;

			}
			
			$registro = null;
			$hora1 = null;
			$hora2 = null;
			$hora3 = null;
			$hora4 = null;

			$hora1 = $this->horaCamposMarcados($turno_inicio, $turno_final, $camposMarcados1[$i]);
			$hora2 = $this->horaCamposMarcados($turno_inicio, $turno_final, $camposMarcados2[$i]);
			
			if($jornada >= 8){
				$hora3 = $this->horaCamposMarcados($turno_inicio, $turno_final, $camposMarcados3[$i]);
				$hora4 = $this->horaCamposMarcados($turno_inicio, $turno_final, $camposMarcados4[$i]);
			
			}
											
			$registro = array("id_cadastrado" => $id_cadastrado[$i], "camposMarcados1" => $hora1, "camposMarcados2" => $hora2, "camposMarcados3" => $hora3, "camposMarcados4" => $hora4);

			$presencas[$i] = $registro;		


		}
	 
		$quant = count($presencas);
		$retorno = false;
		
		if($quant > 0){
			for($i = 0; $i < $quant; $i++){

				$retorno = false;

				if($presencas[$i]["camposMarcados1"] != NULL || $presencas[$i]["camposMarcados1"] != NULL || $presencas[$i]["camposMarcados3"] != NULL || $presencas[$i]["camposMarcados4"] != NULL){				

					$sql = "INSERT INTO presenca (id_cadastrado, entrada1, saida1, entrada2, saida2) VALUES (:id_cadastrado, :entrada1, :saida1, :entrada2, :saida2)";
					$dados = array(":id_cadastrado" => $presencas[$i]["id_cadastrado"], ":entrada1" => $presencas[$i]["camposMarcados1"], ":saida1" => $presencas[$i]["camposMarcados2"], ":entrada2" => $presencas[$i]["camposMarcados3"], ":saida2" => $presencas[$i]["camposMarcados4"]);
					$query = conecta::executarSQL($sql, $dados);	
					if($query->rowCount() == 1){
						$retorno = true;
						$this->presenca($presencas[$i]["id_cadastrado"], false);
					}

				}else{
					$retorno = true;
					$this->presenca($presencas[$i]["id_cadastrado"], true);
				}


			}
		}


		return $retorno;


	}



	public function presenca($id_cadastrado, $atualizou){

		//$atualizou = false;

		if($id_cadastrado != 0 && $atualizou == false){
			
			$sql = "UPDATE cadastrados SET presenca = :presenca WHERE id_cadastrado = :id_cadastrado";
			$dados = array(":presenca" => '1', ":id_cadastrado" => $id_cadastrado);
			$query = conecta::executarSQL($sql, $dados);
			if($query->rowCount() > 0){
				$atualizou = true;
			}			

		}

		if($atualizou){
				$atualizou = false;
				$sql = "SELECT * FROM cadastrados WHERE id_cadastrado = :id_cadastrado AND presenca is NULL";
				$dados = array(":id_cadastrado" => $id_cadastrado);
				$query = conecta::executarSQL($sql, $dados);
				$resultado = $query->fetchAll(PDO::FETCH_OBJ);
				
				foreach ($resultado as $row) {
					$id = $row->id_colaborador;
					$sql = "UPDATE cadastrados SET presenca = :presenca WHERE id_cadastrado = :id_cadastrado";
					$dados = array(":presenca" => '0', ":id_cadastrado" => $id_cadastrado);
					$query = conecta::executarSQL($sql, $dados);

					if($query->rowCount() > 0){
						$atualizou = true;
					}else{
						$atualizou = false;
					}
					
				}


			}	


		return $atualizou;

		

	}




	public function presencaStatus($id_plantao){

		$sql = "SELECT COUNT(id_cadastrado) AS quant FROM cadastrados WHERE id_plantao = :id_plantao";
		$dados = array(":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$status = 0;
		foreach ($resultado as $row) {
			$status = $row->quant;
			if($status){
				$status = 0;
				$sql = "SELECT COUNT(id_plantao) AS quant FROM plantao WHERE id_plantao = :id_plantao AND turno_final < now()";
				$dados = array(":id_plantao" => $id_plantao);
				$query = conecta::executarSQL($sql, $dados);
				$resultado = $query->fetchAll(PDO::FETCH_OBJ);
				$status = 0;
				foreach ($resultado as $row) {
					$status = $row->quant;			
				}


			}
		}


		if($status){
			return true;
		}else{
			return false;
		}

	}



	public function presencaRegistrada($id_plantao){

		$sql = "SELECT COUNT(id_cadastrado) AS quant FROM cadastrados WHERE id_plantao = :id_plantao AND presenca IS NOT NULL";
		$dados = array(":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$status = 0;
		foreach ($resultado as $row) {
			$status = $row->quant;
			if($status){
				$status = 0;
				$sql = "SELECT COUNT(id_plantao) AS quant FROM plantao WHERE id_plantao = :id_plantao AND turno_final < now()";
				$dados = array(":id_plantao" => $id_plantao);
				$query = conecta::executarSQL($sql, $dados);
				$resultado = $query->fetchAll(PDO::FETCH_OBJ);
				$status = 0;
				foreach ($resultado as $row) {
					$status = $row->quant;			
				}


			}
		}


		if($status){
			return true;
		}else{
			return false;
		}

	}






	public function deletarPlantao($id_plantao){

		$sql = "UPDATE plantao SET status = :status WHERE id_plantao = :id_plantao";
		$dados = array(":status" => 0, ":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$deletar = conecta::rowCount();
		if($deletar){
			return true;
		}else{
			return false;
		}


	}


	public function reativarPlantao($id_plantao){

		$sql = "UPDATE plantao SET status = :status WHERE id_plantao = :id_plantao";
		$dados = array(":status" => 1, ":id_plantao" => $id_plantao);
		$query = conecta::executarSQL($sql, $dados);
		$resultado = $query->fetchAll(PDO::FETCH_OBJ);
		$reativar = conecta::rowCount();
		if($reativar){
			return true;
		}else{
			return false;
		}


	}




}


?>

