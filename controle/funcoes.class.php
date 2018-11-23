<?php
include_once 'auto_load.class.php';
new auto_load();

class funcoes extends conecta{

	//retorna a string somente com números, remove os demais caracteres
	public function somenteNumero($numero){
		$numero = preg_replace( '/[^0-9]/', '', $numero );
		$numero = trim($numero);
		if($numero != "" && $numero != NULL && $numero != false){
			return (int)$numero;	
		}else{
			return NULL;
		}
	    
	}

	//EXIBIR ERROS NA TELA
	public function mostrarErros(){
		ini_set('display_errors',1);
		ini_set('display_startup_erros',1);
		error_reporting(E_ALL);
	}

	public function charset(){
		header("Content-type: application/json");
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: text/html; charset=UTF-8",true);
		header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
	}
	
	//criptografa senha
	public function criptografar($senha){
		$valor = md5($senha);
		$this->setVariavel('senha', $valor);
	}

	//valida e-mail
	public function validarEmail($email){
		if($email = filter_var($email, FILTER_VALIDATE_EMAIL)){
			return $email;
		}else{
			return false;
		}

	}
	
	//converter string em data
	public function converterData($_date = null) {
		$format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
		if ($_date != null && preg_match($format, $_date, $partes)) {
			return $partes[3].'-'.$partes[2].'-'.$partes[1];
		}
		return false;
	}
	
	
	//converter hora para timestamp
	public function converterHora($hora = null){
		if($hora != null){
			$hora_inicio = $hora;
			$hora_inicio .= ":00";
			$hora_inicio = date("H:i:s", strtotime($hora_inicio));
			return $hora_inicio;
		}else{
			return false;
		}
		
	
	}

	//monta a data SQL para apresentar na página
	public function montarDataPlantao($turno_inicio, $turno_final){

		$data = "";

		$dia_semana_inicio = date("w", strtotime($turno_inicio));
		$data_inicio = date("d/m/Y", strtotime($turno_inicio));
		$hora_inicio = date("H:i:s", strtotime($turno_inicio));
		$dia_semana_final = date("w", strtotime($turno_final));
		$data_final = date("d/m/Y", strtotime($turno_final));
		$hora_final = date("H:i:s", strtotime($turno_final));

		$dia_semana_inicio = $this->diaSemana($dia_semana_inicio);
		$dia_semana_final = $this->diaSemana($dia_semana_final);

		if($data_inicio == $data_final){
			$data = $dia_semana_inicio . ", " . $data_inicio . "<br>" .$hora_inicio . " as " . $hora_final . "<br>";
		}else{
			//$data = $dia_semana_inicio . ", " . $data_inicio . " as " .$hora_inicio . "<br>até<br>". $dia_semana_final . ", " . $data_final ." as ". $hora_final;
			$data = $dia_semana_inicio . ", " . $data_inicio . " as " .$hora_inicio . "<br>a " . $data_final ." as ". $hora_final;
		}

			return $data;

	}

	public function exibirDataPlantao($turno_inicio, $turno_final){

		$data = "";

		$dia_semana_inicio = date("w", strtotime($turno_inicio));
		$data_inicio = date("d/m/Y", strtotime($turno_inicio));
		$hora_inicio = date("H:i:s", strtotime($turno_inicio));
		$dia_semana_final = date("w", strtotime($turno_final));
		$data_final = date("d/m/Y", strtotime($turno_final));
		$hora_final = date("H:i:s", strtotime($turno_final));

		$dia_semana_inicio = $this->diaSemana($dia_semana_inicio);
		$dia_semana_final = $this->diaSemana($dia_semana_final);

		if($data_inicio == $data_final){
			$data = $dia_semana_inicio . ", " . $data_inicio . " de " .$hora_inicio . " às " . $hora_final . "<br>";
		}else{
			//$data = $dia_semana_inicio . ", " . $data_inicio . " as " .$hora_inicio . "<br>até<br>". $dia_semana_final . ", " . $data_final ." as ". $hora_final;
			$data = $dia_semana_inicio . ", " . $data_inicio . " as " .$hora_inicio . " a " . $data_final ." as ". $hora_final;
		}

			return $data;

	}

	public function retornarData($turno_inicio, $turno_final){

		$data = "";

		//$dia_semana_inicio = date("w", strtotime($turno_inicio));
		$data_inicio = date("Y-m-d", strtotime($turno_inicio));
		$hora_inicio = date("H:i:s", strtotime($turno_inicio));
		//$dia_semana_final = date("w", strtotime($turno_final));
		$data_final = date("Y-m-d", strtotime($turno_final));
		$hora_final = date("H:i:s", strtotime($turno_final));

		//$dia_semana_inicio = $this->diaSemana($dia_semana_inicio);
		//$dia_semana_final = $this->diaSemana($dia_semana_final);

		$data = array("data_inicio" => $data_inicio, "data_final" => $data_final, "hora_inicio" => $hora_inicio, "hora_final" => $hora_final);

			return $data;

	}


	//pegar dia da semana
	public function diaSemana($dia_semana){
		$dia = array(0 => 'Domingo',
				1 => 'Segunda-feira',
				2 => 'Terça-feira',
				3 => 'Quarta-feira',
				4 => 'Quinta-feira',
				5 => 'Sexta-feira',
				6 => 'Sábado'
			);

		return $dia[$dia_semana];

	}



}//class funções

?>