
<?php
include_once '../controle/auto_load.class.php';
new auto_load();
//header("Content-type: application/json");
	//	header("Access-Control-Allow-Origin: *");
	//	header("Content-Type: text/html; charset=UTF-8",true);
	//	header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
		
	$matricula = NULL;	

	//se informar a matricula
	if(isset($_POST['matricula_login']) && $_POST['matricula_login'] != "" && $_POST['matricula_login'] != NULL){

		$funcoes = new funcoes();
		$login = new login();
		$login->setMatricula($funcoes->somenteNumero($_POST['matricula_login']));		
		$usuario = $login->logar();
		
		if($usuario){
			$usuario = json_encode($usuario);	
			var_dump($usuario);

			//return $usuario;
		}else{			
			return false;
		}		


	//se não informar a matricula
	}else{
		return false;
	}







?>